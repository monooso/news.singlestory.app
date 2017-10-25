<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\LoginTokenRequested' => [
            'App\Listeners\EmailLoginToken',
        ],

        'App\Events\UserRegistered' => [
            'App\Listeners\ConfirmUserRegistration',
        ],
    ];
}
