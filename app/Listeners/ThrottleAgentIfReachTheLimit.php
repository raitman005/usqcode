<?php

namespace App\Listeners;

use App\Events\AgentAcceptsALead;
use App\Models\User;
use App\Models\FollowuQueue;
use App\Models\State;
use App\Services\CheckIn\CheckInService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Helper;

class ThrottleAgentIfReachTheLimit
{
    /**
     * @var User
     */
    public $user;


    /**
     * Handle the event.
     *
     * @param  AgentAcceptsALead  $event
     * @return void
     */
    public function handle(AgentAcceptsALead $event)
    {
        $this->user = $event->user;
        if(Helper::isUserThrottled($this->user)) {
            $this->user->daily_throttle = 1;
            $this->user->save();
        }
    }
}
