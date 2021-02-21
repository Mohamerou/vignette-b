<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Vignettes;
use App\Models\TrackDemandeVignette;
use App\Models\Declarations;
use App\Models\Administration;
use App\Models\Engins;
use App\Notifications\DemandeVignette;
use App\Notifications\DemandeValider;
use Notification;
use auth;
use DB;

use Illuminate\Http\Request;

class VignettesController extends Controller
{

    public function demande_de_vignette($engin_id, $user_id)
    {
        //dd($engin_id);
        // Grabbbing $userId and $enginId from tokenized request
        $enginId    		= substr($engin_id, 64);
        $userId     		= substr($user_id, 64);
        $engin_a_modifier   = Engins::find($enginId)->first();


        // Codec de l'administration ciblée                        
        $mairieCode = $engin_a_modifier->mairie;
        $mairie     = Administration::where('code', $mairieCode)->first();
        $mairieId   = $mairie->id;

        /// Notification processing
        $toBeNotified = \App\Models\User::where('administration', $mairieCode)->first();

        #Keeping track of tax label requests
        $demandeTrack                       = new TrackDemandeVignette;
        $demandeTrack->userId               = $userId;
        $demandeTrack->enginId              = $enginId;
        $demandeTrack->administrationId     = $mairieId;
        $demandeTrack->save();

        $demande = [
            'greeting'              => 'Salut!',
            'body'                  => 'Je voudrais acheter une vignette pour ma moto.\n Merci de retrouver les documents requis pour ce faire.',
            'thanks'                => 'Dans l\'attente d\'une  bonne suite favorable, veillez agréer Mr/Mme l\'expression de mes salutations les plus distinguées',
            'actionText'            => 'Verification',
            'actionURL'             => url('/dashboard/'),
            'demandeTrackId'        => $demandeTrack->id,
            'userId'                => $userId,
            'enginId'               => $enginId,
            
        ];


        Notification::send($toBeNotified, new DemandeVignette($demande));

        return redirect()->route('engins.index')->with('message', 'Votre demande a bien été envoyée!');
        
    }


    public function notificationListing()
    {
        $unReadNotifications  = auth()->user()->unReadNotifications;
        $ReadNotifications    = auth()->user()->ReadNotifications;

        return view('user.notifications')->with('unReadNotifications', $unReadNotifications)
                                         ->with('ReadNotifications',$ReadNotifications);
    }


    public function notificationShow($notificationToMarkAsRead)
    {
        
        
        $user 			= auth()->user();
        $notification 	= Auth()->user()->notifications->where('id',$notificationToMarkAsRead)                                           ->first();
        $notification->markAsRead();
        return view('user.notificationShow')->with('toBeReadNotification', $notification);   
                
        	
    }


    Public function downloadQr($qr_path)
    {

        //return response()->download($qr_path, $name, $headers);
        return response()->download(storage_path("app/public/{$qr_path}"));
    }


     // User thief of property declaration
    public function declaration_de_perte($userId, $vignetteId, $enginId)
    {
    
        $userId                     = Auth()->user()->id;
        $vignette                   = Vignettes::find($vignetteId);
        $engin                      = Engins::find($enginId);
        $vignette_unique_token      = $vignette->unique_token;

        $Declaration    = Declarations::create([
            'vignette_token'    => $vignette_unique_token,
            'vignetteId'        => $vignetteId,
            'enginId'           => $enginId,
            'userId'            => $userId,
            'chassie'           => $engin->chassie,
        ]);

        if ($Declaration) {

            $updateEngin = DB::table('engins')
                              ->where('id', $enginId)
                              ->update(['signaler_perdue' => 1]);
            return redirect()->route('engins.index')->with('declared', 'Déclaration soumise avec succès!');
        }

        //return back()->with('declared', 'Déclaration soumise avec succès!');
        return back()->with('error', "Une erreur s\'est produite lors de la déclaration. \nVeillez réessayer!");
    }


     public function annuler_declaration($userId, $vignetteId, $enginId)
    {
        $vignette               = Vignettes::find($vignetteId)->first();
        $vignette_unique_token  = $vignette->unique_token;
        $declaration            = Declarations::firstWhere('vignette_token', $vignette_unique_token);
        $engin                  = Engins::find($enginId)->first();


        $engin->signaler_perdue = 0;
        
        if($engin->save())
        {
            // Withdraw declaration
            $declaration->delete();
            return redirect()->route('engins.index')->with('annuler', 'Déclaration annulée avec succès!');
        }

        return back()->with('annuler', "Déclaration annulée avec succeè!");



        
    }


     public function renouveller_vignette($userId, $vignetteId, $enginId)
    {
        $vignette               = Vignettes::find($vignetteId)->first();
        //$vignette->created_at   = Carbon::now();       
        
        $expired_at = new Carbon();
        $expired_at = $expired_at->addYear();
        $expired_at = Carbon::parse($expired_at)->format('Y-m-d H:i:s');

        $vignette->expired_at = $expired_at;
        $vignette->save();

        if($vignette)
        {
            return redirect()->route('engins.index')->with('renouveller', 'Vignette renouvellée avec succès!');
        }

        return back()->with('error', "La tentative de renoullement a échouée. \nVeillez réessayer!");



        
    }

}
