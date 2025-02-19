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
        // Tabla de usuarios con campos adicionales
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Nuevo campo para diferenciar roles: 'administrador' o 'profesor'
            $table->enum('rol', ['administrador', 'profesor'])->default('profesor');
            // Token para confirmar email (opcional, se usa en el flujo de verificación)
            $table->string('token_confirmacion')->nullable();
            // Token y expiración para la recuperación de contraseña
            $table->string('token_recuperacion')->nullable();
            $table->timestamp('expiracion_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla para los tokens de reseteo de contraseña (Laravel usa una migración similar por defecto)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabla de sesiones (por defecto en Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
