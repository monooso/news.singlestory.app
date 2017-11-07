<?php

namespace App\Http\Controllers;

use App\Events\LoginTokenRequested;
use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function store()
    {
        $input = request()->validate(['email' => 'required|email']);

        try {
            // If the user already exists, treat this as a login request.
            $user = User::whereEmail($input['email'])->firstOrFail();
            event(new LoginTokenRequested($user));
            return redirect()->route('login.next');

        } catch (ModelNotFoundException $e) {

            $user = User::create($input);
            event(new UserRegistered($user));
            return redirect()->route('join.next');
        }
    }
}
