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
use App\Models\Payment;
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

            if($user->hasRole('superadmin')){
                return redirect()->route('get_superadmin_dash');
            }
            if($user->hasRole('ordonateur') || $user->hasRole('control-gestion') || $user->hasRole('dfm') || $user->hasRole('elu')){
                return redirect()->route('get_elu_dash');
            }

            if($user->hasRole('comptable-public') || $user->hasRole('caissier-en-chef')){
                return redirect()->route('get_comptable_dash');
            }

            if($user->hasRole('guichet')){
                return redirect()->route('get_guichet_dash');
            }

            if($user->hasRole('regisseur')){
                return redirect()->route('get_regisseur_dash');
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
            'account_type'           => 'required|string|max:15',
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

        $userIdCardEtx          = $request->file('idCard')->getClientOriginalExtension(); 
        $idCard_storage_path    = 'idCard/idCard-' . time() . '.' .$userIdCardEtx;
        // $idCardLoaded           = \Storage::disk('public')->put($idCard_storage_path, file_get_contents($request->file('idCard')));
        $idCardLoaded           = \Storage::disk('s3')->put($idCard_storage_path, file_get_contents($request->file('idCard')));

        $User->idCard           = $idCard_storage_path;
        $User->save();
       
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
        // $history = new EnrollHistory();
        // $history->agentRef      =   $User->id;
        // $history->agentName     =   $User->firstname;
        // $history->agentPhone    =   $User->phone;
        // $history->userId        =   $User->id;
        // $history->save();

        return $this->sendOPT($telephone, $code);
    
       
        
    }
     


    // Redirect to dashboard on successfull login
    public function dashboard()
    {
 
      if(Auth::check()){
        $user = Auth::user();
        
        $notifications =   $user->notifications;
        

        return view('dashboard')->with('notifications',  $notifications);

      }
       return Redirect::to("connexion")->withSuccess('Opps! You do not have access');
    }


    public function guichetDashboard()
    {
      if(Auth::check()){  
        // Array of engins
        $engin_array = [];
        $vignetted_engin_count = 0;
        $engin_count = 0;
        $day_agent_engin_count = 0;
        $month_agent_engin_count = 0;
        $year_agent_engin_count = 0;
        $day_agent_usager_count = 0;
        $month_agent_usager_count = 0;
        $year_agent_usager_count = 0;
        $total_sales = 0;
        $day_sales = 0;
        $month_sales = 0;
        $year_sales = 0;
        $total_users = 0;
        $total_administrateurs = 0;
        $total_users            = DB::table('users')->count();
        $total_administrateurs  = DB::table('users')->where('administration', 'bko')
                                                    ->count();
        $user_count      = $total_users - $total_administrateurs;

        $total_sales = DB::table("payments")
                         ->where('agentId', Auth::user()->id)
                         ->sum('amount');

        // dd($data);
        

        //------------------------------------------------------------------//
            // Count engins with vignette a jour and the overall total sales
        $vignettes      = Vignettes::where('status', 1)->get();
        foreach ($vignettes as $vignette) {
            $engin          = Engins::find($vignette->enginId);
            $engin_array[]  = $engin;
            $vignetted_engin_count  +=1;
        }


        $agent_yearly_sales = DB::table('payments')
                                ->select('amount')
                                ->WhereYear('created_at', Date('Y'))
                                ->where('agentId', Auth::user()->id)
                                ->get();

        


        // Dayly sales by aagent 
            $agent_day_sales = DB::table('sales_histories')->select('enrollId')->where('agentRef', Auth::user()->id)->WhereDay('created_at', Date('d'))->get();
        // dd($agent_sales);  
            for ($i=0; $i < count($agent_day_sales); $i++) { 
                // $mountBenefit[] = $agent_sales[$i]->tarif;
                $enginL = DB::table('enroll_histories')->select('enginId')->where('id',$agent_day_sales[$i]->enrollId)->first();
                $engin          = Engins::find($enginL->enginId);
                $engin_array[]  = $engin;
                $day_agent_engin_count  +=1;
                $day_agent_usager_count  +=1;
                $day_sales    += $engin->tarif;
            // dd($day_sales);  

            }

        // ------------------------------------------------------------------------//

                    //Get Monthly sales by agent

                    $agent_month_sales = DB::table('sales_histories')->select('enrollId')
                                                                     ->where('agentRef', Auth::user()->id)
                                                                     ->WhereMonth('created_at', Date('m'))
                                                                     ->get();
                    // dd($agent_sales);  
                    for ($i=0; $i < count($agent_month_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId','userId')
                                                               ->where('id',$agent_month_sales[$i]->enrollId)
                                                               ->first();
                        $engin          = Engins::find($enginL->enginId);
                        $usager          = User::find($enginL->userId);
                        $month_agent_engin_count  +=1;
                        $month_agent_usager_count  +=1;
                        $month_sales    += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                    // ----------------------------------------------------------------------//

                    //Get Year sales by agent
                    $yearly_sales = 0;
                    $year_sales = DB::table('sales_histories')->select('enrollId')
                                                            ->where('agentRef', Auth::user()->id)
                                                            ->WhereYear('created_at', Date('Y'))
                                                            ->get();

                    // dd($agent_sales);  
                    for ($i=0; $i < count($year_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId','userId')
                                                               ->where('id',$year_sales[$i]->enrollId)
                                                               ->first();
                      
                        $engin          = Engins::find($enginL->enginId);
                        $usager          = User::find($enginL->userId);

                        $engin_array[]  = $engin;
                        $year_agent_engin_count  +=1;
                        $year_agent_usager_count  +=1;
                        $yearly_sales    += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                $user           = Auth::user();
                $notifications = $user->notifications;
                $today = Carbon::now()->format('d-m-Y');
                $current_month = Carbon::now()->format('m-Y');
                $current_year = Carbon::now()->format('Y');
                
                // dd(json_encoyears));
                return view('guichet-dash')->with('today', $today)
                                ->with('current_month', $current_month)
                                ->with('current_year', $current_year)
                                ->with('total_sales', $total_sales)
                                ->with('day_sales', $day_sales)
                                ->with('month_sales', $month_sales)
                                ->with('year_sales', $yearly_sales)
                                ->with('day_agent_engin_count', $day_agent_engin_count)
                                ->with('day_agent_usager_count', $day_agent_usager_count)
                                ->with('month_agent_engin_count', $month_agent_engin_count)
                                ->with('month_agent_usager_count', $month_agent_usager_count)
                                ->with('year_agent_engin_count', $year_agent_engin_count)
                                ->with('year_agent_usager_count', $year_agent_usager_count)
                                ->with('vignetted_engin_count', $vignetted_engin_count);
            }
            return redirect()->route("get_admin_login")->withSuccess('Opps! You do not have access');
    }

    public function eluDashboard()
    {
      if(Auth::check()){  
        // Array of engins
        $engin_array = [];
        $vignetted_engin_count = 0;
        $engin_count = 0;
        $day_engin_count = 0;
        $month_engin_count = 0;
        $year_engin_count = 0;
        $total_sales = 0;
        $day_sales = 0;
        $month_sales = 0;
        $year_sales = 0;
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
                             ->where('vignettes.status', 1)
                             ->get(['engins.id', 'engins.tarif', 'vignettes.created_at'])
                             ->groupBy(function($data){
                                return Carbon::parse($data->created_at)->format('M');
                             });
        
        $data1 = Vignettes::join('engins', 'vignettes.enginId', '=', 'engins.id')
                            ->where('vignettes.status', 1)
                            ->get(['engins.tarif'])
                            ->groupBy(function($data){
                                return Carbon::parse($data->created_at)->format('M');
                            });


        // Counting Engin per month
        $months = [];
        $monthCountEngins = [];
        $monthCountBenefit = [];
        $mountBenefit = array();

        foreach ($data as $month => $value) {
            $months[]   = $month;
            $monthCountEngins[] = count($value);
            for ($i=0; $i < count($value); $i++) { 
                $mountBenefit[] = $value[$i]->tarif;
            }

            $monthCountBenefit[] = array_sum($mountBenefit);
            $mountBenefit= [];            
        }

        
        $vignettes      = Vignettes::where('status', 1)->get();
        foreach ($vignettes as $vignette) {
            $engin          = Engins::find($vignette->enginId);
            $engin_array[]  = $engin;
            $vignetted_engin_count  +=1;
            $total_sales    += $engin->tarif;
        }



         //----------------------------------------------------------------------------------------//
            //Get Daily sales 
            $day_sales = 0;
            $daily_sales = DB::table('sales_histories')->select('enrollId')
                                                    ->WhereDay('created_at', Date('d'))
                                                    ->get();
   
            for ($i=0; $i < count($daily_sales); $i++) { 
                // $mountBenefit[] = $agent_sales[$i]->tarif;
                $enginL = DB::table('enroll_histories')->select('enginId')
                                                       ->where('id',$daily_sales[$i]->enrollId)
                                                       ->first();
                $engin          = Engins::find($enginL->enginId);
                $day_engin_count  += 1;
                $day_sales        += $engin->tarif;
            // dd($day_sales);  

            }

        // ------------------------------------------------------------------------//

                    //Get Monthly sales

                    $monthly_sales = DB::table('sales_histories')->select('enrollId')
                                                                     ->WhereMonth('created_at', Date('m'))
                                                                     ->get();
                    // dd($monthly_sales);  
                    for ($i=0; $i < count($monthly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$monthly_sales[$i]->enrollId)
                                                               ->first();
                        $engin          = Engins::find($enginL->enginId);
                        $month_engin_count  += 1;
                        $month_sales        += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                    // ----------------------------------------------------------------------//

                    //Get Yearly sales

                    $yearly_sales = DB::table('sales_histories')->select('enrollId')
                                                                    ->WhereYear('created_at', Date('Y'))
                                                                    ->get();
                    // // dd($agent_sales);  
                    for ($i=0; $i < count($yearly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$yearly_sales[$i]->enrollId)
                                                               ->first();

                        $engin                      = Engins::find($enginL->enginId);
                        $engin_array[]              = $engin;
                        $year_engin_count           +=1;
                        $year_sales                 += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                
                    // ----------------------------------------------------------------------/

                $total_sales = $year_sales;
                
                $prevision = Prevision::orderBy('updated_at', 'desc')->first();
                if(!empty($prevision)){
                    $previsionMontant = $prevision->montant;
                    $pourcentage = 0;

                if($previsionMontant > 0)
                    $pourcentage = ($total_sales/$previsionMontant)*100;
                }
                else{
                    $previsionMontant =0;  
                    $pourcentage = 0;
                }
            
                




                $user           = Auth::user();
                $notifications = $user->notifications;
                $today = Carbon::now()->format('d-m-Y');
                $current_month = Carbon::now()->format('m-Y');
                $current_year = Carbon::now()->format('Y');
                
                // dd(json_encoyears));
                return view('elu-dash')->with('today', $today)
                                ->with('current_month', $current_month)
                                ->with('current_year', $current_year)
                                ->with('months', $months)
                                ->with('monthCountBenefit', json_encode($monthCountBenefit, JSON_NUMERIC_CHECK))
                                ->with('monthCountEngins', json_encode($monthCountEngins, JSON_NUMERIC_CHECK))
                                ->with('data', $data)
                                ->with('previsionMontant', $previsionMontant)
                                ->with('pourcentage', $pourcentage)
                                ->with('total_sales', $total_sales)
                                ->with('day_sales', $day_sales)
                                ->with('month_sales', $month_sales)
                                ->with('year_sales', $year_sales)
                                ->with('day_engin_count', $day_engin_count)
                                ->with('month_engin_count', $month_engin_count)
                                ->with('year_engin_count', $year_engin_count)
                                ->with('vignetted_engin_count', $vignetted_engin_count)
                                ->with('user_count', $user_count);
            }
            return redirect()->route("get_admin_login")->withSuccess('Opps! You do not have access');
    }

    public function superadminDashboard()
    {
      if(Auth::check()){  
        $user           = Auth::user();
        $notifications = $user->notifications;
        $today = Carbon::now()->format('d-m-Y');
        $current_month = Carbon::now()->format('m-Y');
        $current_year = Carbon::now()->format('Y');
        
        // dd(json_encoyears));
        return view('superadmin-dash')->with('today', $today)
                        ->with('current_month', $current_month)
                        ->with('current_year', $current_year);
            }
            return redirect()->route("get_admin_login")->withSuccess('Opps! You do not have access');
    }

    public function comptableDashboard()
    {
      if(Auth::check()){  
        // Array of engins
        $engin_array = [];
        $vignetted_engin_count = 0;
        $day_engin_count = 0;
        $month_engin_count = 0;
        $year_engin_count = 0;
        $engin_count = 0;
        $total_sales = 0;
        $daly_sales = 0;
        $month_sales = 0;
        $year_sales = 0;


        //----------------------------------------------------------------------------------------//
            //Get Daily sales 
            $day_sales = 0;
            $daily_sales = DB::table('sales_histories')->select('enrollId')
                                                    ->WhereDay('created_at', Date('d'))
                                                    ->get();
   
            for ($i=0; $i < count($daily_sales); $i++) { 
                // $mountBenefit[] = $agent_sales[$i]->tarif;
                $enginL = DB::table('enroll_histories')->select('enginId')
                                                       ->where('id',$daily_sales[$i]->enrollId)
                                                       ->first();
                $engin          = Engins::find($enginL->enginId);
                $day_engin_count  += 1;
                $day_sales        += $engin->tarif;
            // dd($day_sales);  

            }

        // ------------------------------------------------------------------------//

                    //Get Monthly sales

                    $monthly_sales = DB::table('sales_histories')->select('enrollId')
                                                                     ->WhereMonth('created_at', Date('m'))
                                                                     ->get();
                    // dd($monthly_sales);  
                    for ($i=0; $i < count($monthly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$monthly_sales[$i]->enrollId)
                                                               ->first();
                        $engin          = Engins::find($enginL->enginId);
                        $month_engin_count  += 1;
                        $month_sales        += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                    // ----------------------------------------------------------------------//

                    //Get Yearly sales

                    $yearly_sales = DB::table('sales_histories')->select('enrollId')
                                                                    ->WhereYear('created_at', Date('Y'))
                                                                    ->get();
                    // // dd($agent_sales);  
                    for ($i=0; $i < count($yearly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$yearly_sales[$i]->enrollId)
                                                               ->first();

                        $engin                      = Engins::find($enginL->enginId);
                        $engin_array[]              = $engin;
                        $year_engin_count           +=1;
                        $year_sales                 += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                
                    // ----------------------------------------------------------------------/

                $total_sales = $year_sales;
                $prevision = Prevision::orderBy('updated_at', 'desc')->first();
                if(!empty($prevision)){
                    $previsionMontant = $prevision->montant;
                    $pourcentage = 0;

                if($previsionMontant > 0)
                    $pourcentage = ($total_sales/$previsionMontant)*100;
                }
                else{
                    $previsionMontant =0;  
                    $pourcentage = 0;
                }





                $user               = Auth::user();
                $notifications      = $user->notifications;
                $today              = Carbon::now()->format('d-m-Y');
                $current_month      = Carbon::now()->format('m-Y');
                $current_year       = Carbon::now()->format('Y');
                
                return view('comptable-dash')->with('today', $today)
                                ->with('previsionMontant', $previsionMontant)
                                ->with('total_sales', $total_sales)
                                ->with('pourcentage', $pourcentage)
                                ->with('current_month', $current_month)
                                ->with('current_year', $current_year)
                                ->with('day_engin_count', $day_engin_count)
                                ->with('month_engin_count', $month_engin_count)
                                ->with('year_engin_count', $year_engin_count)
                                ->with('day_sales', $day_sales)
                                ->with('month_sales', $month_sales)
                                ->with('year_sales', $year_sales);
            }
            return redirect()->route("get_admin_login")->withSuccess('Opps! You do not have access');
    }

    public function regisseurDashboard()
    {
      if(Auth::check()){  
        // Array of engins
        $engin_array = [];
        $vignetted_engin_count = 0;
        $day_engin_count = 0;
        $month_engin_count = 0;
        $year_engin_count = 0;
        $engin_count = 0;
        $total_sales = 0;
        $daly_sales = 0;
        $month_sales = 0;
        $year_sales = 0;


        //----------------------------------------------------------------------------------------//
            //Get Daily sales 
            $day_sales = 0;
            $daily_sales = DB::table('sales_histories')->select('enrollId')
                                                    ->WhereDay('created_at', Date('d'))
                                                    ->get();
   
            for ($i=0; $i < count($daily_sales); $i++) { 
                // $mountBenefit[] = $agent_sales[$i]->tarif;
                $enginL = DB::table('enroll_histories')->select('enginId')
                                                       ->where('id',$daily_sales[$i]->enrollId)
                                                       ->first();
                $engin          = Engins::find($enginL->enginId);
                $day_engin_count  += 1;
                $day_sales        += $engin->tarif;
            // dd($day_sales);  

            }

        // ------------------------------------------------------------------------//

                    //Get Monthly sales

                    $monthly_sales = DB::table('sales_histories')->select('enrollId')
                                                                     ->WhereMonth('created_at', Date('m'))
                                                                     ->get();
                    // dd($monthly_sales);  
                    for ($i=0; $i < count($monthly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$monthly_sales[$i]->enrollId)
                                                               ->first();
                        $engin          = Engins::find($enginL->enginId);
                        $month_engin_count  += 1;
                        $month_sales        += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                    // ----------------------------------------------------------------------//

                    //Get Yearly sales

                    $yearly_sales = DB::table('sales_histories')->select('enrollId')
                                                                    ->WhereYear('created_at', Date('Y'))
                                                                    ->get();
                    // // dd($agent_sales);  
                    for ($i=0; $i < count($yearly_sales); $i++) { 
                        // $mountBenefit[] = $agent_sales[$i]->tarif;
                        $enginL = DB::table('enroll_histories')->select('enginId')
                                                               ->where('id',$yearly_sales[$i]->enrollId)
                                                               ->first();

                        $engin                      = Engins::find($enginL->enginId);
                        $engin_array[]              = $engin;
                        $year_engin_count           +=1;
                        $year_sales                 += $engin->tarif;
                        // dd($day_sales);  
            
                    }

                
                    // ----------------------------------------------------------------------/

                $total_sales = $year_sales;
                $prevision = Prevision::orderBy('updated_at', 'desc')->first();
                if(!empty($prevision)){
                    $previsionMontant = $prevision->montant;
                    $pourcentage = 0;

                if($previsionMontant > 0)
                    $pourcentage = ($total_sales/$previsionMontant)*100;
                }
                else{
                    $previsionMontant =0;  
                    $pourcentage = 0;
                }





                $user               = Auth::user();
                $notifications      = $user->notifications;
                $today              = Carbon::now()->format('d-m-Y');
                $current_month      = Carbon::now()->format('m-Y');
                $current_year       = Carbon::now()->format('Y');
                
                return view('regisseur-dash')->with('today', $today)
                                ->with('previsionMontant', $previsionMontant)
                                ->with('total_sales', $total_sales)
                                ->with('pourcentage', $pourcentage)
                                ->with('current_month', $current_month)
                                ->with('current_year', $current_year)
                                ->with('day_engin_count', $day_engin_count)
                                ->with('month_engin_count', $month_engin_count)
                                ->with('year_engin_count', $year_engin_count)
                                ->with('day_sales', $day_sales)
                                ->with('month_sales', $month_sales)
                                ->with('year_sales', $year_sales);
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