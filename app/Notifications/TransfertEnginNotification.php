<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransfertEnginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $demande;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

 

        

    public function toDatabase($notifiable)
    {
        // dd($this->demande);
        return [
            'subject'           => $this->demande['demande'],
            'type'              => $this->demande['type'],
            'newOwnerPhone'     => $this->demande['newOwnerPhone'],
            'chassie'           => $this->demande['chassie'],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
