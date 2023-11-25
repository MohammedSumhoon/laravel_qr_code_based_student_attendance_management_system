<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentLoginCredentials;

class LoginCreditentials implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $name,$username,$password;

    public function __construct($name,$username,$password)
    {
        $this->name=$name;
        $this->username=$username;
        $this->password=$password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name=$this->name;
        $username=$this->username;
        $password=$this->password;
        Mail::to('mohammedsumhoon786@gmail.com')->send(new StudentLoginCredentials($name,$username,$password));
    }
}
