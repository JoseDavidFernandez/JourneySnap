<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Esta línea es opcional y depende de tu configuración de entorno
URL::forceScheme('http');

// Ruta para la página de Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta para la página de inicio de sesión
Route::get('/', function () {
    return view('auth/login');
});

// Rutas para Inicio y Registro de Sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Rutas para ProfileController con middleware de autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/deleteImage', [ProfileController::class, 'deleteImage'])->name('profile.deleteImage');
    
    // Rutas para PostController
    Route::resource('posts', PostController::class);
    
    // Ruta adicional para UserPostController
    Route::get('/users/{userId}/posts/{postId}/attach', [UserPostController::class, 'attachPostToUser']);
});

Route::get('/about', function () {return view('about');})->name('about');

Auth::routes();
