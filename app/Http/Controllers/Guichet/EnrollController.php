<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Validator,Redirect,Response;
use Auth;
use Nexmo;
Use App\Models\User;
use App\Models\Engins;
use App\Models\Role;
use App\Models\AgentRef;
use App\Models\TownHall;
use App\Models\EnrollHistory;
use App\Models\SalesHistory;
use App\Models\TempVerificationCode;
use Illuminate\Support\Facades\Hash;
use Session;

class EnrollController extends Controller
{
    public function index()
    {
        $histories = EnrollHistory::where('status', '1')
                                  ->take(30)
                                  ->orderBy('updated_at')
                                  ->get();

        $histories_list       = [];
        foreach($histories as $history){
            $user   = User::find($history->userId);

            $histories_list[]  = [
                'userId'    => $user->id,
                'usager'    => $user->firstname." ".$user->lastname,
                'userphone' => $user->phone,
                'agent'     => $history->agentName.' - '.$history->agentPhone, 
                'enrollId'  => $history->id, 
                'status'    => $history->status, 
                'enginId'   => $history->enginId,
            ]; 
        }



        $histories = $histories_list;

        return view('guichet/enrolls')
               ->with('histories', $histories);
    }



    public function stepOne()
    {
        return view('guichet.enrollViewOne');
    }

    public function stepTwo(int $user_id)
    {
        // dd($user_id);
        return view('guichet.enrollViewTwo')->with('user_id', $user_id)
                                            ->with('success', 'Enrollement partie 1 effectué avec succès!');
    }

    public function postStepOne(Request $request)
    {

        // dd($request->idCard);
        request()->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'idCard'                 => 'required'
        ]);

        //dd($key);
        $data           = $request->all();
        $IfUserExist    = User::where('phone', $request->phone)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('enrollStepOne')
                             ->with('error', 'Ce numéro est pris!')
                             ->withInput();
        }

        $User               = $this->create($data);

        $id                 = $User->id;
        $code               = $User->code;
        $telephone          = $User->phone;
        // $idCardLoaded       = $this->storeIdCard($User);
        $idCardLoaded       = \Storage::disk('public')->putFile('idCard', $request->file('idCard'));

        if($idCardLoaded == False){

            $User->delete();
            return redirect()->route('enrollStepOne')
                             ->with('error', 'Vérifier la connexion internet puis réessayer!.')
                             ->withInput();
        }

        $role = Role::select('id')->where('name', 'user')->first();

        $User->roles()->attach($role);
        $User->save();

        $user_pass = 'password';

        $User->password = Hash::make($user_pass);
        $User->isVerified = 1;
        $User->save();

        // Agent Refs
        $agentRef = AgentRef::where('agentId', Auth::user()->id)->first();

        // Enroll History backUp
        $history = new EnrollHistory();
        $history->agentRef      =   Auth::user()->id;
        $history->agentName     =   Auth::user()->firstname;
        $history->agentPhone    =   Auth::user()->phone;
        $history->userId        =   $User->id;
        $history->save();

       //  $this->sendOPT($telephone, $code, $user_pass);
         return view('guichet.enrollViewTwo');
    }


    public function enrollList()
    {
        $pendingEnrolls = EnrollHistory::where('status', '0')->orderBy('created_at', 'desc')->get();

        // dd($pendingEnrolls);

        $user_list       = [];
        foreach($pendingEnrolls as $pendingEnroll){
            $user        = User::find($pendingEnroll->userId);

            // dd($pendingEnroll->userId);
            $user_list[]  = [
                'userId'    => $user->id,
                'usager'    => $user->firstname." ".$user->lastname,
                'userphone' => $user->phone,
                'guichet'   => $pendingEnroll->guichetRef, 
                'enrollId'  => $pendingEnroll->id, 
                'status'    => $pendingEnroll->status,
            ]; 
        }



        $pendingEnrolls = $user_list;
 
        return view('guichet/enrollHistory')
                ->with('pendingEnrolls', $pendingEnrolls);

    }

    public function poststepTwo(Request $request)
    {

        request()->validate([
            'user_id' 	             => 'required|numeric',
            'marque'                 => 'required|string',
            'modele'                 => 'required|string',
            'mairie' 	             => 'required|string',
            'chassie'                => 'required|string',
            'puissanceFiscale' 	     => 'required|string',
            'documentJustificatif' 	 => 'required|file|image|max:10096',
        ]);

        //dd($key);
        $usager          = User::find($request->user_id);
        $data            = $request->all();
        $IfEnginExist    = Engins::where('chassie', $request->chassie)->first();
        if ($IfEnginExist) {
            # code...
            return redirect()->route('enrollStepTwo', $usager)
                             ->with('error', 'Numero de chassie non disponible!')
                             ->withInput();
        }

        $engin               = $this->createEngin($data);

        // $idCardLoaded       = $this->storeIdCard($User);
        $documentJustificatifLoaded   = \Storage::disk('public')->putFile('DocumentsEngins', $request->file('documentJustificatif'));
        $history = EnrollHistory::where('userId', $usager->id)->first();
        $history->enginId   = $engin->id;
        $history->save();

        
        if($documentJustificatifLoaded == False){

            $engin->delete();
            return redirect()->route('enrollList')
                             ->with('error', 'Erreur d\'enregistrement! Vérifier votre connexion internet puis réessayer.')
                             ->withInput();
        }
        
        return $this->sendOTPEngin($usager->phone, $request->marque, $request->modele, $request->chassie); 
    }


    public function enrollHistory()
    {
        return view('guichet.enrollHistory');
    }


    public function sendOTP($phone, $code, $user_pass)
    {
        // $api_key= getenv('BEEM_KEY');
        // $secret_key = getenv('BEEM_SECRET');

        $user       = User::where('phone', $phone)->first();
        $userId     = $user->id;

        // $OTP = Nexmo::message()->send([
        //                                 'to'   => '+223'.$phone,
        //                                 'from' => '+22369141418',
        //                                 'text' => "ikaVignetti, code de confirmation ".$code."\n\n.
        //                                             Votre mot de passe par defaut: ".$user_pass."\n",
        //                                 ]);



        # OTP TRACK BACKUP
        $TempVerificationCode          = new TempVerificationCode;
        $TempVerificationCode->userId  = $userId;
        $TempVerificationCode->code    = $code;
        $TempVerificationCode->phone   = $phone;
        $TempVerificationCode->save();

        return redirect()->route('enrollStepTwo', $user)->with('success', 'Enrollement partie 1 effectué avec succès!')
                                                        ->with('error', 'Completer l\'enrollement a sur cette page!');
    }

    public function sendOTPEngin($phone, $marque, $modele, $chassie)
    {

        $user       = User::where('phone', $phone)->first();
        $userId     = $user->id;

        // $OTP = Nexmo::message()->send([
        //                                 'to'   => '+223'.$phone,
        //                                 'from' => '+22369141418',
        //                                 'text' => "ikaVignetti, l\'enrollement de votre engin est effectif\n\n\
        //                                             Marque: ".$marque."\n
        //                                             Modele: ".$modele."\n
        //                                             Chassie: ".$chassie."\n",
        //                                 ]);

        $enrollHistory = EnrollHistory::where('userId', $user->id)->first();
        $engin         = Engins::where('chassie', $chassie)->first();
        $enrollHistory->enginId = $engin->id;
        $enrollHistory->status = 1;
        $enrollHistory->save();


        return redirect()->route('enrollList')->with('success', 'Enrollement partie 2 effectué avec succès!');
    }

    private function storeIdCard($user)
    {


        if (request()->has('idCard')) {dd('hi');
            $user->update([
                'idCard' => request()->idCard->store('uploads/userIdCard', 'public'),
            ]);
            return True;
        }
        return False;
    }


    public function create(array $data)
    {

        $code  = rand(100000, 999999);
        $user =  User::create([
            'lastname' 	=> $data['lastname'],
            'firstname' => $data['firstname'],
            'address'   => $data['address'],
            'avatar' 	=> 'avatar.png',
            'phone' 	=> $data['phone'],
            'code'      => $code,
        ]);

        return $user;
    }

    public function createEngin(array $data)
    {
        $engin =  Engins::create([
            'userId' 	        => $data['user_id'],
            'marque'            => $data['marque'],
            'modele'            => $data['modele'],
            'mairie'            => Auth::user()->administration,
            'chassie' 	        => $data['chassie'],
            'puissanceFiscale' 	=> $data['puissanceFiscale'],
        ]);
        
        $tarif = 0;
        if ($engin->puissanceFiscale === "125") {
            $engin->tarif = 6000;
            $engin->save();
        }

        if ($engin->puissanceFiscale === "125+") {
            $engin->tarif = 12000;
            $engin->save();
        }

        return $engin;
    }


}
