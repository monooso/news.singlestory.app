<?php

namespace App\Http\Controllers;

use App\Constants\NewsSource;
use App\Http\Requests\StoreEmailPreferences;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete()
    {
        return view('account.delete');
    }

    public function destroy()
    {
        auth()->user()->delete();

        return redirect()
            ->route('home')
            ->with('status', trans('account.deleted'));
    }

    public function show()
    {
        return view('account.show', [
            'sources' => $this->getAvailableSources(),
            'user'    => auth()->user(),
        ]);
    }

    protected function getAvailableSources()
    {
        return collect(NewsSource::all())->mapWithKeys(function ($source) {
            return [$source => trans('sources.' . $source)];
        })->all();
    }

    public function store(StoreEmailPreferences $request)
    {
        auth()->user()->update($request->all());

        return redirect()
            ->route('account')
            ->with('status', trans('account.updated'));
    }
}
