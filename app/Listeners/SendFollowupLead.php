<?php

namespace App\Listeners;

use App\Events\AgentRejectsALead;
use App\Models\FollowupQueue;
use App\Models\FollowupEmail;
use App\Models\State;
use App\Mail\MailFollowupLead;
use App\Services\Queue\FollowupQueueService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class SendFollowupLead implements ShouldQueue
{
     use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AgentRejectsALead  $event
     * @return void
     */
    public function handle($event)
    {
        $waitingStateId = State::getstate('waiting')->id;
        $reservedStateId = State::getstate('reserved')->id;
        $followupEmails = FollowupEmail::where('state_id', $waitingStateId)->get()->take(10);
        foreach($followupEmails as $followupEmail) {
            $agentQueue = FollowupQueueService::nextInQueue($followupEmail);
            if(!$agentQueue) {
                continue;
            }
            $queue = new FollowupQueueService($agentQueue->user);
            $queue->loadUserQueue('waiting', true);
            $queue->assign($followupEmail);
            $followupEmail->state_id = $reservedStateId;
            $followupEmail->save();

            Mail::send(new MailFollowupLead($queue->getUserCurrentQueue()));
            Log::channel('daily_info')->info('Followup sent to Agent: ' . $agentQueue->user->gmail . " Queue ID: " . $queue->getUserCurrentQueue()->id );
        }
    }
}
