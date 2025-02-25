<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ===============================
    // 🔹 PROPIEDADES DEL MODELO
    // ===============================

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ===============================
    // 🔹 MÉTODOS DE MUTACIÓN
    // ===============================

    public function setPasswordAttribute($value)
    {

        if (!Str::startsWith($value, '$2y$')) { 
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }

        
    }

    public function setRolAttribute($value)
    {
        // Si no hay usuarios en la base de datos, el primer usuario será administrador
        if (User::count() === 0) {
            $this->attributes['rol'] = 'administrador';
            return;
        }

        // Si el usuario autenticado no es administrador, no puede asignar roles
        if (Auth::check() && Auth::user()->rol === 'administrador') {
           $this -> attributes['rol'] = $value;
        } else{
            
            $this->attributes['rol'] = 'profesor';
        }
    }

    // ===============================
    // 🔹 EVENTOS DEL MODELO (BOOT)
    // ===============================

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Evitar que haya más de un administrador si ya existe uno
            if ($user->rol === 'administrador' && User::where('rol', 'administrador')->exists()) {
                throw new \Exception("Ya existe un administrador registrado.");
            }
        });
    }
}
