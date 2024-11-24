@extends('layouts.app')

@section('content')

    <!-- PRIMER BLOQUE -->
    <div class="w-full text-white py-16 text-center">
        <h1 class="text-4xl font-bold leading-tight">
            Captura y Comparte tus Aventuras con JourneySnap
        </h1>
        <p class="mt-4 text-lg text-gray-muted">
            Una plataforma diseñada para preservar cada instante de tus viajes y conectar con una comunidad inspiradora de viajeros.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('posts.create') }}" class="btn-primary">Subir Publicacion</a>
            <a href="{{ route('profile.index') }}" class="btn-secondary"> Ver Perfil </a>
        </div>
    </div>

    <!-- SEGUNDO BLOQUE -->
    <div class="w-full bg-white shadow-lg rounded-lg p-16 max-w-screen-xl mx-auto">
        <div class="grid grid-cols-4 gap-6 items-center">
            <!-- Bloque izquierdo -->
            <div class="col-span-1 text-center">
                <h3 class="text-2xl font-semibold text-dark-base">Publica tus Viajes</h3>
                <p class="text-gray-muted mt-4">
                    Sube fotos de tus aventuras, añade ubicaciones y crea un mapa interactivo de tus experiencias.
                </p>
            </div>
            <!-- Imagen central -->
            <div class="col-span-2 text-center">
                <img src="{{ asset('storage/img-prueba-home.png') }}" alt="Mapa" class="w-full h-auto">
            </div>
            <!-- Bloque derecho -->
            <div class="col-span-1 text-center">
                <h3 class="text-2xl font-semibold text-dark-base">Explora tus Destinos</h3>
                <p class="text-gray-muted mt-4">
                    Descubre el alcance de tus viajes y visualiza tus recuerdos de forma única y significativa.
                </p>
            </div>
        </div>
    </div>

    <!-- TERCER BLOQUE MAPA -->
    <div class="w-full p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-center title-blue-light">Sumérgete en tu siguiente escapada</h2>
        <div class="contenedor_mi_mapa w-full bg-gray-300 flex justify-center items-center rounded-lg">
            <div id="mi_mapa" class="w-full"></div>

            <!-- API MAPS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-o8Qv+udvtw3FZzI6EYtykAuw6u2wNryj5qBc1Qzt1lg=" crossorigin=""/>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

            <!-- Leaflet.markercluster -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css">
            <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    //var map = L.map('mi_mapa').setView([20, 0], 2);
                    var map = L.map('mi_mapa', {
                        center: [20, 0], // Coordenadas iniciales
                        zoom: 3,          // Nivel de zoom inicial
                        minZoom: 3,       // Nivel de zoom mínimo
                        maxZoom: 10,      // Nivel de zoom máximo
                        zoomControl: true // Control de zoom activado
                    });

                    /* Capa del mapa */
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Grupo de marcadores
                    var markers = L.markerClusterGroup();

                    // Ubicaciones de los posts
                    var posts = @json($posts);

                    // Añadir marcadores al mapa con agrupación
                    posts.forEach(function(post) {
                        if (post.ubicaciones && post.ubicaciones.latitud && post.ubicaciones.longitud) {
                            var marker = L.marker([post.ubicaciones.latitud, post.ubicaciones.longitud]);

                            // Contenido del pop-up
                            var popupContent = `
                                <div style="text-align: center;">
                                    <img src="${post.imagen_post ? '/storage/' + post.imagen_post : '/path/to/default-image.jpg'}" alt="Imagen del post" style="width: 100%; height: auto; max-height: 150px; object-fit: cover;"/><br>
                                    <strong>${post.ciudad}</strong><br>
                                    ${post.descripcion_post}
                                </div>
                            `;
                            marker.bindPopup(popupContent);
                            markers.addLayer(marker);
                        }
                    });

                    // Añadir grupo de marcadores al mapa
                    map.addLayer(markers);
                });
            </script>
        </div>
    </div>
    <!-- end Mapa del mundo Open Street Map | Leaflet -->

    <!-- CUARTO BLOQUE: CONTADORES -->
    
    <!-- QUINTO BLOQUE: PUBLICACIONES -->
    <div class="container pt-5" id="bloquePost">
        <h2 class="text-2xl font-bold text-center mb-8 title-blue-light">Posts</h2>

        @if($posts->isEmpty())
            <p class="text-center text-gray-500">Aún no tienes publicaciones. ¡Crea una para compartir tu experiencia!</p>
        @else
            <div class="row justify-content-center">
                @foreach($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="custom-card">
                            <div class="custom-card-img">
                                @if($post->imagen_post)
                                    <img src="{{ asset('storage/' . $post->imagen_post) }}" alt="Imagen del post">
                                @endif
                            </div>
                            <div class="custom-card-overlay">
                                <h2 class="custom-card-title">{{ $post->ciudad }}</h2>
                                <a href="{{ route('posts.show', $post->id) }}" class="custom-card-button">Ver Post</a>                            
                                <p class="custom-card-date">{{ $post->fecha_publicacion }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- end Bloques Publicaciones -->
    
    <!-- SEXTO BLOQUE: ITINERARIOS -->
    <div class="container mx-auto mt-8 px-6">
        <h2 class="text-2xl font-bold text-center mb-8 title-blue-light">Itinerarios</h2>

        @if($itinerarios->isEmpty())
            <p class="text-center text-gray-500">Aún no tienes itinerarios. ¡Crea uno para empezar tu aventura!</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
                @foreach($itinerarios as $itinerario)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 max-w-md w-full">
                        <!-- Ciudad y País -->
                        <div class="p-4 bg-gray-100">
                            <h3 class="text-xl text-gray-700 text-center font-semibold">{{ $itinerario->nombre }}</h3>
                        </div>

                        <!-- Descripción -->
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">{{ Str::limit($itinerario->descripcion, 80) }}</p>

                            @if($itinerario->dias->count() > 0)
                                <h4 class="text-gray-700 font-medium mb-2">Días destacados:</h4>
                                <ul class="list-disc list-inside text-gray-600 space-y-1">
                                    @foreach($itinerario->dias->take(3) as $dia)
                                        <li>Día {{ $dia->numero_dia }}: {{ Str::limit($dia->descripcion, 50) }}</li>
                                    @endforeach
                                    @if($itinerario->dias->count() > 3)
                                        <li class="text-blue-500">Y más...</li>
                                    @endif
                                </ul>
                            @endif
                        </div>

                        <!-- Botón Ver más -->
                        <div class="p-4 text-center border-t border-gray-200">
                            <a href="{{ route('itinerarios.show', $itinerario->id) }}" class="inline-block bg-black text-white px-6 py-2 rounded-lg shadow-md hover:bg-white hover:text-black hover:shadow-lg transition-colors duration-300">
                                Ver detalles &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botón para ver todos los itinerarios -->
            <div class="text-center mt-8">
                <a href="{{ route('itinerarios.index') }}" class="btn-primary inline-block">
                    Ver todos los itinerarios
                </a>
            </div>
        @endif
    </div>




@endsection
