<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        $user = User::create([
            
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password),
            'token_confirmacion' => Str::random(40),
        ]);
        
        return redirect()->route('login.show')->with('success', 'Usuario registrado con éxito');

    }   
}
