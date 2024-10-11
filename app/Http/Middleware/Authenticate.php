<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Auth;

class Authenticate extends Middleware
{


    // public function handle(Request $request, Closure $next)
    // {   
    // $nombre_usuario= Auth::user() ? Auth::user()->nombre.' '.Auth::user()->apellidos.' - '.Auth::user()->id : 'No autenticado';

    // Log::info("Entro en Middleware auth handle (1) datos de usuario :: {$nombre_usuario} :: path ". request()->path());
    // Log::debug("Entro en Middleware auth handle (2): path" . request()->path());

    //     if (!Auth::check()) {
    //        return Redirect::to('login'); 
    //     }
    //     return $next($request);

    // }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */


    protected function redirectTo($request)
    {
        Log::error("Middleware redirectTo " . (auth()->user() ? auth()->user()->id : 'No autenticado') . " | path: " . request()->path());

        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
