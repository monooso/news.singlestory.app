<?php

namespace App\Listeners;

use App\Events\LoginTokenRequested;
use App\Mail\UserLoginToken;
use App\Models\Token;
use Illuminate\Support\Facades\Mail;

class EmailLoginToken
{
    public function handle(LoginTokenRequested $event)
    {
        // Generate the login token.
        $token = Token::createForUser($event->user);

        Mail::to($event->user->email)->queue(new UserLoginToken($event->user));
    }
}
