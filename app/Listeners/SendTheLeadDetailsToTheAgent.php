<?php

namespace App\Listeners;

use App\Events\AgentRejectsALead;
use App\Models\FollowupQueue;
use App\Models\FollowupEmail;
use App\Models\State;
use App\Mail\MailLeadDetails;
use App\Services\Queue\FollowupQueueService;
use App\Services\UserSetting\UserSettingService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class SendTheLeadDetailsToTheAgent implements ShouldQueue
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
     * Handle the event only send if user allowed the notification default to yes (no settings stored)
     *
     * @param  AgentRejectsALead  $event
     * 
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $userSerivce = new UserSettingService($user);
        $userSetting = $userSerivce->getUserSetting('ENABLE_LEAD_DETAILS_EMAIL');

        if ($userSetting == false || $userSetting->meta_value == 1) {
            $followupEmail = $event->followupEmail;
            Mail::send(new MailLeadDetails($user, $followupEmail));
        }
    }
}
