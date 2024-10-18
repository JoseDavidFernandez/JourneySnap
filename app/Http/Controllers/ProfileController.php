<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los posts del usuario autenticado
        $posts = Post::where('user_id', $user->id)->get();

        // Retornar la vista con los datos del usuario y sus posts
        return view('profile.index', compact('user', 'posts'));
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
            // Eliminar la imagen existente si existe
            if ($user->imagen_perfil) {
                Storage::disk('public')->delete($user->imagen_perfil);
                $user->imagen_perfil = null; // Asegúrate de que se elimine la ruta de la imagen en la base de datos
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
        $user->fecha_nacimiento = $request->fecha_nacimiento; // Asegúrate de que el nombre del campo coincida
        $user->descripcion = $request->descripcion; // Asegúrate de que el nombre del campo coincida

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado correctamente.');
    }

}
