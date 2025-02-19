<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  El rol necesario para acceder a la ruta
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            // Si no está autenticado, redirige al login
            return redirect()->route('login'); // Cambia la ruta si es necesario
        }

        // Verifica si el usuario tiene el rol adecuado
        if (auth()->user()->rol !== $role) {
            // Si no tiene el rol adecuado, redirige a la página principal o a una ruta específica
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // Si el rol coincide, permite que la solicitud continúe
        return $next($request);
    }
}

