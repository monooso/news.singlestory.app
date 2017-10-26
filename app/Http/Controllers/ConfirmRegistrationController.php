<?php

namespace App\Http\Controllers;

class ConfirmRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show()
    {
        return view('join.next');
    }
}
