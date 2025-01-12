<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class Delivery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) //Función para autenticar al servicio a domicilio
    {
        if(auth()->user()->role != 'delivery' && auth()->user()->role != 'admin' && auth()->user()->role != 'servicio' && auth()->user()->role != 'vendedor'){
            throw new AuthorizationException();
        }
        return $next($request);
    }
}
