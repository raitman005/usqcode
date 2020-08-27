<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\FollowupQueue;
use App\Mail\MailFollowupLead;
use Illuminate\Support\Facades\Mail;

class SendFollowupLeadEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $currentUserQueue;

    public function __construct(FollowupQueue $currentUserQueue)
    {
        $this->currentUserQueue = $currentUserQueue; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::send(new MailFollowupLead($this->currentUserQueue));
    }
}
