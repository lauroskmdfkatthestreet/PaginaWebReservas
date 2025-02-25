<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    
    public function show()
    {
        return view('auth.register');
    }

    protected function create(array $data)
    {

        $rolAsignado = 'profesor'; //por defecto, el rol sera profesor
    
      // Si el usuario autenticado es administrador, puede asignar el rol manualmente
      if (Auth::check() && Auth::user()->rol === 'administrador') {
        $rolAsignado = $data['rol'] ?? 'profesor';
    }

        // Si el usuario autenticado es administrador, puede asignar roles, de lo contrario, asigna "profesor"
        $rol = (Auth::user()->rol === 'administrador') ? ($data['rol'] ?? 'profesor') : 'profesor';
    
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => $rolAsignado, // Solo los administradores pueden modificarlo
        ]);
    }
    

    public function register(RegisterRequest $request)
    {
        // Verificar si hay algún administrador en la base de datos
        $existeAdmin = User::where('rol', 'administrador')->exists(); 
    
        // Si no hay administradores, el primer usuario será administrador
        if (!$existeAdmin) {
            $rolAsignado = 'administrador';
        } else {
            // Si el usuario autenticado es administrador, puede asignar roles
            if (Auth::check() && Auth::user()->rol === 'administrador') {
                $rolAsignado = $request->rol ?? 'profesor';
            } else {
                // Si no es administrador, se asigna "profesor" por defecto
                $rolAsignado = 'profesor';
            }
        }
    
        // Crear el usuario con el rol determinado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token_confirmacion' => Str::random(40),
            'rol' => $rolAsignado,
        ]);
    
        Auth::login($user);
        return redirect()->route('login.show')->with('success', 'Usuario registrado con éxito');
    }
    

protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'rol' => ['in:profesor'], // SOLO permite "profesor" en el formulario
    ]);
}

}
