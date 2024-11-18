<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itinerarios_dias_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerario_dia_id')->constrained('itinerarios_dias')->onDelete('cascade'); // Relación con ItinerarioDia
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itinerarios_dias_imagenes');
    }
};
