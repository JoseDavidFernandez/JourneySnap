<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionesPostTable extends Migration
{
    public function up()
    {
        Schema::create('ubicaciones_post', function (Blueprint $table) {
            $table->id();
            $table->string('pais');
            $table->string('ciudad');
            $table->decimal('latitud', 10, 8); // 10 dígitos, 8 después del punto decimal
            $table->decimal('longitud', 11, 8); // 11 dígitos, 8 después del punto decimal
            $table->unsignedBigInteger('user_id'); // ID del usuario
            $table->unsignedBigInteger('post_id'); // ID del post
            $table->timestamps();

            // Claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ubicaciones_post');
    }
}
