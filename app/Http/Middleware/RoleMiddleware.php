<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Importa esta clase
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Maneja la solicitud entrante.
     */
    public function handle(Request $request, Closure $next, $role) 
    {
        if (!Auth::check() || Auth::user()->rol !== $role) {

            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        return $next($request);
    }
}

