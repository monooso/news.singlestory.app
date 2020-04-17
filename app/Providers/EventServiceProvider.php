<?php

namespace App\Providers;

use App\Events\LoginTokenRequested;
use App\Events\UserRegistered;
use App\Listeners\ConfirmUserRegistration;
use App\Listeners\EmailLoginToken;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LoginTokenRequested::class => [EmailLoginToken::class],
        UserRegistered::class      => [ConfirmUserRegistration::class],
    ];
}
