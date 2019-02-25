<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\LoginTokenRequested::class => [
            \App\Listeners\EmailLoginToken::class,
        ],

        \App\Events\UserRegistered::class => [
            \App\Listeners\ConfirmUserRegistration::class,
        ],
    ];
}
