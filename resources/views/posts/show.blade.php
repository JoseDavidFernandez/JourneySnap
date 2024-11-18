@extends('layouts.app')

@section('content')

<div class="container max-w-4xl mx-auto py-6">
    <!-- Encabezado del Post con la imagen a la izquierda y detalles a la derecha -->
    <div class="flex align-items-center justify-content-center mb-6">
        <!-- Imagen del Post  -->
        @if($post->imagen_post)
            <div class="w-1/2 pr-6">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $post->imagen_post) }}" alt="Imagen del post" class="w-full h-auto object-cover">
                </div>
            </div>
        @endif

        <!-- Detalles del Post -->
        <div class="w-1/2">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $post->descripcion_post }}</h1>

            <h3 class="text-gray-600">{{ $post->pais }}, {{ $post->ciudad }}</h3>
            
            <!-- Descripción del Post -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <p class="text-gray-700 leading-relaxed text-lg">
                    {!! nl2br(e($post->descripcion_post)) !!}
                </p>
            </div>
            <!-- Información del autor y ubicación -->
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $post->user->imagen_perfil) }}" alt="Imagen de perfil" class="rounded-full w-16 h-16 object-cover">
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                    <p class="font-semibold text-gray-800">{{ '@' . Auth::user()->username }}</p>
                </div>
            </div>
            
            <!-- Fecha de publicación -->
            <p class="text-gray-600">Publicado el {{ \Carbon\Carbon::parse($post->fecha_publicacion)->format('d M, Y') }}</p>
        </div>
    </div>

    <!-- Ver Itinerario (Si existe) -->
    @if($post->itinerario)
        <section class="bg-gray-100 rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Itinerario: {{ $post->itinerario->nombre }}</h2>
            <p class="text-gray-700 leading-relaxed mb-4">{{ $post->itinerario->descripcion }}</p>
            
            <h3 class="text-xl font-medium text-gray-700 mb-3">Días del Itinerario:</h3>
            <ul class="list-disc list-inside space-y-3">
                @foreach($post->itinerario->dias as $dia)
                    <li>
                        <strong class="text-gray-800">Día {{ $dia->numero_dia }}:</strong> 
                        <span class="text-gray-700">{{ $dia->descripcion }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- Botón para ver el itinerario -->
        <div class="mt-6 text-center">
            <a href="{{ route('itinerarios.show', $post->itinerario->id) }}" class="text-blue-500 hover:underline text-lg">
                    Ver itinerario completo
            </a>
        </div>
    @else
        <!-- Si no tiene itinerario, botón para crear un itinerario -->
        <div class="mt-6 text-center">
            <a href="{{ route('itinerarios.create', $post->id) }}" class="text-blue-500 hover:underline text-lg">
                Crear un itinerario
            </a>
        </div>
    @endif

    <!-- Botón para volver -->
    <div class="mt-6 text-center">
        <a href="{{ route('profile.index') }}" class="text-blue-500 hover:underline text-lg">
            &larr; Volver a todas las publicaciones
        </a>
    </div>
</div>

@endsection
