<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateVendor
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (request()->user()->role == 2) {
            return $next($request);
        } else {
            return redirect('login');
        }
    }
}
