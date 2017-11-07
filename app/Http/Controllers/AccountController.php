<?php

namespace App\Http\Controllers;

use App\Constants\EmailSchedule;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('account.show', ['user' => auth()->user()]);
    }

    public function store()
    {
        $input = request()->validate([
            'schedule' => ['required', Rule::in(EmailSchedule::all())],
        ]);

        auth()->user()->update(['schedule' => $input['schedule']]);

        return redirect()
            ->route('account')
            ->with('status', trans('account.updated'));
    }
}
