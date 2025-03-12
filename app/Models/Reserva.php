<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Prompts\Concerns\Fallback;

class Reserva extends Model
{
    use HasFactory;


    //define los campos que se pueden asignar de forma masiva

    protected $fillable = [
        'usuario_id',
        'espacio_id',
        'espacio',
        'otro_espacio',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'nombre_actividad',
        'num_personas',
        'programa_evento',
    ];

    public function user()
    {
        return $this -> belongsTo(User::class,'usuario_id');

    }

    public $timestamps = false;
}
