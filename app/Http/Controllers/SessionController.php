<?php

namespace App\Http\Controllers;

use App\Models\Token;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->only(['show', 'store']);
        $this->middleware('auth')->only('destroy');
    }

    public function show()
    {
        return view('login.next');
    }

    public function store(Token $token)
    {
        auth()->login($token->user);

        $token->redeem();

        return redirect()->route('account');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
