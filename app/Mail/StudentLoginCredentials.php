<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentLoginCredentials extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $username,$password,$name;

    public function __construct($name,$username,$password)
    {
        $this->name=$name;
        $this->username=$username;
        $this->password=$password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name=$this->name;
        $username=$this->username;
        $password=$this->password;

        return $this->subject('Your StudentWorkRoom login credentials')->markdown('student_login_credit_mail',compact('name','username','password'));
    }
}
