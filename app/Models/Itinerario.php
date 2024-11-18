<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function dias()
    {
        return $this->hasMany(ItinerarioDia::class);
    }
}
