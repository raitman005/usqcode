<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;
use App\Models\FollowupEmail;

class AgentAcceptsALead
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var $user - The user model
     */
    public $user;

    /**
     * @var $followupEmail - The followup_email eloquent model
     */
    public $followupEmail;


    /**
     * Create a new event instance.
     *
     * @param User $user the user model
     * @param FollowupEmail $followupEmail the followup_email model
     * 
     * @return void
     */
    public function __construct(User $user, FollowupEmail $followupEmail)
    {
        $this->user = $user;
        $this->followupEmail = $followupEmail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
