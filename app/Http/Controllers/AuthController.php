<?php

namespace App\Http\Controllers;

use Nexmo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;


use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\Models\User;
use App\Models\Role;
use App\Models\TempVerificationCode;
//use App\Models\administration;
//use App\Models\DemandesVignette;
use Illuminate\Support\Facades\Hash;
use Session;



class AuthController extends Controller
{

    // Load login view
    public function index()
    {

        return view('auth.login');

    }  
 

    // Load registration view
    public function register()
    {

        return view('auth.register');

    }


    public function verify()
    {
        return view('user.verify');
    }


    public function postVerify()
    {
        dd("Hi");
    }



    // Parse login credentials
    public function postLogin(Request $request)
    {
        
        //$credentials = $request->only($request->phone, $request->password);
        request()->validate([
            'phone' => 'required|regex:/^[0-9]{8}$/|digits:8',
            'password' => 'required|min:8',
        ]);
 
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {

            $user = User::where('phone', $request->phone)->first();
            if ($user->isverified != 1) {
                return redirect()->route('resend_code')->with('phone',$request->phone);
            }

            return Redirect::to("home");
        }
        return back()->with('error', 'Oups! Vos identifiants semblent invalides.')
                     ->withInput();
                    
    }


    // Parse registration data
    public function postRegister(Request $request)
    {  
        request()->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'gender' 	             => 'required|bool',
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
            return back()->with('error', 'Un compte avec le même numéro existe déjà !')
                         ->withInput();
        }
        $User       = $this->create($data);

        $id         = $User->id;
        $code       = $User->code;
        $telephone  = $User->phone;
        $this->storeIdCard($User);

       
        if(!$User){

            return back()->with("error"," :( !!! Vérifier votre connexion internet puis réessayer.")
                        ->withInput();
        } 
        else 
        {

            $sentCode   = Nexmo::message()->send([
                        'to'   => '+223'.$User->phone,
                        'from' => '+22389699245',
                        'text' => 'ikV, code de vérification: '.$code.' \n',
                    ]);

            $TempVerificationCode          = new TempVerificationCode;
            $TempVerificationCode->userId  = $id;
            $TempVerificationCode->code    = $code;
            $TempVerificationCode->phone   = $telephone;
            $TempVerificationCode->save();

            return redirect()->route('verify',$telephone);
        }
       
        
    }
     


    // Redirect to dashboard on successfull login
    public function dashboard()
    {
 
      if(Auth::check()){
        $user = Auth::user();
        
        $notifications = $user->notifications;
        
        return view('dashboard')->with('notifications', $notifications);
      }
       return Redirect::to("connexion")->withSuccess('Opps! You do not have access');
    }



    // Create new User and save his/her data in the database
    public function create(array $data)
    {

    	if($data['gender'])
          {
            $avatar = 'male.png';
          }
        else
          {
            $avatar = 'female.png';
          }

        $code  = rand(100000, 999999);
        $user =  User::create([
            'lastname' 	=> $data['lastname'],
            'firstname' => $data['firstname'],
            'gender' 	=> $data['gender'],
            'address'   => $data['address'],
            'avatar' 	=> $avatar,
            'phone' 	=> $data['phone'],
            'code'      => $code,
            'password' 	=> Hash::make($data['password'])
        ]);

        $role = Role::select('id')->where('name', 'user')->first();

        $user->roles()->attach($role);
        $user->save();
            
        return $user;
    }
     



private function storeIdCard($user)
{
    if (request()->has('idCard')) {
        $user->update([
            'idCard' => request()->idCard->store('uploads/userIdCard', 's3'),
        ]);
    }
}


    // Logout User from the system 
    public function logout() 
    {
        Session::flush();
        Auth::logout();
        return Redirect('connexion');
    }
}
?>