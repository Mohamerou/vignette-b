<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApproveTransfertEnginNotification extends Notification
{
    use Queueable;

    public $demandeValidated;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($demandeValidated)
    {
        //
        $this->demandeValidated = $demandeValidated;
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
            'subject'           => $this->demandeValidated['subject'],
            'type'              => $this->demandeValidated['type'],
            'oldOwnerPhone'     => $this->demandeValidated['oldOwnerPhone'],
            'chassie'           => $this->demandeValidated['chassie'],
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
