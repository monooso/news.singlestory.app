<?php

namespace App\Http\Controllers;

use App\Constants\EmailSchedule;
use App\Constants\NewsSource;
use Illuminate\Validation\Rule;

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
            'sources' => $this->sources(),
            'user'    => auth()->user(),
        ]);
    }

    /**
     * Return an associative array of news sources, for use in the account
     * preferences form.
     *
     * @return array
     */
    private function sources(): array
    {
        $keys = NewsSource::all();

        $values = collect($keys)->map(function (string $key) {
            return trans('sources.' . $key);
        });

        return collect($keys)->combine($values)->all();
    }

    public function store()
    {
        $input = request()->validate([
            'news_source' => ['required', Rule::in(NewsSource::all())],
            'schedule'    => ['required', Rule::in(EmailSchedule::all())],
        ]);

        auth()->user()->update([
            'news_source' => $input['news_source'],
            'schedule'    => $input['schedule'],
        ]);

        return redirect()
            ->route('account')
            ->with('status', trans('account.updated'));
    }
}
