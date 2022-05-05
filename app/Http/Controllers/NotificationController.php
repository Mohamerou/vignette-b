<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function select(string $notificationId)
    {
        $userUnReadNotifications = Auth::user()->unreadNotifications;

        foreach ($userUnReadNotifications as $userUnReadNotification) {
            if ($userUnReadNotification->id === $notificationId) 
            {
                dd($userUnReadNotification);
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
