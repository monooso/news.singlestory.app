<?php

namespace App\Http\Controllers;

class InvalidTokenController extends Controller
{
    public function show()
    {
        return view('login.invalid-token');
    }
}
