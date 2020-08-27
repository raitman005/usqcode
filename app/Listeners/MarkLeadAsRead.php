<?php

namespace App\Listeners;

use App\Events\LeadDetailsAcquired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use DB;

class MarkLeadAsRead
{
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
     * @param  LeadDetailsAcquired  $event
     * @return void
     */
    public function handle(LeadDetailsAcquired $event)
    {
        $followupQueue = $event->followupQueue;
        DB::table('followup_queues')
        ->where('id', $followupQueue->id)
        ->update(['read_at' => Carbon::now()]);
    }
}
