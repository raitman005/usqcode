<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Lead;
use App\Models\Apartment;
use Helper;

class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The followup email eloquent model.
     *
     * @var array
     */
    public $params;


    /**
     * Create a new message instance.
     * 
     * @param User $user the user model
     * @param FollowupEmail $followupEmail the followup_email model
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(env('MAIL_USERNAME'))
        ->subject('123NoFee | A new message')
        ->view('emails.contact.send_contact');
    }
}
