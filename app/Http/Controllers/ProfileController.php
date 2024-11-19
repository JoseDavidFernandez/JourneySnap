<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Itinerario;
use App\Models\ItinerarioDia;
use App\Models\ItinerarioDiaImagen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        //Obtener todos los post del usuario y sus itinerarios relacionados
        $posts = $user->posts()->with('itinerario')->get();
        // Contar la cantidad de itinerarios relacionados con los posts
        $itinerariosCount = $posts->filter(function($post) {
            return $post->itinerario != null;  // Filtrar solo los posts que tienen itinerario
        })->count();

        $itinerarios = Itinerario::with('dias')->get();


        // Obtener los posts del usuario autenticado
        $posts = Post::where('user_id', $user->id)->get();

        // Retornar la vista con los datos del usuario y sus posts
        return view('profile.index', compact('user', 'posts', 'itinerarios',  'itinerariosCount'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'fecha_nacimiento' => ['nullable', 'date'],
            'imagen_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'descripcion' => ['nullable', 'string', 'max:260'],
        ]);

        // Eliminar la imagen de perfil si se solicita
        if ($request->remove_image) {
            if ($user->imagen_perfil) {
                Storage::disk('public')->delete($user->imagen_perfil);
                $user->imagen_perfil = null;
            }
        }

        // Actualizar la imagen de perfil si se proporciona una nueva
        if ($request->hasFile('imagen_perfil')) {
            $file = $request->file('imagen_perfil');
            $userId = $user->id;

            // Eliminar la imagen existente si existe
            if ($user->imagen_perfil) {
                Storage::disk('public')->delete($user->imagen_perfil);
            }

            // Crear la nueva ruta de almacenamiento
            $path = $file->storeAs('ImagenPerfil/' . $userId, $file->getClientOriginalName(), 'public');

            // Verifica si la imagen se ha subido correctamente
            if (!$path) {
                return back()->with('error', 'Error al subir la imagen.');
            }

            $user->imagen_perfil = $path;
        }

        // Actualizar el resto de los campos
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->descripcion = $request->descripcion;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado correctamente.');
    }

}
