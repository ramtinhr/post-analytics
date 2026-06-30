<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    public function __construct(
        public User $user
    ) {}


    public function build()
    {
        return $this
            ->subject('خوش آمدید به سیستم مدیریت محتوا')
            ->view('emails.welcome');
    }
}
