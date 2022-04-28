<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class DemandeVignette extends Notification implements ShouldQueue
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
        //
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting($this->demande['greeting'])
                    ->line($this->demande['body'])
                    ->action($this->demande['actionText'], $this->demande['actionURL'])
                    ->line($this->demande['thanks']);
    }




    public function toDatabase($notifiable)
    {
        return [
            'subject'           => "Nouvelle demande de vignette",
            'demandeTrackId'    => $this->demande['demandeTrackId'],
            'userId'            => $this->demande['userId'],
            'enginId'           => $this->demande['enginId'],
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
