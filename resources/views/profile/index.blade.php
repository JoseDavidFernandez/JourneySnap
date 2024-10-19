@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Bloque Informacion Profile -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center items-center">
        <!-- Columna Izquierda -->
        <div class="flex flex-col">
            <!-- Contenedor de la imagen y descripción -->
            <div class="flex flex-col">
                <!-- Imagen de Perfil -->
                <div class="rounded-lg h-96 w-96 bg-gray-200 flex-shrink-0 overflow-hidden mx-auto md:mx-0">
                    <img src="{{ Auth::user()->imagen_perfil 
                                ? asset('storage/' . Auth::user()->imagen_perfil) 
                                : asset('storage/icon.profile.png') }}" 
                         alt="Imagen Perfil" class="h-full w-full object-cover" />
                </div>
                <!-- Descripción -->
                <div class="bg-gray-200 bg-opacity-75 p-4 mt-4 rounded-lg mx-auto md:mx-0" style="width: 24rem;"> 
                    <p class="text-sm">{{ Auth::user()->descripcion }}</p>
                </div>
            </div>
            <!-- Botón de Editar Perfil -->
            <a href="{{ route('profile.edit') }}" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-center mt-4 mx-auto md:mx-0">Editar Perfil</a>
        </div>
        <!-- Columna Derecha: Información del Usuario -->
        <div class="flex flex-col items-center justify-center text-center w-full">
            <!-- Subtitulo de Bienvenida -->
            <h3 class="text-lg mb-2">Hello!</h3>
            <!-- Nombre del Usuario -->
            <h2 class="text-4xl font-bold mb-2">{{ Auth::user()->name }}</h2>
            <!-- Username del Usuario -->
            <p class="text-xl mb-4">Username: {{ '@' . Auth::user()->username }}</p>
            
            <!-- Sección de Estadísticas -->
            <div class="w-full d-flex flex-column flex-md-row justify-content-between mb-6 text-center">
                <div class="flex flex-col items-center mb-4 md:mb-0">
                    <p class="text-lg font-semibold">Países Visitados</p>
                    <p class="text-2xl font-bold">{{ $posts->pluck('pais')->unique()->count() }}</p>
                </div>
                <div class="flex flex-col items-center mb-4 md:mb-0">
                    <p class="text-lg font-semibold">Mis Publicaciones</p>
                    <p class="text-2xl font-bold">{{ count($posts) }}</p>
                </div>
                <div class="flex flex-col items-center mb-4 md:mb-0">
                    <p class="text-lg font-semibold">Ciudades</p>
                    <p class="text-2xl font-bold">{{ $posts->pluck('ciudad')->unique()->count() }}</p>
                </div>
            </div>

            <!-- Div para comparar países -->
            <div id="paisesComparador" class="bg-blue-100 p-4 rounded-lg shadow-lg text-center mb-6 w-full">
                <h3 class="text-xl font-semibold mb-4">Comparación de Países</h3>
                <div class="d-flex justify-content-center align-items-center">
                    <p class="text-base" id="visitedCountries">{{ $posts->pluck('pais')->unique()->count() }}</p>
                    <p class="text-base font-semibold mx-1">/</p>
                    <p class="text-base" id="totalCountries"></p>
                </div>
                <p class="text-base font-semibold" id="visitedPercentage"></p> <!-- Nuevo elemento para mostrar el porcentaje -->
            </div>
            
            <!-- Botones de Acción -->
            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('posts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-center">Subir Publicacion</a>
            </div>
        </div>
    </div>

    <!-- Bloques Publicaciones -->
    <div class="container pt-5">
        <div class="row justify-content-center">
            @foreach($posts as $post)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <!-- Imagen Publicacion -->
                        @if($post->imagen_post)
                            <div class="overflow-hidden" style="height: 300px;">
                                <img src="{{ asset('storage/' . $post->imagen_post) }}" alt="Imagen del post" class="card-img-top" style="height: 100%; width: 100%; object-fit: contain;">
                            </div>
                        @endif
                        <!-- Informacion Publicacion -->
                        <div class="card-body d-flex flex-column">
                            <!-- Información Usuario -->
                            <div class="d-flex align-items-center mb-2">
                                <!-- Imagen de Perfil del Usuario -->
                                <div class="rounded-circle overflow-hidden" style="width: 48px; height: 48px;">
                                    <img src="{{ $user->imagen_perfil 
                                                ? asset('storage/' . $user->imagen_perfil) 
                                                : asset('storage/icon.profile.png') }}" 
                                         alt="Imagen Perfil" class="img-fluid">
                                </div>
                                <!-- Nombre Usuario -->
                                <p class="mb-0 ml-3 text-dark font-weight-bold">{{ '@' . $user->username }}</p>
                            </div>
                            <!-- Ubicacion Publicacion -->
                            <p class="text-muted small mb-1">{{ $post->pais }}, {{ $post->ciudad }}</p>
                            <!-- Descripcion Publicacion -->
                            <p class="text-dark">{{ $post->descripcion_post }}</p>
                            <!-- Fecha Publicacion -->
                            <p class="text-muted small mt-auto">{{ $post->fecha_publicacion }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener todos los países disponibles
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                const allCountries = data.map(country => country.name.common);
                const visitedCountriesCount = {{ $posts->pluck('pais')->unique()->count() }};
                const totalCountries = allCountries.length;
                
                // Calcular el porcentaje de países visitados
                const visitedPercentage = (visitedCountriesCount / totalCountries) * 100;
                
                // Mostrar resultados en el div 'paisesComparador'
                document.getElementById('totalCountries').textContent = totalCountries;
                document.getElementById('visitedPercentage').textContent = `Porcentaje visitado: ${visitedPercentage.toFixed(2)}%`;
            })
            .catch(error => console.error('Error fetching countries:', error));
    });
</script>

@endsection
