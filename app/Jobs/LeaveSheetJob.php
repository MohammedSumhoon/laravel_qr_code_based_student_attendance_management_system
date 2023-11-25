<?php

namespace App\Jobs;

use App\Mail\LeaveSheetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class LeaveSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $name,$reason;

    public function __construct($name,$reason)
    {
        $this->name=$name;
        $this->reason=$reason;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name=$this->name;
        $reason=$this->reason;
        Mail::to('mohammedsumhoon24@gmail.com')->send(new LeaveSheetMail($name,$reason));
    }
}
