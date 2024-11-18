<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itinerarios_dias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerario_id')->constrained()->onDelete('cascade');
            $table->integer('numero_dia');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itinerarios_dias');
    }
};
