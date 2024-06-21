<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Comentamos esta línea para que los usuarios no necesiten estar autenticados para acceder a la página de inicio
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los posts del usuario autenticado
        $posts = $user ? Post::where('user_id', $user->id)->get() : collect();

        return view('home', compact('posts'));
    }
}
