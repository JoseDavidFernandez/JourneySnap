<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ItinerarioController;
use App\Http\Controllers\AdminController;


use App\Http\Controllers\BlogController;


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

// ADMINISTRADOR
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});




// con middleware de autenticación
Route::middleware('auth')->group(function () {
    // Rutas para ProfileController 
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/deleteImage', [ProfileController::class, 'deleteImage'])->name('profile.deleteImage');
    
    // Rutas para PostController
    Route::resource('posts', PostController::class);
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');


    // Ruta adicional para UserPostController
    Route::get('/users/{userId}/posts/{postId}/attach', [UserPostController::class, 'attachPostToUser']);

    // Rutas API (usar routes/api.php)
    Route::get('/get-coordinates', [CityController::class, 'getCoordinates']);

    // O, si prefieres usar web (routes/web.php)
    Route::get('/get-coordinates', [CityController::class, 'getCoordinates']);

    // Rutas para Itinerarios
    Route::get('itinerarios/create/{postId}', [ItinerarioController::class, 'create'])->name('itinerarios.create');
    Route::post('itinerarios/store/{postId}', [ItinerarioController::class, 'store'])->name('itinerarios.store');
    Route::get('/itinerarios/{id}', [ItinerarioController::class, 'show'])->name('itinerarios.show');
    Route::get('/itinerarios', [ItinerarioController::class, 'index'])->name('itinerarios.index');

        // Ruta para mostrar el formulario de edición
    Route::get('itinerarios/edit/{id}', [ItinerarioController::class, 'edit'])->name('itinerarios.edit');

    // Ruta para actualizar un itinerario
    Route::put('itinerarios/update/{id}', [ItinerarioController::class, 'update'])->name('itinerarios.update');

    // Ruta para eliminar un itinerario
    Route::delete('itinerarios/delete/{id}', [ItinerarioController::class, 'destroy'])->name('itinerarios.destroy');



});


Route::get('/about', function () {return view('about');})->name('about');

Auth::routes();
