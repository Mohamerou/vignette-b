<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Notification;
use App\Notifications\TransfertEnginNotification;
use App\Notifications\ApproveTransfertEnginNotification;

use App\Models\User;
use App\Models\TransfertTrack;
use App\Models\Engins;
use Illuminate\Http\Request;
use App\Models\Marque;
use App\Models\Administration;
use App\Models\EnrollHistory;
use App\Models\Vignettes;
use Carbon\Carbon;

class EnginsController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:user');      
    }



    public function selectEnginType()
    {

        return view('user.engins.selectType');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user           = Auth::user();
        $userId         = Auth::user()->id;
        $engins         = Engins::where('userId', $userId)->get();
        $vignettes      = Vignettes::where('userId', $userId)->get();



        
        if (!$engins->first()) {
            
            $empty = true;
            return view('user.engins.index')->with([
                'empty'     => $empty,
                'user'      => $user
                ]);
        }
        else {
           
            $empty = false;

            $awaiting_confirmation       = array();
            $up_to_date_vignettes        = array();
            $up_to_date_engins           = array();
            $out_dated_vignettes         = array();
            $out_dated_engins            = array();
            


            //////// ||- Vignettes encours ou expirées -|| \\\\\\\\\
            foreach ($vignettes as $vignette) 
            {
                $today                      = new Carbon();
                $vignette_expires_at        = $vignette->expired_at;
                

                //dd($vignette->expired_at);

                if($vignette->expired_at < $today){
                    $out_dated_vignettes[]   = $vignette;
                    $out_dated_engins[]      = Engins::where('id', $vignette->enginId)->first();
                }
                else{

                    $up_to_date_vignettes[]   = $vignette;
                    $up_to_date_engins[]      = Engins::where('id', $vignette->enginId)->first();
                }

            }
        }

        //dd($up_to_date_engins);

        //////// ||- Engins en attente de confirmation de vignette -|| \\\\\\\\\
        foreach ($engins as $engin) 
        {
            if (is_null($engin->vignetteId)) {
                
                $awaiting_confirmation[]   = $engin;
            }
        }

        //dd($awaiting_confirmation);
        //dd($vignette_less);
       
        //dd($confirmed_vignette_ids);

        return view('user.engins.index')->with([
            'empty'                         => $empty,
            'userId'                        => $userId,
            'awaiting_confirmations'        => $awaiting_confirmation,
            'up_to_date_vignettes'          => $up_to_date_vignettes,
            'out_dated_vignettes'           => $out_dated_vignettes,
            'up_to_date_engins'             => $up_to_date_engins,
            'out_dated_engins'              => $out_dated_engins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $marques = Marque::all();
        $mairies = Administration::all();
        switch ($type) {
            case 'moto51-125':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            
            default:
                return view('user.engins.selectType')->with('unknown', 'Choix indisponible!');
                break;
        }
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
        $userId = Auth::user()->id;

        request()->validate([
            'marque'                => 'required|string',
            'modele'                => 'required|string',
            'mairie'                => 'required|string',
            'chassie'               => 'required|string',
            'cylindre'              => 'required|string',
            'tarif'                 => 'required|integer',
            'documentJustificatif'  => 'required|file|image|max:4096',
        ]);

        $data           = request()->all();
        $IfEnginsExist  = Engins::where('chassie', $data['chassie'])->first();
        if($IfEnginsExist)
        {
            return back()->with('error', 'Un engin est enregistré sous le même numero de chassie')
                         ->withInput();
        }
        
        $engin =  Engins::create([
            'userId'                => $userId,
            'marque'                => $data['marque'],
            'modele'                => $data['modele'],
            'mairie'                => $data['mairie'],
            'chassie'               => $data['chassie'],
            'cylindre'              => $data['cylindre'],
            'tarif'                 => $data['tarif'],
            'documentJustificatif'  => $data['documentJustificatif'],
        ]);

            $token1 = md5(rand(1, 15) . microtime());
            $token2 = md5(rand(1, 15) . microtime());
            $token3 = md5(rand(1, 15) . microtime());
            $token4 = md5(rand(1, 15) . microtime());

            $enginId        = $engin->id;
            $enginId        = $token2.$token1.$enginId;
            $userId         = $token4.$token3.$userId;

            // $documentJustificatifLoaded = $this->storeFacture($engin);

            $documentJustificatifLoadedEtx              = $request->file('documentJustificatif')->getClientOriginalExtension();
            $documentJustificatifLoaded_storage_path    = 'DocumentsEngins/engin-' . time() . '.' .$documentJustificatifLoadedEtx;
            $documentJustificatifLoaded                 = \Storage::disk('public')->put($documentJustificatifLoaded_storage_path, file_get_contents($request->file('documentJustificatif')));
            $engin->documentJustificatif                = $documentJustificatifLoaded_storage_path;
            $engin->save();

        if($documentJustificatifLoaded == False){

            $engin->delete();
            return redirect()->route('user.selectEnginType')
                             ->with('error', 'Erreur d\'enregistrement! Vérifier votre connexion internet puis réessayer.')
                             ->withInput();
        }

            // $history = EnrollHistory::where('userId', Auth::user()->id)->first();
            // Enroll History backUp
            $history = new EnrollHistory();
            $history->agentRef      =   $User->id;
            $history->agentName     =   $User->firstname;
            $history->agentPhone    =   $User->phone;
            $history->userId        =   $User->id;
            $history->enginId   = $engin->id;
            $history->status = 1;
            $history->save();

            //dd("Okay");
            //return redirect()->route('user.demande_vignette', [['userdId' => $userId],['enginId' => $engin->id]]);

            // return redirect('/vignettes/'.$enginId.'/'.$userId);

            return redirect()->route('home')
                             ->with('success', 'Engin ajoute avec succes! Veuillez vous rendre a la caisse pour le payement.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function show(Engins $engins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function edit(Engins $engins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Engins $engins)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engins $engins)
    {
        //
    }

    // private function storeFacture($engin)
    // {
    //     if (request()->has('documentJustificatif')) {
    //         $engin->update([
    //             'documentJustificatif' => request()->documentJustificatif->store('uploads/enginDocument', 's3'),
    //         ]);
    //     }
    // }


    public function initiateTransfert()
    {
        return view('user.engins.initiateTransfert');
    }

    public function showTransfert($notificationId)
    {
        $userUnReadNotifications = Auth::user()->unReadNotifications;
        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) 
            {   
                $engin      = Engins::where('chassie', $userUnReadNotification->data['chassie'])->first();   
                $newOwner   = User::where('phone', $userUnReadNotification->data['newOwnerPhone'])->first();


                $data = [
                    'enginMarque'   =>   $engin->marque,
                    'enginType'     =>   $engin->modele,
                    'enginChassie'  =>   $engin->chassie,
                    'newOwner'      =>   $newOwner->firstname.' '.$newOwner->lastname,
                    'newOwnerPhone' =>   $newOwner->phone,
                    'notificationId'=>   $notificationId,
                ];


                return view('user.engins.showTransfert')
                       ->with('data', $data);
            }
        }
    }


    public function Transfert()
    {
        $notifications  = Auth::user()->unreadNotifications;
        $data           = [];

        foreach ($notifications as $notification) {
            
            $oldOwner           = User::findOrfail($notification->data['oldOwnerId']);
            $oldOwnerPhone      = $oldOwner->phone;
            $oldOwner           = $oldOwner->firstname.' '.$oldOwner->lastname;
            $newOwner           = User::find($notification->data['newOwnerId']);
            $newOwnerPhone      = $newOwner->phone;
            $newOwner           = $newOwner->firstname.' '.$newOwner->lastname;

            $data [] = [
                'oldOwner'          => $oldOwner,
                'newOwner'          => $newOwner,
                'newOwnerPhone'     => $newOwnerPhone,
                'oldOwnerPhone'     => $oldOwnerPhone,
                'notificationId'    => $notification->id,
            ];

        }

        return view('user.engins.transfertownership')
               ->with('Approbations', $data);
    }


    public function transfertOwnership(Request $request)
    {

        request()->validate([
            'oldOwnerPhone' 	=> 'required|regex:/^[0-9]{8}$/|digits:8',
            'chassie'           => 'required|string|max:66',
        ]);


        $validatedData  = request()->all();

        $check_new_owner_exists  = User::where('phone', $validatedData['oldOwnerPhone'])->first();
        if ($check_new_owner_exists->id === Auth::user()->id) {
            return redirect()->route('engins.index')->with('error', 'Numero non valide !');
        }

        $check_new_owner_exists  = User::where('phone', $validatedData['oldOwnerPhone'])->first();
        if (empty($check_new_owner_exists)) {
            return redirect()->route('engins.index')->with('error', 'Aucun compte trouve !');
        }

        // Old owner
        $oldOwner   = $check_new_owner_exists;

        $engin      = Engins::where('chassie',$validatedData['chassie'])->first();

        
        if (empty($engin)) {
            return redirect()->route('engins.index')->with('error', 'Aucun engin trouve avec le chassie indique !');
        }
        if (!($engin->userId === $oldOwner->id)) {
            return redirect()->route('engins.index')->with('error', 'Aucun engin trouve avec les informations indiquees !');
        }

        if($oldOwner->id === Auth::user()->id)
        {
            return redirect()->route('engins.index')->with('error', 'Action non permise !');
        }
      

        $ifTrackingExists  = TransfertTrack::where('chassie', $engin->chassie)
                                             ->first();

        // if (!empty($ifTrackingExists)) {
        //     return redirect()->route('engins.index')->with('error', 'Transfert en cours, attente de confirmation !');
        // }
        
        $TransfertTrack     = TransfertTrack::create([
            'newOwnerPhone' => Auth::user()->phone,
            'oldOwnerPhone' => $oldOwner->phone,
            'chassie'       => $validatedData['chassie'],
        ]);


        $demande = [
            'demande'       => 'Nouvelle demande de transfert de propriete d\'engin !',
            'type'          => 'transfert-initier',
            'newOwnerPhone' => $TransfertTrack->newOwnerPhone,
            'chassie'       => $TransfertTrack->chassie,
        ];



        Notification::send($oldOwner, new TransfertEnginNotification($demande));

        return redirect()->route('engins.index')->with('success', 'Transfert initier avec succes !');


    }

    public function validateTransfert(string $notificationId)
    {
        $oldOwner                   = Auth::user();
        $userUnReadNotifications    = $oldOwner->unreadNotifications;
        $toBeMarkedRead    = '';

        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) 
            {
                $toBeMarkedRead     = $userUnReadNotification;
                $engin              = Engins::where('chassie', $userUnReadNotification->data['chassie'])->first();
                $newOwner           = User::where('phone', $userUnReadNotification->data['newOwnerPhone'])->first();

                $engin->userId      =  $newOwner->id;
                $vignette           = Vignettes::where('enginId', $engin->id)->first();

                if (!empty($vignette)) {
                    $vignette->userId       =  $newOwner->id;
                    $vignette->save();
                }

            }
        }

        
        $engin->save();

        $demandeValidated = [
            'subject'       => 'Tranfert de propriete approuve !',
            'type'          => 'transfert-validated',
            'oldOwnerPhone' => $oldOwner->phone,
            'chassie'       => $engin->chassie,
        ];


        Notification::send($newOwner, new ApproveTransfertEnginNotification($demandeValidated));

        $toBeMarkedRead->markAsRead();
        return redirect()->route('engins.index')
        ->with('success', 'Transfert valide avec succes !');
    }


    //
    public function notificationType(string $notificationId)
    {
        $userUnReadNotifications = Auth::user()->unreadNotifications;

        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) 
            {
                if ($userUnReadNotification->data['type'] === 'transfert-initier') {
                    return redirect()->route('showTransfert.notification', $userUnReadNotification->id);
                }

                if ($userUnReadNotification->data['type'] === 'transfert-validated') {
                    $userUnReadNotification->markAsRead();
                    return redirect()->route('engins.index')->with('success', "Bravo ! Le transfert a bien abouti.");
                }

            }
        }
    }

}
