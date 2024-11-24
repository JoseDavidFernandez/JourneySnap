<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Método para mostrar todos los usuarios
    public function index()
    {
        $users = User::all();  // Obtener todos los usuarios
        return view('admin.index', compact('users'));
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);  // Buscar el usuario por su ID
        $user->delete();  // Eliminar el usuario
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente');
    }
}
