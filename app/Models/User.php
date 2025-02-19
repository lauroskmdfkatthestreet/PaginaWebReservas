<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'token_confirmacion',
        'token_recuperacion',
        'expiracion_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token_confirmacion',
        'token_recuperacion',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'expiracion_token' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setRolAttribute($value)
    {
        if (!in_array($value, ['administrador', 'profesor'])) {
            throw new \Exception("Valor de rol no permitido.");
        }

        // Verificar si hay un usuario autenticado antes de acceder a Auth::user()
        if (!Auth::check()) {
            throw new \Exception("No se puede asignar un rol sin un usuario autenticado.");
        }

        $currentUser = Auth::user();

        if ($currentUser->rol !== 'administrador') {
            Log::warning('Intento de cambiar el rol sin permisos de administrador.', [
                'usuario_modificador' => $currentUser->id,
                'usuario_objetivo'    => $this->id ?? 'Nuevo usuario',
                'valor_intentado'     => $value,
            ]);

            throw new \Exception("Solo un administrador puede cambiar el rol.");
        }

        Log::info('Cambio de rol ejecutado.', [
            'usuario_objetivo' => $this->id ?? 'Nuevo usuario',
            'rol_anterior'     => $this->attributes['rol'] ?? null,
            'rol_nuevo'        => $value,
        ]);

        $this->attributes['rol'] = $value;
    }
}
