<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function store()
    {
        $input = request()->validate(['email' => 'required|email']);

        if (User::whereEmail($input['email'])->count() > 0) {
            return redirect()->route('login.next');
        }

        $user = User::create(['email' => $input['email']]);

        event(new UserRegistered($user));

        return redirect()->route('join.next');
    }
}
