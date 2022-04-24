<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgentCreateMail;

class ProcessAgentCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $agent_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($agent_data)
    {
        //
        $this->agent_data    = $agent_data;
        // dd($this->agent_data['email']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->agent_data['email'])->send(new AgentCreateMail($this->agent_data));
    }
}
