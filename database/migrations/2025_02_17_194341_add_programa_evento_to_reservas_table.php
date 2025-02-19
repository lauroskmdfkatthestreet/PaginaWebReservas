<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('reservas', function (Blueprint $table) {
        $table->text('programa_evento')->nullable(); // Añadir el campo programa_evento
    });
}

public function down()
{
    Schema::table('reservas', function (Blueprint $table) {
        $table->dropColumn('programa_evento');
    });
}
};
