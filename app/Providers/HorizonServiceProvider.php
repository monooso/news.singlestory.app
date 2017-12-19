<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class HorizonServiceProvider extends ServiceProvider
{
    public function register()
    {
        Horizon::auth(function ($request) {
            $user = $request->user();

            $admins = config('horizon.admins', []);

            return $user && in_array($user->email, $admins);
        });
    }
}
