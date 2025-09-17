<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
