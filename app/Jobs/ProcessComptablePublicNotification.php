<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Notifications;
use App\Notifications\ComptablePublicNotification;

class ProcessComptablePublicNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // private $comptable_id;
    // private $demande;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($comptable_id, $demande)
    {
        // $this->$comptable_id = $comptable_id;
        // $this->comptable     = User::find($comptable_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
    }
}
