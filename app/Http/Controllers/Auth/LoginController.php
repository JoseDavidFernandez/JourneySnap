<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador maneja la autenticación de usuarios para la aplicación
    | y redirige a los usuarios a la pantalla de inicio. El controlador usa un trait
    | para proporcionar convenientemente su funcionalidad a las aplicaciones.
    |
    */

    use AuthenticatesUsers;

    /**
     * Donde redirigir a los usuarios después del login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Redirección por defecto

    /**
     * Crear una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        // Eliminar la línea con el error ya que el middleware ya está gestionado por el trait
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Sobrescribir el método redirectTo para redirigir a admin si es admin
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Verificar si el usuario autenticado es administrador
        if (auth()->check() && auth()->user()->is_admin) {
            return '/admin';  // Redirigir a la página de administración
        }

        return $this->redirectTo;  // Redirigir al home por defecto
    }
}
