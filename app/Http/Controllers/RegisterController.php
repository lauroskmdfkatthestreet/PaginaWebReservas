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

    protected function create(array $data)
    {
        // Si el usuario no está autenticado, no puede asignar roles y se redirige
        if (!Auth::check()) {
            return redirect('/')->with('error', 'No puedes asignar roles sin estar autenticado.');
        }
    
        // Si el usuario autenticado es administrador, puede asignar roles, de lo contrario, asigna "profesor"
        $rol = (Auth::user()->rol === 'administrador') ? ($data['rol'] ?? 'profesor') : 'profesor';
    
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => $rol, // Solo los administradores pueden modificarlo
        ]);
    }
    





    public function register(RegisterRequest $request)
    {
        $user = User::create([
            
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password),
            'token_confirmacion' => Str::random(40),
            'rol' => $request['rol'], //guardar el rol seleccionado
        ]);
        
        return redirect()->route('login.show')->with('success', 'Usuario registrado con éxito');

    }   
}
