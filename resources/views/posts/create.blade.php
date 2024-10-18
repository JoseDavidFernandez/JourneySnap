@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear nueva publicación</div>

                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="imagen_post">Imagen:</label><br>
                            <input type="file" class="form-control-file @error('imagen_post') is-invalid @enderror" name="imagen_post" id="imagen_post" required>
                            @error('imagen_post')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pais">País</label>
                            <select id="pais" name="pais" class="form-control @error('pais') is-invalid @enderror" onchange="loadCities(this.value)" required>
                                <option value="">Selecciona un país</option>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                            @error('pais')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <select id="ciudad" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" required>
                                <option value="">Selecciona una ciudad</option>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                            @error('ciudad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion_post">Descripción:</label>
                            <textarea name="descripcion_post" id="descripcion_post" class="form-control @error('descripcion_post') is-invalid @enderror" rows="3"></textarea>
                            @error('descripcion_post')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_publicacion">Fecha de Publicación:</label>
                            <input type="date" class="form-control @error('fecha_publicacion') is-invalid @enderror" name="fecha_publicacion" id="fecha_publicacion" required>
                            @error('fecha_publicacion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                const countrySelect = document.getElementById('pais');
                data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.cca2; // Código del país en formato ISO 3166-1 alpha-2
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching countries:', error));
    });

    function loadCities(countryCode) {
        const citySelect = document.getElementById('ciudad');
        citySelect.innerHTML = '<option value="">Selecciona una ciudad</option>';

        if (!countryCode) return;

        const username = 'josedavidfc'; // Tu nombre de usuario de Geonames

        fetch(`https://secure.geonames.org/searchJSON?country=${countryCode}&featureClass=P&maxRows=1000&username=${username}`)
            .then(response => response.json())
            .then(data => {
                data.geonames.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
</script>

@endsection
