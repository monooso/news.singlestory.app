<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $this->subject(trans('email.registration.subject'));

        $this->markdown('emails.tokens.registration')
            ->with('url', route('login.validate-token', $this->user->password));

        return $this;
    }
}
