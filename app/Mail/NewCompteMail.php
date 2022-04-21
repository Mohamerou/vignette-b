<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCompteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $compte_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($compte_data)
    {
        //
        $this->compte_data    = $compte_data;
        $this->subject('Votre compte ikavignetti a ete cree avec succes!');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ikavignetti.ml', 'Compte!')
                    ->view('email.superadmin.NewCompteMail')
                    ->with('compte_data', $this->compte_data);
    }
}
