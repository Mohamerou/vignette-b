<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Validator,Redirect,Response;
use Auth;
use Nexmo;
Use App\Models\User;
Use App\Models\UsagerAccountType;
use App\Models\Engins;
use App\Models\Role;
use App\Models\AgentRef;
use App\Models\TownHall;
use App\Models\EnrollHistory;
use App\Models\SalesHistory;
use App\Models\TempVerificationCode;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Session;

class EntEnrollController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:intern');      
    }


    public function index()
    {
        $currentYear = Carbon::now();
        $currentYear = Carbon::parse($currentYear);
        $currentYear = $currentYear->format('Y');

        $histories = EnrollHistory::where('status',1)
                                  ->whereYear('created_at', $currentYear)
                                  ->orderBy('updated_at')
                                  ->get();

        $histories_list       = [];
        foreach($histories as $history){
            $createdAt = Carbon::parse($history['created_at']);
            $date      = $createdAt->format('d-m-Y');
            
            $user   = User::find($history->userId);
            $histories_list[]  = [
                'userId'    => $user->id,
                'usager'    => $user->firstname." ".$user->lastname,
                'userphone' => $user->phone,
                'agent'     => $history->agentName.' - '.$history->agentPhone, 
                'enrollId'  => $history->id, 
                'status'    => $history->status, 
                'date'      => $date,
            ]; 
        }



        $histories = $histories_list;

        return view('guichet/enrolls')
               ->with('histories', $histories);
    }



    public function stepOne()
    {        
        $this->middleware('can:guichet'); 
        return view('guichet.entEnrollViewOne');
    }

    public function stepTwo(int $user_id)
    {        
        $this->middleware('can:guichet'); 
        // dd($user_id);
        return view('guichet.entEnrollViewTwo')->with('user_id', $user_id)
                                            ->with('success', 'Enrollement partie 1 effectu?? avec succ??s!');
    }

    public function postStepOne(Request $request)
    {        
        $this->middleware('can:guichet'); 

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
            return redirect()->route('entEnrollStepOne')
                             ->with('error', 'Ce num??ro est pris!')
                             ->withInput();
        }



        $User                   = $this->create($data);
        $id                     = $User->id;
        $code                   = $User->code;
        $telephone              = $User->phone;
        $userIdCardEtx          = $request->file('idCard')->getClientOriginalExtension(); 
        $idCard_storage_path    = 'idCard/idCard-' . time() . '.' .$userIdCardEtx;
        $idCardLoaded           = \Storage::disk('public')->put($idCard_storage_path, file_get_contents($request->file('idCard')));

        $User->idCard           = $idCard_storage_path;
        $User->save();
        
        if($idCardLoaded == False){

            $User->delete();
            return redirect()->route('entEnrollStepOne')
                             ->with('error', 'V??rifier la connexion internet puis r??essayer!.')
                             ->withInput();
        }

        $role = Role::select('id')->where('name', 'user')->first();

        $User->roles()->attach($role);
        $User->save();

        $user_pass      = 'password';
        $account_type   = UsagerAccountType::create([
            'user_id' => $User->id,
            'type'    => $data['account_type'],
        ]);

        $User->password = Hash::make($user_pass);
        $User->isVerified = 1;
        $User->save();

        // Agent Refs
        $agentRef = AgentRef::where('agentId', Auth::user()->id)->first();


        return $this->sendOTP($telephone, $code, $user_pass);
    }


    public function enrollList()
    {        
        $this->middleware('can:guichet'); 
        $pendingEnrolls = EnrollHistory::where('status', '0')->orderBy('created_at', 'desc')->get();

        // dd($pendingEnrolls);

        $user_list       = [];
        foreach($pendingEnrolls as $pendingEnroll){
            $user        = User::find($pendingEnroll->userId);
            $account   = UsagerAccountType::where('user_id',$user->id)->first();
            if(empty($account)){
                return redirect()->route('get-admin-dash')->with('error', 'Compte introuvable !');
            }
            if($account->type==='entreprise'){
            $currentDate = Carbon::parse($pendingEnroll->created_at);
            $currentDate = $currentDate->format('d-m-Y');
            // dd($pendingEnroll->userId);
            $user_list[]  = [
                'userId'    => $user->id,
                'usager'    => $user->firstname." ".$user->lastname,
                'userphone' => $user->phone,
                'guichet'   => $pendingEnroll->guichetRef, 
                'enrollId'  => $pendingEnroll->id, 
                'date'      => $currentDate,
            ]; 
        }
    }


        $pendingEnrolls = $user_list;

        return view('guichet/entEnrollHistory')
                ->with('pendingEnrolls', $pendingEnrolls);

    }











    // List enrollement for entreprise account 

    public function listEntreprise(){

        $pendingEnrolls = EnrollHistory::where('status', '0')->orderBy('created_at', 'desc')->get();
    }



    public function enrollListEntreprise()
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
        $this->middleware('can:guichet'); 

        request()->validate([
            'user_id' 	             => 'required|numeric',
            'marque'                 => 'required|string',
            'modele'                 => 'required|string',
            'mairie' 	             => 'required|string',
            'chassie'                => 'required|string',
            'cylindre' 	             => 'required|string',
            'documentJustificatif' 	 => 'required|file|image|max:10096',
        ]);

        $data           = $request->all();
        $usager         = User::find($data['user_id']);

        // Check limits
        $account_type   = UsagerAccountType::where('user_id', $usager->id)
                                           ->first();
        $account_type   = $account_type->type;
        
        $limit          = Engins::where('userId', $usager->id)->count();

       
        
        if($limit === 4000)
            $limit = true;

        if($account_type === "usager")
            if($limit === true)
                return redirect()->route('entEnrollStepOne', $usager)
                                 ->with('error', "Nombre maximal d'enregistrement atteint!");



        $IfEnginExist    = Engins::where('chassie', $data['chassie'])->first();
        if ($IfEnginExist)
            return redirect()->route('entEnrollStepTwo', $usager)
                            ->with('error', 'Numero de chassie existant !')
                            ->withInput();

                                    
        $engin  = $this->createEngin($data);      
        // dd($engin);
        $documentJustificatifLoadedEtx              = $request->file('documentJustificatif')->getClientOriginalExtension();
        $documentJustificatifLoaded_storage_path    = 'DocumentsEngins/engin-' . time() . '.' .$documentJustificatifLoadedEtx;
        $documentJustificatifLoaded                 = \Storage::disk('public')->put($documentJustificatifLoaded_storage_path, file_get_contents($request->file('documentJustificatif')));
        $engin->documentJustificatif                = $documentJustificatifLoaded_storage_path;
        $engin->save();
        

        // $idCardLoaded       = $this->storeIdCard($User);

        if($documentJustificatifLoaded == False)
        {
            $engin->delete();
            return redirect()->route('entEnrollStepTwo', $usager)
                             ->with('error', 'Erreur d\'enregistrement! V??rifier votre connexion internet puis r??essayer.')
                             ->withInput();
        }

        // Enroll History backUp
        $history = new EnrollHistory();
        $history->agentRef      =   Auth::user()->id;
        $history->agentName     =   Auth::user()->firstname;
        $history->agentPhone    =   Auth::user()->phone;
        $history->userId        =   $usager->id;
        $history->enginId       = $engin->id;
        $history->status        = 1;
        $history->save();

        return $this->sendOTPEngin($usager->phone, $request->marque, $request->modele, $request->chassie, $account_type); 
    }


    public function enrollHistory()
    {        
        $this->middleware('can:guichet'); 
        // return view('guichet.enrollHistory');
    }


    public function sendOTP($phone, $code, $user_pass)
    {        
        $this->middleware('can:guichet'); 
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


        $account_type   = UsagerAccountType::where('user_id', $user->id)
                                           ->first();

        if ($account_type === "usager") {
            return redirect()->route('entEnrollStepTwo', $user)->with('success', 'Enrollement partie 1 effectu?? avec succ??s!')
            ->with('error', 'Completer l\'enrollement  sur cette page!');
        }else{
          
            return redirect()->route('entEnrollStepTwo', $user)->with('success', 'Enrollement partie 1 effectu?? avec succ??s!')
        ->with('error', 'Vous devez ajouter des engins');
        }
    }

    public function sendOTPEngin($phone, $marque, $modele, $chassie, $account_type)
    {
        $this->middleware('can:guichet');

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

    

        if ($account_type ==="usager") {
            return redirect()->route('enroll.index')->with('success', 'Enrollement partie 2 effectu?? avec succ??s!');
        }else{
            return redirect()->route('entEnrollStepTwo', $user->id)->with('success', 'Enrollement partie 2 effectu?? avec succ??s!');

        }
    }

    private function storeIdCard($user)
    {        
        $this->middleware('can:guichet'); 

        if (request()->has('idCard')) {
            $user->update([
                'idCard' => request()->idCard->store('uploads/userIdCard', 'public'),
            ]);
            return True;
        }
        return False;
    }


    public function create(array $data)
    {        
        $this->middleware('can:guichet'); 

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
        $this->middleware('can:guichet'); 
        $engin =  Engins::create([
            'userId' 	        => $data['user_id'],
            'marque'            => $data['marque'],
            'modele'            => $data['modele'],
            'mairie'            => Auth::user()->administration,
            'chassie' 	        => $data['chassie'],
            'cylindre' 	        => $data['cylindre'],
        ]);
        
        $tarif = 0;

        if ($engin->cylindre === "+125")
            $engin->tarif = 12000;
            $engin->save();

        if ($engin->cylindre === "125")
            $engin->tarif = 6000;
            $engin->save();

        if ($engin->cylindre === "50")
            $engin->tarif = 3000;
            $engin->save();

        if ($engin->cylindre === "0")
            $engin->tarif = 1500;
            $engin->save();


        return $engin;
    }


}
