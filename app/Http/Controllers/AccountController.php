<?php

namespace App\Http\Controllers;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('account.show');
    }

    public function store()
    {
    }
}
