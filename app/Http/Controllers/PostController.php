<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UbicacionesPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function show($id)
    {
        $post = Post::with('itinerario')->findOrFail($id); 
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validar la solicitud manualmente con mensajes personalizados
        $validator = Validator::make($request->all(), [
            'imagen_post' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'pais' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'descripcion_post' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ], [
            'imagen_post.required' => 'Por favor, sube una imagen.',
            'imagen_post.mimes' => 'El archivo debe ser una imagen de tipo jpeg, png, jpg, gif o svg.',
            'imagen_post.max' => 'El tamaño de la imagen no debe exceder los 5 MB.',
            'pais.required' => 'El campo país es obligatorio.',
            'ciudad.required' => 'El campo ciudad es obligatorio.',
            'descripcion_post.required' => 'El campo descripción es obligatorio.',
            'latitud.required' => 'El campo latitud es obligatorio.',
            'longitud.required' => 'El campo longitud es obligatorio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

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

        $nuevoPost->pais = $request->pais;
        $nuevoPost->ciudad = $request->ciudad;
        $nuevoPost->descripcion_post = $request->descripcion_post;
        $nuevoPost->fecha_publicacion = now(); 
        $nuevoPost->user_id = $user->id;
        $nuevoPost->save();

        $ubicacionPost = new UbicacionesPost();
        $ubicacionPost->pais = $request->pais;
        $ubicacionPost->ciudad = $request->ciudad;
        $ubicacionPost->latitud = $request->latitud;
        $ubicacionPost->longitud = $request->longitud;
        $ubicacionPost->user_id = $user->id;
        $ubicacionPost->post_id = $nuevoPost->id;
        $ubicacionPost->save();

        // Verificar si se seleccionó la opción de crear un itinerario
        if ($request->has('add_itinerary') && $request->input('add_itinerary') == 1) {
            return redirect()->route('itinerarios.create', ['postId' => $nuevoPost->id]); 
        }


        return redirect()->route('profile.index')->with('success', 'Post creado correctamente');

    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Verificar que el usuario sea el propietario del post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Verificar que el usuario sea el propietario del post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar este post.');
        }

        // Validar solo la descripción
        $request->validate([
            'descripcion_post' => 'required|string|max:255',
        ]);

        $post->descripcion_post = $request->descripcion_post;
        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post actualizado correctamente.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este post.');
        }

        $post->delete();

        return redirect()->route('profile.index')->with('success', 'Post eliminado correctamente');
    }




}
