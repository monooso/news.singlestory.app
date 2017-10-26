<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    /**
     * If a logged-in user attempts to access a "guest" page, redirect him to
     * his dashboard.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        return auth()->guard($guard)->check()
            ? redirect()->route('account')
            : $next($request);
    }
}
