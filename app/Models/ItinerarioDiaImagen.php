<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDiaImagen extends Model
{
    use HasFactory;

    // En el modelo ItinerarioDiaImagen.php
    protected $table = 'itinerarios_dias_imagenes';
    
    protected $fillable = ['itinerario_dia_id', 'path']; // Campos rellenables

    public function dia()
    {
        return $this->belongsTo(ItinerarioDia::class); // Relación con ItinerarioDia
    }
}
