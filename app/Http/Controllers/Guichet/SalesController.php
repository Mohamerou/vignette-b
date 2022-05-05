<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Response;
use App\Notifications\DemandeVignette;
use App\Notifications\DemandeValider;
use App\Models\TrackDemandeVignette;
use Nexmo;
use Notifications;
use Notification;
use auth;
use Carbon\Carbon;
use DB;
use Redirect;
use Illuminate\Support\Facades\Session;
use PDF;
use File;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Role;
use App\Models\UsagerAccountType;
use App\Models\User;
use App\Models\Engins;
use App\Models\Vignettes; 
use App\Models\EnrollHistory; 
use App\Models\SalesHistory;  
use App\Models\Payment;
use App\Models\Report;
use SimpleSoftwareIO\QrCode\Generator;

use Illuminate\Support\Facades\DB as FacadesDB;

class SalesController extends Controller
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

    public function pendingSales()
    {        
        $this->middleware('can:guichet');
        $pendingSales = EnrollHistory::where('status', '1')->orderBy('created_at', 'desc')->get();

        // dd($pendingSales);



        $user_list       = [];
        $engin_list      = [];
        foreach($pendingSales as $pendingSale){
            $user   = User::findOrfail($pendingSale->userId);
            $agent  = User::findOrfail($pendingSale->agentRef);
            $engin  = Engins::findOrfail($pendingSale->enginId);
            
            $account   = UsagerAccountType::where('user_id',$user->id)->first();
            if(empty($account)){
                return redirect()->route('get-admin-dash')->with('error', 'Compte introuvable !');
            }
            // dd($account);
            if($account->type==='usager'){
        
            $engin  = Engins::find($pendingSale->enginId);
            $vignette  = Vignettes::where('enginId', $pendingSale->enginId)
                                  ->first();

             if (!$vignette) {
                $user_list[]    = [
                    'userId'    => $user->id,
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'chassie'   => $engin->chassie,
                    'agent'     => $agent->firstname." ".$agent->lastname,
                    'agentphone' => $agent->phone,
                    'enrollId'  => $pendingSale->id, 
                    'enginId'   => $pendingSale->enginId,
                ];
            } 
        }
    }

        $pendingSales = $user_list;
 
        return view('guichet/salesIndex')
                ->with('pendingSales', $pendingSales);
    }

    public function EntpendingSales()
    {        
        $this->middleware('can:guichet');
        $pendingSales = EnrollHistory::where('status', '1')->orderBy('created_at', 'desc')->get();

        $     
        
        // DB::table('engins')->where('id', $engin->id)->update(['vignetteId' => $vignette->id]);
        // dd($pendingSales);



        $user_list       = [];
        $engin_list      = [];
        foreach($pendingSales as $pendingSale){
            $user   = User::find($pendingSale->userId);
            $engin  = Engins::find($pendingSale->enginId);
            $vignette  = Vignettes::where('enginId', $pendingSale->enginId)
                                  ->first();

            if (!$vignette) {
                $user_list[]    = [
                    'userId'    => $user->id,
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'chassie'   => $engin->chassie,
                    'agent'     => $pendingSale->agentName.' - '.$pendingSale->agentPhone, 
                    'enrollId'  => $pendingSale->id, 
                    'enginId'   => $pendingSale->enginId,
                ];
            } 
        }


        $pendingSales = $user_list;
 
        return view('guichet/salesIndex')
                ->with('pendingSales', $pendingSales);
    }

    public function stepOne(int $enginId) 
    {                
        $this->middleware('can:guichet'); 

        $request = new Request([
            'enginId' => $enginId,
        ]);

        $data = $request->validate([
            'enginId'    => 'required|numeric',
        ]);

        $history    = EnrollHistory::where('enginId', $enginId)->first();
        $user       = User::findOrfail($history->userId);
        $engin      = Engins::findOrfail($enginId);

        $cylindre   = $engin->cylindre;
        $chassie            = $engin->chassie;

        if($cylindre === "0")
            $amount     = 1500;
        
        if($cylindre === "50")
            $amount     = 3000;

        if($cylindre === "125")
            $amount     = 6000;
        
        if($cylindre === "+125")
            $amount     = 12000;


        $data = [
            'firstname'                     =>     $user->firstname,
            'lastname'                      =>     $user->lastname,
            'phone'                         =>     $user->phone,
            'idcard'                        =>     $user->idCard,
            'address'                       =>     $user->address,
            'marque'                        =>     $engin->marque,
            'modele'                        =>     $engin->modele,
            'cylindre'                      =>     $engin->cylindre,
            'documentJustificatif'          =>     $engin->documentJustificatif,
            'amount'                        =>     $amount,
            'chassie'                       =>     $chassie,
        ];
        

        return view('payment')->with('data',$data);
    }

    public function stepTwo(Request $request) 
    {        
        $this->middleware('can:guichet');
        $data   = $request->validate([
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'phone'             => 'required|string|max:255',
            'address'           => 'required|string|max:255',
            'marque'            => 'required|string|max:255',
            'modele'            => 'required|string|max:255',
            'cylindre'           => 'required|string|max:255',
            'amount'            => 'required|string|max:255',
            'chassie'           => 'required|string|max:255',
        ]);


        // dd($request->all());

        $payment = new Payment();
        $payment->firstname         = $data['firstname'];
        $payment->lastname          = $data['lastname'];
        $payment->phone             = $data['phone'];
        $payment->address           = $data['address'];
        $payment->marque            = $data['marque'];
        $payment->modele            = $data['modele'];
        $payment->cylindre          = $data['cylindre'];
        $payment->amount            = $data['amount'];
        $payment->chassie           = $data['chassie'];
        $payment->save();


        ////// ikvUE(User Engin)
        $engin                      = Engins::where('chassie', $data['chassie'])->first();
        $usager                     = User::where('phone', $data['phone'])->first();




        if($usager && $engin){
                // Vignette unique_token
            $unique_token   = md5(rand(1, 15) . microtime());
            $qr_code        = new Generator;
            $qr_code->eye('circle')
                    ->style('round')
                    ->margin(3)
                    ->format('png')
                    ->encoding('UTF-8')
                    ->size(250)
                    ->generate($unique_token);

            // dd($qr_code);
            $vignette_qr_storage_path   = 'vignettes/vignette-' . time() . '.png';
            
            $vignette_qr_download_path   = 'vignettes/vignette-' . time() . '.png';

            $vignette_qr_access_path    = substr($vignette_qr_storage_path, 8);

            $vignetteLoaded = \Storage::disk('public')->put($vignette_qr_storage_path, $qr_code); //storage/app/public/img/qr-code/img-1557309130.png
            // $vignetteLoaded = \Storage::disk('public')->put('vignettes', $qr_code);
            

            $expired_at = new Carbon();
            $expired_at = $expired_at->addYear();
            $expired_at = Carbon::parse($expired_at)->format('Y-m-d H:i:s');

            $vignette                       = new Vignettes;
            $vignette->userId               = $usager->id;
            $vignette->enginId              = $engin->id;
            $vignette->unique_token         = $unique_token;
            $vignette->qr                   = $vignette_qr_storage_path;
            $vignette->qr_download_path     = $vignette_qr_download_path;
            $vignette->expired_at           = $expired_at;
            $vignette->save();


            $updateEngin    = DB::table('engins')
                              ->where('id', $engin->id)
                              ->update(['vignetteId' => $vignette->id]);

            $enrollHistory  = EnrollHistory::where('enginId', $vignette->enginId)
                                           ->first();
            
            if($vignette && $updateEngin){

                // Sales History backUp
                $history = new SalesHistory();
                $history->enrollId      =   $enrollHistory->id;
                $history->agentRef      =   Auth::user()->id;
                $history->save();

                // $userNotification->markAsRead();

                
                // Notification to User
                // $user                   = User::find($usager->id);
                // $demande                = TrackDemandeVignette::find($demandeTrackId);
                // $demande->validaded     = 1;
                // $demande->note          = "Achat de vignette pour l'engin ".$engin->chassie." a ete effectue avec succès.\n \t\t\t RDV sur le menu \"Mes vignettes\" pour télécharger votre code QR";
                // $demande->save();

                

                // Notification::send($usager, new DemandeValider($demande));


                // $code = Nexmo::message()->send([
                //                             'to'   => '+223'.$usager->phone,
                //                             'from' => '+22389699245',
                //                             'text' => "ikV, La demande de vignette pour votre ".$engin->modele." est validée avec succès. Retrouver votre code QR sur le menu ikaVignetti.   ",
                //                             ]);
                //dd($vignette);

                return redirect()->route('csv.list')->with('success', 'Achat effectue avec succes!');
            }
            else
            {
                Session::flash('error','Une erreur est surveu lors de la validation!\n Veillez réessayer'); 
                Session::flash('alert','alert-info'); 

                return back()->with('error','Une erreur est surveu lors de la validation!\n Veillez réessayer');       
            }
        }
        else{
            return ridirect()->route('home')->with("error", "Cette demande a déjà fait l'objet de vérification.");
        }

    }

    public function UserInfo()
    {
        // return view('guichet.userInfo');
    }


    public function csv_print_list()
    {
                        
        $this->middleware('can:guichet');


        $SalesHistories = SalesHistory::WhereYear('created_at', Date('Y'))
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

      

        $user_list       = [];
        $engin_list      = [];
        $totalSales      = 0;

        foreach($SalesHistories as $SalesHistory){
            $enrollHistory  = EnrollHistory::find($SalesHistory->enrollId);
            $agent_vente    = User::find($SalesHistory->agentRef);
            $user           = User::find($enrollHistory->userId);
            $engin          = Engins::find($enrollHistory->enginId);
            $vignette       = Vignettes::where('enginId', $enrollHistory->enginId)
                                  ->first();

            if ($vignette) {

                $totalSales += $engin->tarif;

                $histories_list[]    = [
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'marque'    => $engin->marque,
                    'modele'    => $engin->modele,
                    'chassie'   => $engin->chassie,
                    'agent'     => $agent_vente->firstname.' - '.$agent_vente->phone, 
                    'enginId'   => $engin->id,
                ];
            } 
        }



        // $histories = EnrollHistory::where('status', 1)->take(30)->orderBy('updated_at')->get();

        // $histories_list       = [];
        // foreach($histories as $history){
        //     $user   = User::find($history->userId);
        //     $engin  = Engins::find($history->enginId);

        //     $histories_list[]  = [
        //         'userId'    => $user->id,
        //         'usager'    => $user->firstname." ".$user->lastname,
        //         'userphone' => $user->phone,
        //         'agent'     => $history->agentName.' - '.$history->agentPhone, 
        //         'enrollId'  => $history->id, 
        //         'status'    => $history->status, 
                // 'enginId'   => $history->enginId, 
        //         'chassie'   => $engin->chassie,
        //     ]; 
        // }



        $histories = $histories_list;

        return view('guichet/csv')
               ->with('histories', $histories);
    }

    public function csv(int $enginId)
    {
                        
        $this->middleware('can:guichet');

        $enrollHistory  = EnrollHistory::where('enginId', $enginId)->first();
        $usager         = User::findOrfail($enrollHistory->userId);
        $engin          = Engins::findOrfail($enrollHistory->enginId);
        $vignette       = Vignettes::where('enginId', $enginId)
                                   ->where('status', 1)
                                   ->first();


        
        if ($enrollHistory && $usager && $engin && $vignette) {

            $fileName    = $usager->phone.'-'.$usager->firstname.'-'.$usager->lastname.'.csv';
    
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
    
            $columns = array();
    
            $callback = function() use($engin, $columns) {
                $file = fopen('php://output', 'w');
                // fputcsv($file, $columns);
    
    
                    $row['chassie']  = $engin->chassie;
                    fputcsv($file, array($row['chassie']));
                
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }

        return redirect()->route('enrolls')->with('error', 'Aucune reference trouvee!');
    }



    public function salesHistory(Request $request)
    {
        $date     = $request->date;
        $agent    = $request->agent;
  
        if (!empty($agent)) {
            if ($agent == 'all') {
                if (empty($date)) {
                    $SalesHistories = SalesHistory::whereYear('created_at', Date('Y'))->orderBy('updated_at', 'desc')->get();
                } else {
                    $SalesHistories = DB::table('SalesHistorys')
                                      ->whereDate('updated_at', '=', $date)
                                        ->orderBy('updated_at', 'desc')->get();
                }
            } else {
                $SalesHistories = DB::table('SalesHistorys')
                                      ->whereDate('updated_at', '=', $date)
                                      ->where('agentRef', '=', $agent)
                                        ->orderBy('updated_at', 'desc')->get();
            }
        } else {
            $SalesHistories = SalesHistory::take(30)->orderBy('updated_at', 'desc')->get();
        }
    
        $user_list       = [];
        $engin_list      = [];
        $totalSales      = 0;

        foreach($SalesHistories as $SalesHistory){
            $enrollHistory  = EnrollHistory::find($SalesHistory->enrollId);
            $agent_vente    = User::find($SalesHistory->agentRef);
            $user           = User::find($enrollHistory->userId);
            $engin          = Engins::find($enrollHistory->enginId);
            $vignette       = Vignettes::where('enginId', $enrollHistory->enginId)
                                  ->first();

            if ($vignette) {

                $totalSales += $engin->tarif;

                $user_list[]    = [
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'marque'    => $engin->marque,
                    'modele'    => $engin->modele,
                    'chassie'   => $engin->chassie,
                    'agent'     => $agent_vente->firstname.' - '.$agent_vente->lastname.' - '.$agent_vente->phone,
                    'tarif'     => $engin->tarif,
                ];
            } 
        }


        $SalesHistories = $user_list;
        $users = User::all();
        $usersList = [];
         foreach ($users as $user) {
             if ($user->hasRole('guichet')) {
                 $usersList[] = $user;
             }
         }
       //  dd($usersList);
       Alert::success('Success', 'Success Message');
        return view('guichet/salesHistory')
                ->with('SalesHistories', $SalesHistories)
                ->with('totalSales', $totalSales)
                ->with('allagent',$usersList);
               
    }


    public function salesHistoryPost(Request $request)
    {
        if (isset($request->history)) {
            $date     = $request->date;
            $agent    = $request->agent;
            $currentYear = Date('Y-m-d');
            if (!empty($agent)) {
                if ($agent == 'all' && empty($date)) {
                    //   dd($agent);
                
                    $SalesHistories = SalesHistory::whereYear('created_at', Date('Y'))->orderBy('updated_at', 'desc')->get();
                } elseif ($agent == 'all' && !empty($date)) {
                    $SalesHistories = DB::table('sales_histories')
                                      ->WhereDate('created_at', '=', $date)
                                        ->orderBy('created_at', 'desc')->get();
                } elseif ($agent != 'all' && !empty($date)) {
                    $SalesHistories = DB::table('sales_histories')
                                      ->WhereDate('created_at', '=', $date)
                                      ->where('agentRef', $agent)
                                        ->orderBy('created_at', 'desc')->get();
                } elseif ($agent != 'all' && empty($date)) {
                    $SalesHistories = SalesHistory::where('agentRef', $agent)->orderBy('updated_at', 'desc')->get();
                }
    
                $user_list       = [];
                $engin_list      = [];
                $totalSales      = 0;

                foreach ($SalesHistories as $SalesHistory) {
                    $enrollHistory  = EnrollHistory::find($SalesHistory->enrollId);
                    $agent_vente    = User::find($SalesHistory->agentRef);
                    $user           = User::find($enrollHistory->userId);
                    $engin          = Engins::find($enrollHistory->enginId);
                    $vignette       = Vignettes::where('enginId', $enrollHistory->enginId)
                                  ->first();

                    if ($vignette) {
                        $totalSales += $engin->tarif;

                        $user_list[]    = [
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'marque'    => $engin->marque,
                    'modele'    => $engin->modele,
                    'chassie'   => $engin->chassie,
                    'agent'     => $agent_vente->firstname.' - '.$agent_vente->phone,
                    'tarif'     => $engin->tarif,
                ];
                    }
                }


                $SalesHistories = $user_list;
                $users = User::all();
                $usersList = [];
                foreach ($users as $user) {
                    if ($user->hasRole('guichet')) {
                        $usersList[] = $user;
                    }
                }
                //  dd($usersList);
                Alert::success('Success', 'Success Message');
                return view('guichet/salesHistory')
                ->with('SalesHistories', $SalesHistories)
                ->with('totalSales', $totalSales)
                ->with('allagent', $usersList);
            }
        }
        if(isset($request->report)){

            $date     = $request->date;
            $agent    = $request->agent;
            $currentYear = Date('Y-m-d');
            
            $today      = Carbon::now();
            $today      = $today->format('d-m-Y');
            $fileName   = 'Rapport Vente'.' - '.$agent.' - '.$today;
    
            
            if ($agent == 'all' && empty($date)) {
                //   dd($agent);
            
                $SalesHistories = SalesHistory::whereYear('created_at', Date('Y'))->orderBy('updated_at', 'desc')->get();
            } elseif ($agent == 'all' && !empty($date)) {
                $SalesHistories = DB::table('sales_histories')
                                  ->WhereDate('created_at', '=', $date)
                                    ->orderBy('created_at', 'desc')->get();
            } elseif ($agent != 'all' && !empty($date)) {
                $SalesHistories = DB::table('sales_histories')
                                  ->WhereDate('created_at', '=', $date)
                                  ->where('agentRef', $agent)
                                    ->orderBy('created_at', 'desc')->get();
            } elseif ($agent != 'all' && empty($date)) {
                $SalesHistories = SalesHistory::where('agentRef', $agent)->orderBy('updated_at', 'desc')->get();
            }
        
            // dd($SalesHistories,$agent ,$date);
            $user_list       = [];
            $engin_list      = [];
            $totalSales      = 0;
    
            foreach($SalesHistories as $SalesHistory){
                $enrollHistory  = EnrollHistory::find($SalesHistory->enrollId);
                $agent_vente    = User::find($SalesHistory->agentRef);
                $user           = User::find($enrollHistory->userId);
                $engin          = Engins::find($enrollHistory->enginId);
                $vignette       = Vignettes::where('enginId', $enrollHistory->enginId)
                                      ->first();
    
                if ($vignette) {
    
                    $totalSales += $engin->tarif;
    
                    $user_list[]    = [
                        'usager'    => $user->firstname." ".$user->lastname,
                        'userphone' => $user->phone,
                        'marque'    => $engin->marque,
                        'modele'    => $engin->modele,
                        'chassie'   => $engin->chassie,
                        'agent'     => $agent_vente->firstname.' - '.$agent_vente->phone,
                        'tarif'     => $engin->tarif,
                    ];
                } 
            }
    
    
            $SalesHistories = $user_list;
    
            $data = [
                'SalesHistories'    =>$SalesHistories,
                'totalSales'        =>$totalSales,
                'fileName'          =>$fileName,
            ];
    
          view()->share('data',$data);
        //   $pdf = PDF::loadView('guichet.rapportVente', ['data' => $data])->setOptions(['defaultFont' => 'sans-serif']);
          // download PDF file with download method
        //   return $pdf->download($fileName.'.pdf');
        
        $path = storage_path('reports');
    
        // dd($path);
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
    
        } 
        else {}
    
    
        $pdf = PDF::loadView('guichet.rapportVente',['data' => $data])->setOptions(['defaultFont' => 'sans-serif'])
                  ->save(''.$path.'/'.$fileName.'.pdf');
    
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
          return $pdf->download($fileName.'.pdf');
        

        }

    }

    public function salesReport()
    {
                        
        $this->middleware('can:regisseur-public');
        $today      = Carbon::now();
        $today      = $today->format('d-m-Y');
        $fileName   = 'Rapport Vente'.' - '.$today;

        $SalesHistories = SalesHistory::WhereDay('created_at', Date('d'))->orderBy('updated_at', 'desc')->get();

        $user_list       = [];
        $engin_list      = [];
        $totalSales      = 0;

        foreach($SalesHistories as $SalesHistory){
            $enrollHistory  = EnrollHistory::find($SalesHistory->enrollId);
            $agent_vente    = User::find($SalesHistory->agentRef);
            $user           = User::find($enrollHistory->userId);
            $engin          = Engins::find($enrollHistory->enginId);
            $vignette       = Vignettes::where('enginId', $enrollHistory->enginId)
                                  ->first();

            if ($vignette) {

                $totalSales += $engin->tarif;

                $user_list[]    = [
                    'usager'    => $user->firstname." ".$user->lastname,
                    'userphone' => $user->phone,
                    'marque'    => $engin->marque,
                    'modele'    => $engin->modele,
                    'chassie'   => $engin->chassie,
                    'agent'     => $agent_vente->firstname.' - '.$agent_vente->lastname.' - '.$agent_vente->phone,
                    'tarif'     => $engin->tarif,
                ];
            } 
        }


        $SalesHistories = $user_list;

        $data = [
            'SalesHistories'    =>$SalesHistories,
            'totalSales'        =>$totalSales,
            'fileName'          =>$fileName,
        ];

      view()->share('data',$data);
    //   $pdf = PDF::loadView('guichet.rapportVente', ['data' => $data])->setOptions(['defaultFont' => 'sans-serif']);
      // download PDF file with download method
    //   return $pdf->download($fileName.'.pdf');
    
    $path = storage_path('reports');


    $pdf = PDF::loadView('guichet.rapportVente',['data' => $data])
                ->setOptions(['defaultFont' => 'sans-serif']);

    $report_storage_path    = 'reports/'.$fileName.'.pdf';

    
    $report_storage = \Storage::disk('public')
                ->put($report_storage_path, $pdf->output());

    // dd($report_storage);
    // Update report if existing track 
    $report_check = Report::where('report_name', $fileName)
                            ->first();

    if (empty($report_check)) {
        $report_track = Report::create([
            'user_id'       => Auth::user()->id,
            'report_name'   => $fileName
        ]);
    }


    $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
      return $pdf->download($fileName.'.pdf');
    
    }

    public function salesReportFilter(Request $request)
    {
       
    }


    public function salesReportList()
    {        
        $this->middleware('can:read-report');
        $date = Carbon::now();
        $date = Carbon::parse($date);
        $date = $date->format('Y');
        
        
        $reports = Report::whereYear('created_at', Date('Y'))->get();
        $roles   = Role::get();
        $user_role = '';

        $report_datas = [];

        foreach ($reports as $report) {
            $user = User::findOrfail($report->user_id);

            foreach ($roles as $role) {
                if (Auth::user()->hasRole('$role->name')) {

                dd($role);
                   $user_role = $role->name;
                   dd($user_role);
                }
            }

            $report_datas [] = [
                'report'    => $report,
                'user_name' => $user->firstname.' '.$user->lastname,
                'user_phone' => $user->phone,
                'user_role' => $user_role
            ];

        }

        return view('Rapports.index')
        ->with('report_datas', $report_datas);
    }


    public function showReport($repot_name)
    {
        // file path        
        $this->middleware('can:read-report');
       $path = public_path('storage/reports' . '/' . $repot_name);
       $path = $path.'.pdf';

       // dd($path);
    if(!File::exists($path)) {
        die();

    } 
    else {}

        // header
       $header = [
         'Content-Type' => 'application/pdf',
         'Content-Disposition' => 'inline; filename="' . $repot_name . '"'
       ];

      return response()->file($path, $header);
    
    }


    
}
