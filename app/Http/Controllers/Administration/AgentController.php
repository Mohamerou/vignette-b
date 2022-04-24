<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
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
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:comptable-public');      
    }
    



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users       = User::take(300)->get();
        $user_list  = [];

        foreach ($users as $user) {
            if ($user->hasRole('guichet')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'guichet',
                ];
            }
        }

        return view('adminGuichet.agent.index')
                         ->with('user_list', $user_list);
    }
    

    public function createShow()
    {
        return view('adminGuichet.agent.create');
    }
    

    public function edit($id)
    {

        $role_list      = [];
        $user_info      = [];
        $user           = User::find($id);
        $roles          = Role::all();

        foreach ($roles as $role) {
            if ($role->name != 'guichet') {
            }else {
                $role_list[] = $role;

                if ($user->hasRole($role->name)) {
                    $user_info[] = [
                        'user' => $user,
                        'user_role' => $role,
                    ];
                }
            }  
        }

        return view('adminGuichet.agent.edit', [
            'user_info' => $user_info,
            'role_list' => $role_list,
        ]);
    }
    

    public function update(Request $request, $id)
    {
        
        $user           = User::find($id);
        $roles          = Role::all();

        $request->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'email' 	             => 'required|string',
            'role'                   => 'required|numeric',
        ]);

        
        foreach ($roles as $role) {
            if ($role->name != 'guichet') {
            }else {
                if ($user->hasRole($role->name)) {
                    $user_current_role = $role->id;
                }
            }  
        }


        
        $user->roles()->detach($user_current_role);

            $user->lastname           = $request->lastname;
            $user->firstname          = $request->firstname;
            $user->address            = $request->address;
            $user->phone              = $request->phone;
            $user->email              = $request->email;

            $user->save();

        // dd($request->all());
        $user->roles()->attach($request->role);
        $user->save();

        return redirect()->route('agent.edit', $user)->with('success', 'Infos compte modifié avec succès.');
    }
    

    public function destroy($id)
    {
        $user   = User::findOrfail($id);
        $user->delete();

        return redirect()->route('get_admin_dash')->with('success', "Compte supprime avec succes!");
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

    public function store(Request $request)
    {

        // dd($request->idCard);
        $request->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'email' 	             => 'required|string',
        ]);


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
        $User->email        = $data['email'];
        $User->isVerified   = 1;
        $User->save();


        // $idCardLoaded       = $this->storeIdCard($User);
        // $idCardLoaded       = \Storage::disk('public')->putFile('idCard', $request->file('idCard'));
       
        // if($idCardLoaded == False){

        //     $User->delete();
        //     return redirect()->route('agent.create')
        //                      ->with('error', 'Une erreur est survenue lors de l\'enregistrement.\nVérifier votre connexion internet puis réessayer!')
        //                      ->withInput();
        // } 
        

        $role = Role::select('id')->where('name', 'guichet')->first();

        $User->roles()->attach($role);
        $User->save();


        // // Create Agent Refs
        // $agentRef =  AgentRef::create([

        //     'townHallRef'     =>  Auth()->user()->administration,
        //     'agentId'         =>  $User->id,
        // ]);


        $agent_data = [
            'email'         => $User->email,
            'phone'         => $User->phone,
            'password'      => $password,
            'agent_fullname'    => $data['firstname']." ".$data['lastname'],
        ];

        // Email send
        ProcessAgentCreate::dispatch($agent_data);
        
        return redirect()->route('agent.create')
                         ->with('success', 'Agent cree avec succes!');

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
