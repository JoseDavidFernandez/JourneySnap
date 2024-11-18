<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagen_post',
        'pais',
        'ciudad',
        'descripcion_post',
        'fecha_publicacion',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ubicaciones()
    {
        return $this->hasOne(UbicacionesPost::class, 'post_id');
    }

    public function itinerario()
    {
        return $this->hasOne(Itinerario::class);  
    }


}
