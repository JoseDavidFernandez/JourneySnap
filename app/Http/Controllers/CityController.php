<?php

namespace App\Http\Controllers;

use App\Services\OpenCageService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $openCageService;

    // Inyección del servicio a través del constructor
    public function __construct(OpenCageService $openCageService)
    {
        $this->openCageService = $openCageService;
    }

    // Método para obtener coordenadas
    public function getCoordinates(Request $request)
    {
        $city = $request->input('city'); // Obtener el nombre de la ciudad del request
        $coordinates = $this->openCageService->getCoordinates($city); // Llamar al método del servicio

        if ($coordinates) {
            return response()->json($coordinates); // Devolver coordenadas en formato JSON
        }

        return response()->json(['error' => 'No se encontraron coordenadas'], 404); // Manejo de error
    }
}
