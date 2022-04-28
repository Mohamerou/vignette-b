<?php

namespace App\Http\Controllers;

use Nexmo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use DB;
Use App\Models\User;
use App\Models\Role;
use App\Models\TempVerificationCode;
use App\Models\Engins;
use App\Models\Vignettes;
use App\Models\EnrollHistory;
use App\Models\UsagerAccountType;
use App\Models\Prevision;
//use App\Models\administration;
//use App\Models\DemandesVignette;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;



class AuthController extends Controller
{

    // Load login view
    public function index()
    {

        return view('auth.login');

    }  
 

    
    public function admin_login()
    {

        return view('auth.admin_login');

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
            'phone'     => 'required|regex:/^[0-9]{8}$/|digits:8',
            'password'  => 'required|string',
        ]);
 
        $phone      = $request->phone;
        $password   = $request->password;

        $passowrdLength = strlen($password);

        if($passowrdLength <= 7){
            return redirect()->route('connexion')->with('error', 'Le mot de passe est trop court. 8 caractères minimum!');
        }

        if (Auth::attempt(['phone' => $phone, 'password' => $password])) {


            $user = User::where('phone', $request->phone)->first();

            // dd($user);
            if ($user->isverified != 1) 
            {
                if (!($user->hasRole('guichet'))) {
                    Session::flush();
                    Auth::logout();
                    return redirect()->route('resend_code',['phone' => $phone]);
                }


                Session::flush();
                Auth::logout();
                return redirect()->route('connexion')->with('error', "Compte inactif !");
            }

            if($user->hasRole('superadmin') || $user->hasRole('elu') || $user->hasRole('comptable-public')){
                return redirect()->route('get_admin_dash');
            }
            if($user->hasRole('ordonateur') || $user->hasRole('control-gestion') || $user->hasRole('dfm')){
                return redirect()->route('get_admin_dash');
            }

            if($user->hasRole('regisseur-public') || $user->hasRole('superviseur')){
                return redirect()->route('get_admin_dash');
            }

            if($user->hasRole('guichet')){
                return redirect()->route('get_admin_dash');
            }

            return redirect()->route('home');
        }
        return back()->with('error', 'Identifiants invalides!')
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


        $account_type   = UsagerAccountType::create([
            'user_id' => $User->id,
            'type'    => $data['account_type'],
        ]);

        // Enroll History backUp
        $history = new EnrollHistory();
        $history->agentRef      =   $User->id;
        $history->agentName     =   $User->firstname;
        $history->agentPhone    =   $User->phone;
        $history->userId        =   $User->id;
        $history->save();

        return $this->sendOPT($telephone, $code);
    
       
        
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


    public function adminDashboard()
    {
      if(Auth::check()){  
        // Array of engins
        $engin_array = [];
        $vignetted_engin_count = 0;
        $total_sales = 0;
        $total_users = 0;
        $total_administrateurs = 0;
        $total_users            = DB::table('users')->count();
        $total_administrateurs  = DB::table('users')->where('administration', 'bko')
                                                    ->count();
        $user_count      = $total_users - $total_administrateurs;


       

        // Engin classified per month
        // $data = Engins::select('id', 'created_at')->get()->groupBy(function($data){
        //     return Carbon::parse($data->created_at)->format('M');
        // });

        $data = Vignettes::join('engins', 'vignettes.enginId', '=', 'engins.id')
                             ->get(['engins.id', 'vignettes.created_at'])
                             ->groupBy(function($data){
                                return Carbon::parse($data->created_at)->format('M');
                             });

        // Counting Engin per month
        $months = [];
        $monthCountEngins = [];
        foreach ($data as $month => $value) {
            $months[]   = $month;
            $monthCountEngins = count($value);
        }

        $vignettes      = Vignettes::where('status', 1)->get();
        foreach ($vignettes as $vignette) {
            $engin          = Engins::find($vignette->enginId);
            $engin_array[]  = $engin;
            $vignetted_engin_count  +=1;
            $total_sales    += $engin->tarif;
        }
        
        $prevision = Prevision::orderBy('updated_at', 'desc')->first();
        if(!empty($prevision)){
            $previsionMontant = $prevision->montant;
            $poucentage = 0;

        if($previsionMontant > 0)
            $poucentage = ($total_sales/$previsionMontant)*100;
        

    }
    else{
        $previsionMontant =0;  
        $poucentage = 0;
    }
      
        




        $user           = Auth::user();
        $notifications = $user->notifications;
        $today = Carbon::now()->format('d-m-Y');
        $current_month = Carbon::now()->format('m-Y');
        
        // dd(json_encode($months));
        return view('dash')->with('today', $today)
                           ->with('current_month', $current_month)
                           ->with('months', $months)
                           ->with('monthCountEngins', json_encode($monthCountEngins, JSON_NUMERIC_CHECK))
                           ->with('data', $data)
                           ->with('previsionMontant', $previsionMontant)
                           ->with('poucentage', $poucentage)
                           ->with('total_sales', $total_sales)
                           ->with('vignetted_engin_count', $vignetted_engin_count)
                           ->with('user_count', $user_count);
      }
       return redirect()->route("get_admin_login")->withSuccess('Opps! You do not have access');
    }



    // Create new User and save his/her data in the database
    public function create(array $data)
    {

    	if($data['gender'])
          {
            $avatar = 'avatar.png';
          }
        else
          {
            $avatar = 'avatar.png';
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
            'password' 	=> Hash::make($data['password']),
        ]);
            
        return $user;
    }
     



private function storeIdCard($user)
{
    if (request()->has('idCard')) {
        $user->update([
            'idCard' => request()->idCard->store('uploads/userIdCard', 's3'),
        ]);
        return True;
    }
    return False;
}

public function sendOPT($phone, $code)
{
    // $api_key= getenv('BEEM_KEY');
    // $secret_key = getenv('BEEM_SECRET');

    $user       = User::where('phone', $phone)->first();
    $userId     = $user->id;



//.... replace <api_key> and <secret_key> with the valid keys obtained from the platform, under profile>authentication information
// The data to send to the API
// $postData   = array(
//     'source_addr' => 'INFO',
//     'encoding'=>0,
//     'schedule_time' => '',
//     'message' => 'Code de confirmation '.$code,
//     'recipients' => [array('recipient_id' => $phone,'dest_addr'=>'223'.$phone)]
// );
// //.... Api url
// $Url ='https://apisms.beem.africa/v1/send';

// // Setup cURL
// $ch = curl_init($Url);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// curl_setopt_array($ch, array(
//     CURLOPT_POST => TRUE,
//     CURLOPT_RETURNTRANSFER => TRUE,
//     CURLOPT_HTTPHEADER => array(
//         'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
//         'Content-Type: application/json'
//     ),
//     CURLOPT_POSTFIELDS => json_encode($postData)
// ));

// // Send the request
// $response = curl_exec($ch);
// //dd($response);
// // Check for errors
// if($response === FALSE){
//         echo $response;

//     die(curl_error($ch));
// }
//dd($response);


    // $OTP = Nexmo::message()->send([
    //                                 'to'   => '+223'.$phone,
    //                                 'from' => '+22369141418',
    //                                 'text' => "ikaVignetti, code de confirmation ".$code.". ",
    //                                 ]);

   
    
    # OTP TRACK BACKUP
    $TempVerificationCode          = new TempVerificationCode;
    $TempVerificationCode->userId  = $userId;
    $TempVerificationCode->code    = $code;
    $TempVerificationCode->phone   = $phone;
    $TempVerificationCode->save();

    return redirect()->route('verify',$phone);
}


    // Logout User from the system 
    public function logout() 
    {
        return Redirect('connexion');
    }
}
?>