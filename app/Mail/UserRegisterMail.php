<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user=null;
    protected $password=null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$password)
    {
        $this->user=$user;
        $this->password=$password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.user.mail')
        ->with('user',$this->user)
        ->with('password',$this->password);
    }
}
