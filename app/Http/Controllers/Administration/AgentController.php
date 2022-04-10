<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ProcessAgentCreate;
use App\Mail\AgentCreateMail;

use Auth;
use Session;

use App\Models\User;
use App\Models\TownHall;
use App\Models\AgentRef;
use App\Models\Guichet;
use App\Models\Role;

class AgentController extends Controller
{

    public function createShow()
    {
        if (! Gate::allows('superviseur', Auth::user())) {
            abort(403);
        }

        $guichets = Guichet::all();
        return view('adminGuichet.agent.create')->with('guichets', $guichets);
    }

    public function formatRole($guichet_ref)
    {
        // dd($sub_string_value);
        $first_letter = substr($guichet_ref,0,1);
        if($first_letter === 'e')
        {
            return 'agent_enroll';
        }

        if($first_letter === 'v')
        {
            return  'agent_vente';
        }
    }

    public function postCreate(Request $request)
    {
        if (! Gate::allows('superviseur', Auth::user())) {
            abort(403);
        }

        // dd($request->idCard);
        request()->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'email' 	             => 'required|string',
            'idCard'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1089',
            'guichet'                => 'required|string',
        ]);


        // 
        $length         = strlen($request->guichet) - 2;
        $guichet_type   = substr($request->guichet,0,$length); 
        // dd($guichet_type);
         
        //dd($key);
        $data           = $request->all();
        $IfUserExist    = User::where('phone', $request->phone)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('agent.create')
                             ->with('error', 'Ce numero est attribue a un agent!')
                             ->withInput();
        }


        $IfUserExist    = User::where('email', $request->email)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('agent.create')
                             ->with('error', 'Cette adresse email est attribue a un agent!')
                             ->withInput();
        }

        $User               = $this->create($data);
        // dd($data);
        $password           = Str::random(9);
        $User->password     = Hash::make($password);
        $User->email   = $data['email'];
        $User->isVerified   = 1;
        $User->save();


        // $idCardLoaded       = $this->storeIdCard($User);
        $idCardLoaded       = \Storage::disk('public')->putFile('idCard', $request->file('idCard'));
       
        if($idCardLoaded == False){

            $User->delete();
            return redirect()->route('agent.create')
                             ->with('error', 'Une erreur est survenue lors de l\'enregistrement.\nVérifier votre connexion internet puis réessayer!')
                             ->withInput();
        } 


        $role_name      = $this->formatRole($request->guichet);
        $length         = strlen($request->guichet) - 2;
        $guichet_type   = substr($request->guichet,0,$length); 
        // dd($guichet_type);
        

        $role = Role::select('id')->where('name', $role_name)->first();

        $User->roles()->attach($role);
        $User->save();


        // Create Agent Refs
        $agentRef =  AgentRef::create([

            'townHallRef'     =>  Auth()->user()->administration,
            'guichetRef'      =>  $data['guichet'],
            'agentId'         =>  $User->id,
        ]);


        $agent_data = [
            'email'         => $User->email,
            'password'      => $password,
            'guichetRef'    => $data['guichet'],
            'agent_fullname'    => $data['firstname']." ".$data['lastname'],
        ];

        // Email send
        ProcessAgentCreate::dispatch($agent_data);
        
        return redirect()->route('agent.create')
                         ->with('success', 'Agent cree avec succes!');


        // Enroll History backUp
        // $history = new EnrollHistory();
        // $history->townHallRef   =   $agentRef->townHallRef;
        // $history->agentRef      =   $agentRef->agentId;
        // $history->agentName     =   Auth::user()->firstname;
        // $history->agentPhone    =   Auth::user()->phone;
        // $history->guichetRef    =   $agentRef->guichetRef;
        // $history->userId        =   $User->id;
        // $history->save();

        return $this->sendOPT($telephone, $code, $user_pass);
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

        $code       = rand(100000, 999999);
        
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
}
