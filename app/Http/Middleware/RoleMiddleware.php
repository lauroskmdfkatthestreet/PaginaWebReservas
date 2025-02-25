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
        if (Auth::user()->rol !== 'administrador') {
            return redirect('/')->with('error', 'No tienes permisos para esta acción.');
        }

        return $next($request);
    }




}

