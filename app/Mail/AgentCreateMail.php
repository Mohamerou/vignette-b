<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgentCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agent_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agent_data)
    {
        //
        $this->agent_data    = $agent_data;
        $this->subject('Votre compte agent ikavignetti a ete cree avec succes!');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ikavignetti.ml', 'Compte!')
                    ->view('email.agent.createMail')
                    ->with('agent_data', $this->agent_data);
    }
}
