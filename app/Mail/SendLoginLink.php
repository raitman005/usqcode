<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Helper;

class SendLoginLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user eloquent model.
     *
     * @var User
     */
    public $user;

    /**
     * The access URL.
     *
     * @var string
     */
    public $accessUrl;

    /**
     * The set password url.
     *
     * @var string
     */
    public $setPassUrl;

    /**
     * Create a new message instance.
     * 
     * @param User $user the user model
     * @param FollowupEmail $followupEmail the followup_email model
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->accessUrl = route('login.access_token', ['uid' => encrypt($this->user->id),  'access_token' => $this->user->access_token]);
        $this->setPassUrl = route('login.access_token', ['uid' => encrypt($this->user->id),  'access_token' => $this->user->access_token, 'set_pw' => '1']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
        ->subject('Sign in to 123NoFee')
        ->view('emails.auth.login_message');
    }
}
