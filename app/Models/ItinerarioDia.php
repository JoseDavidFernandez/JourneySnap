<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDia extends Model
{
    use HasFactory;

    protected $table = 'itinerarios_dias';

    protected $fillable = ['itinerario_id', 'numero_dia', 'descripcion'];

    public function itinerario()
    {
        return $this->belongsTo(Itinerario::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ItinerarioDiaImagen::class); // Un día puede tener varias imágenes
    }

}
