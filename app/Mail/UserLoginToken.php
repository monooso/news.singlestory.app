<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $this->subject(trans('email.login.subject'));

        $this->markdown('emails.tokens.login')
            ->with('url', route('login.validate-token', $this->user->password));

        return $this;
    }
}
