<?php

namespace App\Http\Controllers;

use App\Models\Itinerario;
use App\Models\ItinerarioDia;
use App\Models\ItinerarioDiaImagen;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItinerarioController extends Controller
{
    public function index()
    {
        $itinerarios = Itinerario::with('dias')->get();
        return view('itinerarios.index', compact('itinerarios'));
    }

    public function show($id)
    {
        $itinerario = Itinerario::with('dias.imagenes')->findOrFail($id);
        return view('itinerarios.show', compact('itinerario'));
    }


    
    public function create($postId)
    {
        $post = Post::find($postId);
        return view('itinerarios.create', compact('post'));
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dias' => 'required|array',
        ]);
    
        // Crear el itinerario
        $itinerario = new Itinerario();
        $itinerario->nombre = $request->nombre;
        $itinerario->descripcion = $request->descripcion;
        $itinerario->post_id = $postId;
        $itinerario->user_id = Auth::id();
        $itinerario->save();

        // Obtener nombre de la ciudad para la carpeta
        $itinerarioCiudad = str_replace(' ', '_', strtolower($itinerario->nombre)); // Formato para la carpeta (sin espacios)

        // Agregar días al itinerario
        foreach ($request->dias as $index => $dia) {
            // Guardar primero el día
            $itinerarioDia = new ItinerarioDia();
            $itinerarioDia->itinerario_id = $itinerario->id;
            $itinerarioDia->numero_dia = $index + 1;
            $itinerarioDia->descripcion = $dia['descripcion'];
            $itinerarioDia->save(); // Guardamos el día primero

            // Ahora que el día tiene un ID, guardamos las imágenes asociadas
            if (!empty($dia['imagenes'])) {
                foreach ($dia['imagenes'] as $imagen) {
                    $rutaDirectorio = 'ImagenesItinerario/' . Auth::id() . '/' . $itinerarioCiudad;
                    
                    Storage::makeDirectory($rutaDirectorio);
                    
                    // Almacenar la imagen en la ruta
                    $nombreOriginal = $imagen->getClientOriginalName();
                    $path = $imagen->storeAs($rutaDirectorio, $nombreOriginal, 'public');
                    
                    // Guardar la imagen en la base de datos
                    $itinerarioDiaImagen = new ItinerarioDiaImagen();
                    $itinerarioDiaImagen->itinerario_dia_id = $itinerarioDia->id;
                    $itinerarioDiaImagen->path = $path;
                    $itinerarioDiaImagen->save();
                }
            }
        }
    
        return redirect()->route('posts.index')->with('success', 'Itinerario creado y asociado al post.');
    }
}
