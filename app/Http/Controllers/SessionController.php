<?php

namespace App\Http\Controllers;

use App\Models\Token;

class SessionController extends Controller
{
    public function show()
    {
        return view('login.next');
    }

    public function store(Token $token)
    {
        return redirect()->route('account');
    }
}
