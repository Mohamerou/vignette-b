<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Validator,Redirect,Response;
use Auth;
use Nexmo;
Use App\Models\User;
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
    public function stepOne()
    {
        return view('guichet.enrollViewOne');
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

        //Agent Refs
        $agentRef = AgentRef::where('agentId', Auth::user()->id)->first();

        // Enroll History backUp
        $history = new EnrollHistory();
        $history->townHallRef   =   $agentRef->townHallRef;
        $history->agentRef      =   $agentRef->agentId;
        $history->agentName     =   Auth::user()->firstname;
        $history->agentPhone    =   Auth::user()->phone;
        $history->guichetRef    =   $agentRef->guichetRef;
        $history->userId        =   $User->id;
        $history->save();

       //  $this->sendOPT($telephone, $code, $user_pass);
         return view('guichet.enrollViewTwo');
    }


    public function enrollList()
    {
        $users_list = [];
        $agentRef           = AgentRef::where('agentId', Auth::user()->id)->first();
        $PendingEnrolls     = EnrollHistory::where('status', 0)
                                           ->where('townHallRef', $agentRef->townHallRef)
                                           ->get();
        foreach($PendingEnrolls as $PendingEnroll)
        {
            $users_list[]   = User::find($PendingEnroll->userId);
        }

        return view('guichet.salesIndexView')->with('users', $users_list);

    }

    public function stepTwo()
    {
        return view('guichet.enrollViewTwo');
    }

    public function poststepTwo(Request $request)
    {

        request()->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',

            'password' 	             => 'required|min:8',
            'password_confirmation'  => 'required|min:8',
        ]);

        //dd($key);
        $data           = $request->all();
        $IfUserExist    = User::where('phone', $request->phone)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('inscription')
                             ->with('error', 'Ce numéro est pris. Vérifier le votre et réessayer.')
                             ->withInput();
        }

        $User               = $this->create($data);

        $id                 = $User->id;
        $code               = $User->code;
        $telephone          = $User->phone;
        $idCardLoaded       = $this->storeIdCard($User);

        if($idCardLoaded == False){

            $User->delete();
            return redirect()->route('inscription')
                             ->with('error', '! Vérifier votre connexion internet puis réessayer.')
                             ->withInput();
        }

        $role = Role::select('id')->where('name', 'user')->first();

        $User->roles()->attach($role);
        $User->save();

        $user_pass = Str::random(12);

        $User->password = $user_pass;
        $User->save();

        return $this->sendOPT($telephone, $code, $user_pass);



    }


    public function enrollHistory()
    {
        return view('guichet.enrollHistory');
    }


    public function sendOPT($phone, $code, $user_pass)
    {
        // $api_key= getenv('BEEM_KEY');
        // $secret_key = getenv('BEEM_SECRET');

        $user       = User::where('phone', $phone)->first();
        $userId     = $user->id;

        $OTP = Nexmo::message()->send([
                                        'to'   => '+223'.$phone,
                                        'from' => '+22369141418',
                                        'text' => "ikaVignetti, code de confirmation ".$code."\n\n.
                                                    Votre mot de passe par defaut: ".$user_pass."\n",
                                        ]);



        # OTP TRACK BACKUP
        $TempVerificationCode          = new TempVerificationCode;
        $TempVerificationCode->userId  = $userId;
        $TempVerificationCode->code    = $code;
        $TempVerificationCode->phone   = $phone;
        $TempVerificationCode->save();

        return redirect()->route('enrollStepOne')->with('success', 'Enrollement effectué avec succès!');
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
            'password' 	=> Hash::make('password'),
        ]);

        return $user;
    }


}
