<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Nexmo;
use App\Models\Engins;
use App\Models\User;
use App\Models\Vignettes;
use App\Notifications\DemandeVignette;
use App\Notifications\DemandeValider;
use App\Models\TrackDemandeVignette;
use Notifications;
use Notification;
use auth;
use Carbon\Carbon;
use DB;
use Redirect;
use Illuminate\Support\Facades\Session;

class GestionVignettesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function examinerDemande($usagerId, $enginId, $notificationId, $demandeTrackId){
    	
    	// User informations
    	$user 			         = User::find($usagerId);
    	$engin 			         = Engins::find($enginId);
        $demande                 = TrackDemandeVignette::find($demandeTrackId);
        $notification            = $notificationId;
        $userNotification        = Auth()->user()->notifications->where('id', $notificationId)                                                    ->first();

        if(!empty($userNotification->read_at))
        {
            return redirect()->route('home')->with("error", "Cette demande a déjà fait l'objet de vérification.");
        }
    	return view('admin.examinerDemande')->with('userId', $usagerId)
							                ->with('usager', $user)
                                            ->with('engin', $engin)
							                ->with('demandeTrackId', $demande)
                                            ->with('notificationId', $notification);
	}



    public function demandeValidation($enginId, $notificationId, $userId, $demandeTrackId)
    {
        ////// ikvUE(User Engin)
        $engin                      = Engins::find($enginId);
        $userNotification           = Auth()->user()->notifications->where('id', $notificationId)->first();
        $usager                     = User::find($userId);


        if(empty($userNotification->read_at)){
             // Vignette unique_token
            $unique_token   = md5(rand(1, 15) . microtime());
            $qr_code        = \QrCode::format('png')
                                       ->encoding('UTF-8')
                                       ->size(250)
                                       ->generate($unique_token);


            $vignette_qr_storage_path   = '/public/uploads/vignettes/vignette-' . time() . '.png';
            
            $vignette_qr_download_path   = 'public/uploads/vignettes/vignette-' . time() . '.png';

            $vignette_qr_access_path    = substr($vignette_qr_storage_path, 8);

            \Storage::disk('s3')->put($vignette_qr_storage_path, $qr_code); //storage/app/public/img/qr-code/img-1557309130.png

            

            $expired_at = new Carbon();
            $expired_at = $expired_at->addYear();
            $expired_at = Carbon::parse($expired_at)->format('Y-m-d H:i:s');

            $vignette                       = new Vignettes;
            $vignette->userId               = $userId;
            $vignette->enginId              = $enginId;
            $vignette->unique_token         = $unique_token;
            $vignette->qr                   = $vignette_qr_storage_path;
            $vignette->qr_download_path     = $vignette_qr_download_path;
            $vignette->expired_at           = Carbon::parse($expired_at)->format('Y-m-d H:i:s');

            $vignette->save();


            $updateEngin = DB::table('engins')
                              ->where('id', $enginId)
                              ->update(['vignetteId' => $vignette->id]);

            if($vignette && $updateEngin){
                $userNotification->markAsRead();

                
                // Notification to User
                $user                   = User::find($userId);
                $demande                = TrackDemandeVignette::find($demandeTrackId);
                $demande->validaded     = 1;
                $demande->note          = "La demande de vignette pour votre ".$engin->modele." est validée avec succès.\n \t\t\t RDV sur le menu \"Mes vignettes\" pour télécharger votre code QR";
                $demande->save();

                

                Notification::send($user, new DemandeValider($demande));


                $code = Nexmo::message()->send([
                                            'to'   => '+223'.$usager->phone,
                                            'from' => '+22389699245',
                                            'text' => "ikV, La demande de vignette pour votre ".$engin->modele." est validée avec succès. Retrouver votre code QR sur le menu ikaVignetti.   ",
                                            ]);
                //dd($vignette);
                return redirect()->route('home')->with('message', 'Demande validée avec succès!');
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

}