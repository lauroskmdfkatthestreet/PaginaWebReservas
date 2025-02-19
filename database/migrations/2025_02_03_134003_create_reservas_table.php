<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            // Relación con el usuario que hace la reserva
            $table->unsignedBigInteger('user_id');
            // Espacio reservado; si en el futuro deseas relacionarlo con una tabla de espacios, puedes usar una clave foránea
            $table->string('espacio');
            // Fecha de la actividad
            $table->date('fecha');
            // Hora de inicio y final de la actividad
            $table->time('hora_inicio');
            $table->time('hora_fin');
            // Nombre de la actividad
            $table->string('nombre_actividad');
            $table->timestamps();

            // Define la clave foránea con la tabla de usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
