<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->get('admin_authenticated')) {
            // Redirect to survey with login modal, matching the behavior of the Admin button
            return redirect('/survey')->with('show_login_modal', true);
        }

        return $next($request);
    }
}
