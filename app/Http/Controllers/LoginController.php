<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Muestra la vista del login.
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Procesa el login del usuario.
     */
    public function login(LoginRequest $request)
    {
        // Obtiene las credenciales; puedes usar getCredentials() si ya lo tienes definido en tu LoginRequest,
        // o directamente obtener 'email' y 'password' con:
        // $credentials = $request->only('email', 'password');
        $credentials = $request->getCredentials();

        
        // Intenta autenticar al usuario con Auth::attempt().
        // Este método devolverá true si las credenciales son válidas.
        if (Auth::attempt($credentials)) {
            // Regenera la sesión para prevenir ataques de fijación de sesión.
            $request->session()->regenerate();

            // Redirige al usuario a la URL deseada, por ejemplo '/home'.
            return redirect()->route('index');
        }

        // Si la autenticación falla, regresa al formulario de login con un error.
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    /**
     * Método adicional para redirigir tras autenticación exitosa.
     * (Este método ya no es estrictamente necesario si usas redirect()->intended() en el login.)
     */
    public function authenticated(Request $request, $user)
    {
        return redirect('/');
    }
}
