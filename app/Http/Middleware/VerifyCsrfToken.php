<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // Aquí puedes agregar rutas que deseas excluir de la verificación CSRF si es necesario
    ];
}
