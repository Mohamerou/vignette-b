<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Notification;
use App\Notifications\TransfertEnginNotification;

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

            $documentJustificatifLoaded   = \Storage::disk('public')->putFile('DocumentsEngins', $request->file('documentJustificatif'));
        
        if($documentJustificatifLoaded == False){

            $engin->delete();
            return redirect()->route('user.selectEnginType')
                             ->with('error', 'Erreur d\'enregistrement! Vérifier votre connexion internet puis réessayer.')
                             ->withInput();
        }

            $history = EnrollHistory::where('userId', Auth::user()->id)->first();
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



    public function initiateTransfert(int $enginId)
    {

        $engin = Engins::findOrfail($enginId);
        $data  = [
            'marque'    => $engin->marque,
            'type'      => $engin->modele,
            'chassie'   => $engin->chassie,
            'enginId'   => $engin->id,
        ];

        return view('user.engins.initiateTransfert')->with('data', $data);
    }


    public function pendingTransfert()
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
            'newOwnerPhone' 	=> 'required|regex:/^[0-9]{8}$/|digits:8',
            'enginId'           => 'required|numeric',
        ]);


        $validatedData  = request()->all();

        $check_new_owner_exists  = User::where('phone', $validatedData['newOwnerPhone'])->first();
        if ($check_new_owner_exists->id === Auth::user()->id) {
            return redirect()->route('engins.index')->with('error', 'Numero non valide !');
        }

        $check_new_owner_exists  = User::where('phone', $validatedData['newOwnerPhone'])->first();
        if (empty($check_new_owner_exists)) {
            return redirect()->route('engins.index')->with('error', 'Aucun compte trouve !');
        }

        $engin      = Engins::find($validatedData['enginId']);
        



        if (empty($engin)) {
            return redirect()->route('engins.index')->with('error', 'Aucun engin !');
        }

        $oldOwner   = User::findOrfail($engin->userId);
        if($oldOwner->id != Auth::user()->id)
        {
            return redirect()->route('engins.index')->with('error', 'Aucun droit d\'acces !');
        }

        
        $newOwner           = User::where('phone', $validatedData['newOwnerPhone'])->first();        


        $ifTrackingExists  = TransfertTrack::where('chassie', $engin->chassie)
                                             ->first();

        if (!empty($ifTrackingExists)) {
            return redirect()->route('engins.index')->with('error', 'Transfert en cours, attente de confirmation !');
        }
        
        $TranfertTrack     = TranfertTrack::create([
            'newOwnerPhone' => $validatedData['newOwnerPhone'],
            'oldOwnerPhone' => Auth::user()->phone,
            'chassie'       => $engin->chassie,
        ]);

        $demande = [
            'demande'               => 'Nouveau Transfert de propriete d\'engin !',
            'oldOwnerId'            => $oldOwner->id,
            'enginid'               => $engin->id,
            
        ];

        Notification::send($newOwner, new TransfertEnginNotification($demande));

        return redirect()->route('engins.index')->with('success', 'Transfert initier avec succes !');


    }

    public function validateTransfert(string $notificationId)
    {
        $userNotifications = Auth::user()->unreadNotifications;
        $newOwner          = Auth::user();
        $toBeMarkedRead    = '';

        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) 
            {
                $toBeMarkedRead     = $userUnReadNotification;
                $engin              = Engins::findOrfail($notification->data['enginId']);
                $oldOwner           = User::findOrfail($notification->data['oldOwnerId']);

                $engin->userId      =  $newOwner->id;
                $vignette           = Vignettes::where('enginId', $engin->id)->first();

                if (!empty($vignette)) {
                    $vignette->userId       =  $newOwner->id;
                }

            }
        }


        $toBeMarkedRead->markAsRead();
        return redirect()->route('engins.index')
        ->with('success', 'transfert valide avec succes !');



    }

}
