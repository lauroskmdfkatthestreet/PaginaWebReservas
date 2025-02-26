<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            // Verificar si hay algún administrador en la base de datos
            $existeAdmin = User::where('rol', 'administrador')->exists();

            // Determinar el rol asignado
            if (!$existeAdmin) {
                $rolAsignado = 'administrador'; // El primer usuario será administrador
            } elseif (Auth::check() && Auth::user()->rol === 'administrador') {
                $rolAsignado = $request->rol ?? 'profesor'; // Admin puede asignar roles
            } else {
                $rolAsignado = 'profesor'; // Por defecto, asignar "profesor"
            }

            // Crear el usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'token_confirmacion' => Str::random(40),
                'rol' => $rolAsignado,
            ]);

            // Autenticar usuario
            Auth::login($user);

            return redirect()->route('index')->with('success', '¡Registro exitoso! Bienvenido, ' . $user->name);
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error en el registro: ' . $e->getMessage());
        }
    }
}
