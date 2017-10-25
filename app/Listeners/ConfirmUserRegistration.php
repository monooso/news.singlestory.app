<?php

namespace App\Listeners;

use App\Events\UserRegistered as Event;
use App\Mail\UserRegistrationToken;
use App\Models\Token;
use Illuminate\Support\Facades\Mail;

class ConfirmUserRegistration
{
    public function handle(Event $event)
    {
        Token::createForUser($event->user);

        Mail::to($event->user->email)->queue(new UserRegistrationToken($event->user));
    }
}
