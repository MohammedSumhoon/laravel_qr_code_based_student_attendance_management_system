<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveSheetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $reason;

    public function __construct($data)
    {
        $this->name=$data->name;
        $this->reason=$data->reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name=$this->name;
        $reason=$this->reason;
        return $this->subject('Leave Permission')->markdown('leave_sheet_mail',compact('name','reason'));
    }
}
