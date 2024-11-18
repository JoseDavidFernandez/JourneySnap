<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDiaImagen extends Model
{
    use HasFactory;

    protected $table = 'itinerarios_dias_imagenes';
    
    protected $fillable = ['itinerario_dia_id', 'path'];

    public function dia()
    {
        return $this->belongsTo(ItinerarioDia::class); // Relación con ItinerarioDia
    }
}
