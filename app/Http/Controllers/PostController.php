<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UbicacionesPost; // Importar el modelo UbicacionesPost
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Agregar Log

class PostController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener todos los posts del usuario autenticado
        $posts = Post::where('user_id', $user->id)->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validar la solicitud manualmente con mensajes personalizados
        $validator = Validator::make($request->all(), [
            'imagen_post' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:5120', // Ajustar el tamaño máximo a 5 MB (5120 KB)
            'pais' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'descripcion_post' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'latitud' => 'required|numeric', // Validación para latitud
            'longitud' => 'required|numeric', // Validación para longitud
        ], [
            'imagen_post.required' => 'Por favor, sube una imagen.',
            'imagen_post.mimes' => 'El archivo debe ser una imagen de tipo jpeg, png, jpg, gif o svg.',
            'imagen_post.max' => 'El tamaño de la imagen no debe exceder los 5 MB.',
            'pais.required' => 'El campo país es obligatorio.',
            'ciudad.required' => 'El campo ciudad es obligatorio.',
            'descripcion_post.required' => 'El campo descripción es obligatorio.',
            'fecha_publicacion.required' => 'El campo fecha de publicación es obligatorio.',
            'latitud.required' => 'El campo latitud es obligatorio.',
            'longitud.required' => 'El campo longitud es obligatorio.',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Crear un nuevo post
        $nuevoPost = new Post();

        // Manejar la subida de la imagen
        if ($request->hasFile('imagen_post')) {
            $archivo = $request->file('imagen_post');
            $nombreOriginal = $archivo->getClientOriginalName();
            $rutaDirectorio = 'ImagenesPost/' . $user->id . '_' . $user->username;
            $rutaArchivo = $archivo->storeAs($rutaDirectorio, $nombreOriginal, 'public');
            $nuevoPost->imagen_post = $rutaArchivo;
        }

        // Asignar los demás campos del post
        $nuevoPost->pais = $request->pais;
        $nuevoPost->ciudad = $request->ciudad;
        $nuevoPost->descripcion_post = $request->descripcion_post;
        $nuevoPost->fecha_publicacion = $request->fecha_publicacion;

        // Asignar el id del usuario al post
        $nuevoPost->user_id = $user->id;

        // Guardar el post
        $nuevoPost->save();

        // Crear la entrada en la tabla UbicacionesPost
        $ubicacionPost = new UbicacionesPost();
        $ubicacionPost->pais = $request->pais;
        $ubicacionPost->ciudad = $request->ciudad;
        $ubicacionPost->latitud = $request->latitud;  // Asignar latitud
        $ubicacionPost->longitud = $request->longitud;  // Asignar longitud
        $ubicacionPost->user_id = $user->id; // Asignar el id del usuario
        $ubicacionPost->post_id = $nuevoPost->id; // Asignar el id del post
        $ubicacionPost->save(); // Guardar la ubicación

        return redirect()->back()->with('success', 'Post creado correctamente');
    }
}
