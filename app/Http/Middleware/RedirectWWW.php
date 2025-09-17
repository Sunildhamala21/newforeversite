<?php

namespace App\Http\Middleware;

use Closure;

class RedirectWWW
{
    public function handle($request, Closure $next)
    {
        if (substr($request->getHost(), 0, 4) !== 'www.') {
            $request->headers->set('host', 'www.'.$request->getHost());

            return redirect($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
