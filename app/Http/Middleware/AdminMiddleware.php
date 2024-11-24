<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario es un administrador
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Si no es administrador, redirigir o abortar
        return redirect('/home');
    }
}
