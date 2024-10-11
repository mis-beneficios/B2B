<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class IndexRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_ADMIN') == true) {
            if (Auth::check()) {
                return redirect()->route('dashboard');
            } else {
                return view('layouts.admin.login');
            }
        }
        return $next($request);
    }
}
