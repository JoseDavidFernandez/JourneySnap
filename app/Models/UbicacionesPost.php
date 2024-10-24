<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionesPost extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'ubicaciones_post';

    protected $fillable = [
        'pais',
        'ciudad',
        'latitud',
        'longitud',
        'user_id',
        'post_id',
    ];

    // Relación con el modelo Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

