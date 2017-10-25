<?php

namespace App\Http\Controllers;

class ConfirmRegistrationController extends Controller
{
    public function show()
    {
        return view('join.next');
    }
}
