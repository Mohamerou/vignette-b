<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Auth;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ProcessNewCompteMail;
use App\Mail\NewCompteMail;

use App\Models\User;
use App\Models\Role;

class SuperAdminController extends Controller
{

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:superadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users       = User::where('administration', Auth::user()->administration)
                           ->get();
        $user_list  = [];

        foreach ($users as $user) {
            if ($user->hasRole('elu')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Elu',
                ];
            }
            
            if ($user->hasRole('ordonateur')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Ordonateur',
                ];
            }
            
            if ($user->hasRole('controle-gestion')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Controle De Gestion',
                ];
            }
            
            if ($user->hasRole('dfm')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Dierction des Finances et des Materiels',
                ];
            }
            
            if ($user->hasRole('comptable-public')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Comptable Public',
                ];
            }

            if ($user->hasRole('superviseur')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Superviseur',
                ];
            }

            if ($user->hasRole('regisseur-public')) {
                $user_list[] = [
                    'user' => $user,
                    'role' => 'Regisseur Public',
                ];
            }
        }

        // dd($user_list);
        return view('superAdmin.index')
                         ->with('user_list', $user_list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_list = [];
        $roles = Role::all();

        foreach ($roles as $role) {
            if ($role->name === 'superadmin' || $role->name === 'user' || $role->name === 'guichet') {
            }else {
                $role_list[] = $role;
            }  
        }
        // dd($role_list);

        return view('superAdmin.create')->with('role_list', $role_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->idCard);
        $validatedData = $request->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'email' 	             => 'required|string',
            'role'                   => 'required|numeric',
        ]);

         
        //dd($key);
        $data           = $request->all();
        $IfUserExist    = User::where('phone', $request->phone)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('superadmin.create')
                             ->with('error', 'Ce numero est attribue a un compte!')
                             ->withInput();
        }


        $IfUserExist    = User::where('email', $request->email)->first();
        if ($IfUserExist) {
            # code...
            return redirect()->route('superadmin.create')
                             ->with('error', 'Cette adresse email est attribue a un compte!')
                             ->withInput();
        }


        $User               = $this->createUser($data);
        // dd($data);
        $password           = Str::random(9);
        $User->password     = Hash::make($password);
        $User->email        = $data['email'];
        $User->isVerified   = 1;
        $User->save();
        

        // $role = Role::select('id')->where('name', 'agent')->first();

        $User->roles()->attach($data['role']);
        $User->save();




        // Check for duplicate user administration role
        // $role = Role::find($data['role']);
        // $user_role_checks = User::take(100)->get();
        // foreach ($user_role_checks as $user_role_check) {
                    
        //         if ($user_role_check->hasRole($role->name)  && ($User->phone != $user_role_check->phone)) {
        //             $User->roles()->detach($data['role']);
        //             $User->delete();
        //             return redirect()->route('superadmin.create')
        //                              ->with('error', 'Compte administrateur existant!')
        //                              ->withInput();
        //         } 
        // }


        $compte_data = [
            'email'         => $User->email,
            'phone'         => $User->phone,
            'password'      => $password,
            'fullname'      => $data['firstname']." ".$data['lastname'],
        ];

        // Email send
        ProcessNewCompteMail::dispatch($compte_data);
        
        return redirect()->route('superadmin.create')
                         ->with('success', 'Compte cree avec succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role_list      = [];
        $user_info      = [];
        $user           = User::find($id);
        $roles          = Role::all();

        foreach ($roles as $role) {
            if ($role->name === 'superadmin' || $role->name === 'user' || $role->name === 'agent') {
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

        return view('superAdmin/edit', [
            'user_info' => $user_info,
            'role_list' => $role_list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            if ($role->name === 'superadmin' || $role->name === 'user' || $role->name === 'agent') {
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

        return redirect()->route('superadmin.edit', $user)->with('success', 'Infos compte modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user   = User::findOrfail($id);
        $user->delete();

        return redirect()->route('get_admin_dash')->with('success', "Compte supprime avec succes!");
    }



    public function createUser(array $data)
    {

        $code       = rand(100000, 999999);
        
        $user =  User::create([
            'lastname' 	=> $data['lastname'],
            'firstname' => $data['firstname'],
            'address'   => $data['address'],
            'administration'   => Auth::user()->administration,
            'avatar' 	=> 'avatar.png',
            'phone' 	=> $data['phone'],
            'code'      => $code,
        ]);

        return $user;
    }

}
