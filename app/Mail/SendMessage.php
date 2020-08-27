<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Lead;
use App\Models\Apartment;
use Helper;

class SendMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user eloquent model.
     *
     * @var Lead
     */
    public $lead;

    /**
     * The followup email eloquent model.
     *
     * @var Apartment
     */
    public $apartment;


    /**
     * Create a new message instance.
     * 
     * @param User $user the user model
     * @param FollowupEmail $followupEmail the followup_email model
     *
     * @return void
     */
    public function __construct(Lead $lead, Apartment $apartment)
    {
        $this->apartment = $apartment;
        $this->lead = $lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->apartment->user->email)
        ->subject('123NoFee | A new message from your listing')
        ->view('emails.contact.send_message');
    }
}
