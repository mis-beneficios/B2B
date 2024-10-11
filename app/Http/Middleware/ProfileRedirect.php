<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ProfileRedirect
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
        switch (Auth::user()->role) {
            case 'client':
                return redirect()->route('inicio');
                break;
                break;
            case 'sales':
            case 'supervisor':
                return redirect()->route('dashboard_ventas');
                break;

            case 'collector':
                // abort(403, $message = 'En construccion');
                return redirect()->route('dashboard_cobranza');
                break;

            case 'quality':
            case 'control':
                return redirect()->route('dashboard_control');
                break;

            case 'conveniant':
                return redirect()->route('dashboard_convenios');
                break;

            case 'reserver':
                return redirect()->route('dashboard_reservaciones');
                break;

            case 'recepcionist':
                // return redirect()->route('dashboard_cobranza');
                abort(403, $message = 'En construccion');
                break;
            default:
                return $next($request);
                break;
        }

        return redirect()->route('login');

    }
}
