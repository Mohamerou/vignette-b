<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vignettes;
use App\Models\Engins;
use App\Models\UsagerAccountType;
use App\Models\EnrollHistory;



class UsagerController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:guichet');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentDate = Carbon::now();
        $currentDate = Carbon::parse($currentDate);
        $currentDate = $currentDate->format('d-m-Y');

        $users = User::get();
        $user_list = [];
        foreach ($users as $user) {
            if (!($user->hasRole('user'))) {
            } else {
                $user_list[] = $user;
            }
        }

        // dd($user_list);
        return view('guichet.user.index')
        ->with('user_list', $user_list)
        ->with('date', $currentDate);
    }



    public function entreprise()
    {
        $currentDate = Carbon::now();
        $currentDate = Carbon::parse($currentDate);
        $currentDate = $currentDate->format('d-m-Y');

        $users = User::get();
        $user_list = [];
        foreach ($users as $user) {
            if (!($user->hasRole('user'))) {
            } else {
                $account   = UsagerAccountType::where('user_id', $user->id)->first();
                if (empty($account)) {
                    return redirect()->route('get-admin-dash')->with('error', 'Compte introuvable !');
                }
                if ($account->type==='entreprise') {
                    $user_list[] = $user;
                }
            }
        }
        // dd($user_list);
        return view('guichet.entSalesIndex')
        ->with('user_list', $user_list)
        ->with('date', $currentDate);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user           = User::findOrfail($id);
        $user_name      = $user->firstname.' '.$user->lastname.' '.$user->phone;
        $account_type   = UsagerAccountType::where('user_id', $user->id)->first();
        $vignettes      = Vignettes::where('userId', $user->id)->get();
        $user_data      = [];

        foreach ($vignettes as $vignette) {
            $engin      = Engins::find($vignette->enginId);

            $user_data []   = [
                'vignette_status'       => $vignette->status,
                'engin_marque'          => $engin->marque,
                'engin_type'            => $engin->modele,
                'engin_chassie'         => $engin->chassie,
                'signaler_perdue'       => $engin->signaler_perdue,
            ];
        }

        // dd($user_data);
        return view('guichet.user.show')
                ->with('user_data', $user_data)
                ->with('user_name', $user_name)
                ->with('user_id', $user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user           = User::findOrfail($id);
        $account_type   = UsagerAccountType::where('user_id', $user->id)->first();

        return view('guichet.user.edit')
               ->with('account_type', $account_type->type)
               ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        // dd($request->idCard);
        request()->validate([
            'lastname' 	             => 'required|string',
            'firstname'              => 'required|string',
            'address'                => 'required|string',
            'phone' 	             => 'required|regex:/^[0-9]{8}$/|digits:8',
            'account_type' 	         => 'required|string|max:10',
        ]);

        $double_check_user_new_phone_duplicate = false;
        $request_phone_user  = User::where('phone', $request->phone)->first();

        
        if (!empty($request_phone_user)) {
            if ($request_phone_user->id != $id) {
                $double_check_user_new_phone_duplicate = true;
            }
        }

        if ($double_check_user_new_phone_duplicate) {
            # code...
            return redirect()->route('guichet.user.index')
                             ->with('error', 'Cet numero est attribue a un compte!')
                             ->withInput();
        }



        //dd($key);
        $data           = $request->all();
        $user           = User::findOrfail($id);
        $user->lastname 	= $data['lastname'];
        $user->firstname    = $data['firstname'];
        $user->address      = $data['address'];
        $user->phone 	    = $data['phone'];
        $user->save();


        if ($request->has('idCard')) {
            request()->validate([
                'idCard'                 => 'required'
            ]);

            $userIdCardEtx      = $request->file('idCard')->getClientOriginalExtension();
            $idCardPath         = "idCard/idCard-".time().'.'.$userIdCardEtx;
            $idCardLoaded       = \Storage::disk('public')->put($idCardPath, file_get_contents($request->file('idCard')));
            
            if ($idCardLoaded == false) {
                return redirect()->route('guichet.user.edit')
                                ->with('error', 'Vérifier la connexion internet puis réessayer!.')
                                ->withInput();
            }

            $user->idCard       = $idCardPath;
            $user->save();
        }


        $account_type         = UsagerAccountType::where('user_id', $user->id)->first();
        $account_type->type   = $data['account_type'];
        $account_type->save();

        //  $this->sendOPT($telephone, $code, $user_pass);
        return redirect()->route('guichet.user.index')->with('success', 'Compte mise a jour avec succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function renouveller_vignette($chassie)
    {
        $engin                       = Engins::where('chassie', $chassie)->first();
     
        $user                       = User::find($engin->userId);
        $vignette                   = Vignettes::where('enginId', $engin->id)->first();
        //$vignette->created_at   = Carbon::now();
        
        $expired_at = new Carbon();
        $expired_at = $expired_at->addYear();
        $expired_at = Carbon::parse($expired_at)->format('Y-m-d H:i:s');

        $vignette->expired_at = $expired_at;
        $vignette->save();

        if ($vignette) {
            return redirect()->route('guichet.user.show', $user)->with('success', 'Vignette renouvellée avec succès!');
        }

        return redirect()->route('guichet.user.show', $user)->with('error', "La tentative de renoullement a échouée. \nVeillez réessayer!");
    }

    public function fiche_individuel($userId)
    {
        $user                    = User::find($userId);

        $fileName                = $user->firstname.'-'.$user->lastname.'-'.$user->phone;

        $data = [
            'firstname'         =>$user->firstname,
            'lastname'          =>$user->lastname,
            'idCard'            =>$user->idCard,
            'phone'             =>$user->phone,
            'address'           =>$user->address,
        ];

        //   view()->share('data',$data);
        //   $pdf = PDF::loadView('guichet.rapportVente', ['data' => $data])->setOptions(['defaultFont' => 'sans-serif']);
        // download PDF file with download method
        //   return $pdf->download($fileName.'.pdf');
    
        $path = storage_path('ficheIndividuels');

        // dd($path);
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
        } else {
        }


        // $pdf = PDF::loadView('guichet.user.ficheIndividuel',['data' => $data])->setOptions(['defaultFont' => 'sans-serif'])
        //           ->save(''.$path.'/'.$fileName.'.pdf');

        // $pdf->getDomPDF()->setHttpContext(
        //     stream_context_create([
        //         'ssl' => [
        //             'allow_self_signed'=> TRUE,
        //             'verify_peer' => FALSE,
        //             'verify_peer_name' => FALSE,
        //         ]
        //     ])
        // );
        //   return $pdf->download($fileName.'.pdf');

        return view('guichet.user.ficheIndividuel')->with('data', $data);
    }




    public function nouvel_engin($user_id)
    {
        return view('guichet.user.nouvelEngin')
                ->with('user_id', $user_id);
    }

    public function post_nouvel_engin(Request $request)
    {
        request()->validate([
            'user_id' 	             => 'required|numeric',
            'marque'                 => 'required|string',
            'modele'                 => 'required|string',
            'mairie' 	             => 'required|string',
            'chassie'                => 'required|string',
            'cylindre' 	     => 'required|string',
            'documentJustificatif' 	 => 'required|file|image|max:10096',
        ]);

        $data           = $request->all();
        $usager         = User::find($data['user_id']);

        // Check limits
        $account_type   = UsagerAccountType::where('user_id', $usager->id)
                                           ->first();
        $account_type   = $account_type->type;
        
        $limit          = Engins::where('userId', $usager->id)->count();

        
        if ($limit === 1000) {
            $limit = true;
        }

        if ($account_type === "usager") {
            if ($limit === true) {
                return redirect()->route('guichet.user.engin.nouvel', $usager)
                                 ->with('error', "Nombre maximal d'enregistrement atteint!");
            }
        }



        $IfEnginExist    = Engins::where('chassie', $data['chassie'])->first();
        if ($IfEnginExist) {
            return redirect()->route('guichet.user.engin.nouvel', $usager)
                            ->with('error', 'Numero de chassie non disponible!')
                            ->withInput();
        }

                                    
        $engin  = $this->createEngin($data);

        $documentJustificatifLoadedEtx              = $request->file('documentJustificatif')->getClientOriginalExtension();
        $documentJustificatifLoaded_storage_path    = 'DocumentsEngins/engin-' . time() . '.' .$documentJustificatifLoadedEtx;
        // $documentJustificatifLoaded                 = \Storage::disk('public')->put($documentJustificatifLoaded_storage_path, file_get_contents($request->file('documentJustificatif')));
        $documentJustificatifLoaded                 = \Storage::disk('s3')->put($documentJustificatifLoaded_storage_path, file_get_contents($request->file('documentJustificatif')));
        $engin->documentJustificatif                = $documentJustificatifLoaded_storage_path;
        $engin->save();
        

        // $idCardLoaded       = $this->storeIdCard($User);

        if ($documentJustificatifLoaded == false) {
            $engin->delete();
            return redirect()->route('guichet.user.show', $usager)
                             ->with('error', 'Erreur d\'enregistrement! Vérifier votre connexion internet puis réessayer.')
                             ->withInput();
        }

        return $this->sendOTPEngin($usager->phone, $request->marque, $request->modele, $request->chassie);
    }




    public function sendOTPEngin($phone, $marque, $modele, $chassie)
    {
        $user       = User::where('phone', $phone)->first();
        $engin      = Engins::where('chassie', $chassie)->first();
        $userId     = $user->id;

        // $OTP = Nexmo::message()->send([
        //                                 'to'   => '+223'.$phone,
        //                                 'from' => '+22369141418',
        //                                 'text' => "ikaVignetti, l\'enrollement de votre engin est effectif\n\n\
        //                                             Marque: ".$marque."\n
        //                                             Modele: ".$modele."\n
        //                                             Chassie: ".$chassie."\n",
        //                                 ]);


        // Enroll History backUp
        $history = new EnrollHistory();
        $history->agentRef      =   Auth::user()->id;
        $history->agentName     =   Auth::user()->firstname;
        $history->agentPhone    =   Auth::user()->phone;
        $history->userId        =   $userId;
        $history->enginId = $engin->id;
        $history->status = 1;
        $history->save();


        return redirect()->route('pendingSales')->with('success', 'Engin ajoute avec succes !');
    }



    public function createEngin(array $data)
    {
        $engin =  Engins::create([
            'userId' 	        => $data['user_id'],
            'marque'            => $data['marque'],
            'modele'            => $data['modele'],
            'mairie'            => Auth::user()->administration,
            'chassie' 	        => $data['chassie'],
            'cylindre' 	        => $data['cylindre'],
        ]);
        
        $tarif = 0;

        if ($engin->cylindre === "+125") {
            $engin->tarif = 12000;
        }
        $engin->save();

        if ($engin->cylindre === "125") {
            $engin->tarif = 6000;
        }
        $engin->save();

        if ($engin->cylindre === "51") {
            $engin->tarif = 3000;
        }
        $engin->save();

        if ($engin->cylindre === "0") {
            $engin->tarif = 1500;
        }
        $engin->save();


        return $engin;
    }


    public function list_engin($user_id)
    {
        $user                    = User::find($user_id);

        $engin_list = Engins::where('userId', $user_id)->get();
        return view('guichet.user.enginsList')->with('user', $user)
                                    ->with('enginList', $engin_list);
    }


    public function edit_engin($engin_id)
    {
        $engin = Engins::find($engin_id);

        return view('guichet.user.editEngin')->with('engin', $engin);
    }

    public function update_engin(Request $request, int $id)
    {
        $this->middleware('can:guichet');

        request()->validate([
            'user_id' 	             => 'required|numeric',
            'marque'                 => 'required|string',
            'modele'                 => 'required|string',
            'chassie'                => 'required|string',
            'cylindre' 	             => 'required|string',
        ]);


        $double_check_chassie_duplicate = false;
        $request_chassie_engin  = Engins::where('chassie', $request->chassie)->first();

    
        if (!empty($request_chassie_engin)) {
            if ($request_chassie_engin->id != $id) {
                $double_check_chassie_duplicate = true;
            }
        }

        if ($double_check_chassie_duplicate) {
            # code...
            return redirect()->route('guichet.user.index')
                         ->with('error', 'Cet numero est attribue a un compte!')
                         ->withInput();
        }

        //dd($key);
        $data           = $request->all();
        $engin           = Engins::findOrfail($id);
        $engin->marque 	= $data['marque'];
        $engin->modele    = $data['modele'];
        $engin->chassie      = $data['chassie'];
        $engin->cylindre 	    = $data['cylindre'];
        $engin->save();


        if ($request->has('documentJustificatif')) {
            request()->validate([
            'documentJustificatif'                 => 'required'
        ]);

        
            $documentJustificatifLoadedEtx              = $request->file('documentJustificatif')->getClientOriginalExtension();
            $documentJustificatifLoaded_storage_path    = 'DocumentsEngins/engin-' . time() . '.' .$documentJustificatifLoadedEtx;
            $documentJustificatifLoaded                 = \Storage::disk('public')->put($documentJustificatifLoaded_storage_path, file_get_contents($request->file('documentJustificatif')));
        
            if ($documentJustificatifLoaded == false) {
                return redirect()->route('guichet.user.editEngin')
                            ->with('error', 'Vérifier la connexion internet puis réessayer!.')
                            ->withInput();
            }

            $engin->documentJustificatif                = $documentJustificatifLoaded_storage_path;
            $engin->save();

        }
        return redirect()->route('guichet.user.index')->with('success', 'Engins mise a jour avec succes!');

    }
}