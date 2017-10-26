<?php

namespace App\Http\Controllers;

use App\Events\LoginTokenRequested;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show()
    {
        return view('login.show');
    }

    public function store()
    {
        $input = request()->validate(['email' => 'required|email|exists:users']);

        $user = User::whereEmail($input['email'])->first();

        event(new LoginTokenRequested($user));

        return redirect()->route('login.next');
    }
}
