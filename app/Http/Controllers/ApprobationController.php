<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Notifications;
use App\Models\Role;
use App\Models\User;

class ApprobationController extends Controller
{
    
    public function index()
    {
        $notifications  = Auth::user()->unreadNotifications;
        $data           = [];

        foreach ($notifications as $notification) {
            
            $superviseur      = User::findOrfail($notification->data['superviseurId']);
            $superviseurPhone = $superviseur->phone;
            $superviseur      = $superviseur->firstname.' '.$superviseur->lastname;
            $newAgent         = User::find($notification->data['newAgentId']);
            $newAgentPhone    = $newAgent->phone;
            $newAgentId       = $newAgent->id;
            $newAgent         = $newAgent->firstname.' '.$newAgent->lastname;

            $data [] = [
                'superviseur'       => $superviseur,
                'newAgent'          => $newAgent,
                'newAgentPhone'     => $newAgentPhone,
                'superviseurPhone'  => $superviseurPhone,
                'newAgentId'        => $newAgentId,
                'notificationId'    => $notification->id,
            ];

        }

        return view('ApprobationComptable.ApprobationComptable')
               ->with('Approbations', $data);
    }



    public function approve(int $id, string $notificationId)
    {
        $newAgent = User::findOrfail($id);
        $userUnReadNotifications = Auth::user()->unreadNotifications;
        $toBeMarkedRead = $userUnReadNotifications;

        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) {
                $toBeMarkedRead = $userUnReadNotification;
            }
        }

        if(!($newAgent->hasRole('guichet')))
        {
            return redirect()->route('get_admin_dash')
                             ->with('error', 'Aucun compte existant !');
        }

        
        if(!($newAgent->isverified))
        {
            $newAgent->isverified = 1;
            $newAgent->save();
            $toBeMarkedRead->markAsRead();
            
            return redirect()->route('get_admin_dash')
            ->with('success', 'Compte active avec succes !');
        }


        $toBeMarkedRead->markAsRead();
        return redirect()->route('get_admin_dash')
        ->with('error', 'Compte deja actif !');

    }
}
