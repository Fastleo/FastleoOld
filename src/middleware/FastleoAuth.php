<?php

namespace Camanru\Fastleo;

use Closure;
use Illuminate\Support\Facades\Auth as BaseAuth;

class FastleoAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!BaseAuth::guard($guard)->check()) {
            return redirect('/fastleo/login');
        }
        return $next($request);
    }
}