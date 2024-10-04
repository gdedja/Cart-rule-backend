<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (request()->user()->role == 1) {
            return $next($request);
        } 
        elseif (request()->user()->role == 2) {
            return redirect('/vendor-order-page/'.request()->user()->provider_id);
        }
        else {
            return redirect('login');
        }
    }
}
