<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure|\Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admins')
    {

       // dd(Auth::guard($guard)->check());

        if (!Auth::guard($guard)->check()) {
            return redirect('/admin/login ');
        }

        return $next($request);
    }

}