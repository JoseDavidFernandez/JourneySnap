@extends('layouts.app')

@section('content')

<!-- Bloque del mapa a pantalla completa -->
<div class="w-full bg-white p-8 mb-8">
    <h2 class="text-2xl font-semibold mb-4 text-center">Sumérgete en tu siguiente escapada</h2>
    <div class="w-full h-96 bg-gray-300 flex justify-center items-center rounded-lg">
        <div id="mi_mapa" class="w-full h-96"></div>

        <!-- API MAPS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-o8Qv+udvtw3FZzI6EYtykAuw6u2wNryj5qBc1Qzt1lg=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Leaflet.markercluster -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css">
        <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var map = L.map('mi_mapa').setView([20, 0], 2);

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

<!-- Contenedor de contenido principal -->
<div class="container mx-auto mt-8 px-6">
    
    <!-- Bloques Publicaciones -->
    <div class="container pt-5" id="bloquePost">
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
    </div>
    <!-- end Bloques Publicaciones -->
    
    <!-- Nuevo Bloque con Imagen y Texto -->
    <h3>Lorem ipsum dolor sit amet</h3>
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <img src="storage/img-prueba-home.png" alt="Imagen" class="img-fluid" style="max-height: 500px; object-fit: cover;">
            </div>
            <div class="col-md-6 mb-4">
                <div class="d-flex flex-column justify-content-center h-100">
                    <p>JourneySnap es una plataforma única pensada para quienes desean preservar y compartir cada detalle de sus aventuras alrededor del mundo. Aquí, tu viaje se convierte en una historia visual que nunca perderás de vista, capturada en imágenes y anécdotas que son parte esencial de cada experiencia. En JourneySnap, cada destino cobra vida en un mapa que cuenta la historia de tus viajes, acumulando recuerdos mientras descubres el mundo y marcas cada ciudad y país en un registro visual y geográfico.</p>

                    <p>Viajar no solo es llegar a un destino; es coleccionar momentos y, en JourneySnap, te ayudamos a preservar cada uno. La plataforma permite almacenar tus publicaciones con facilidad: una foto, una ubicación y una descripción, dándote la oportunidad de documentar cada aventura en una interfaz intuitiva y diseñada para el viajero moderno. Cada publicación se suma a un mapa personal y privado que visualiza los lugares visitados, contabiliza las ciudades y países alcanzados, y te motiva a continuar descubriendo para completar el 100% del mundo.</p>

                    <p>Ya sea que busques recordar cada rincón de tus viajes o te inspires en la comunidad para encontrar tu próximo destino, JourneySnap es tu compañero ideal para dar vida a cada momento, grande o pequeño, y dejarlo plasmado en un mapa único que refleja tus pasos en el mundo.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bloque Blog/Itinerarios-->
    <h3>Bloque Blog/Itinerarios</h3>
    <div class="container pt-5">
        
    </div>

</div>

@endsection
