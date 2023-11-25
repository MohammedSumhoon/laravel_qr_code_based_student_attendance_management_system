<?php

namespace App\Listener;

use App\Events\LeaveSheet;
use App\Mail\LeaveSheetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLeavePermission
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
     * @param  \App\Events\LeaveSheet  $event
     * @return void
     */
    public function handle(LeaveSheet $event)
    {
        Mail::to('mohammedsumhoon24@gmail.com')->send(new LeaveSheetMail($event));
    }
}
