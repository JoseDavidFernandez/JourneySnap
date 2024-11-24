@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Título del Itinerario -->
    <div class="text-center mb-4">
        <h1 class="fw-bold title-blue-light">{{ $itinerario->nombre }}</h1>
    </div>

    <!-- Descripción del Itinerario -->
    <div class="text-center mb-5">
        <p class="text-white fs-5 ">{{ $itinerario->descripcion }}</p>
    </div>

    <!-- Días del Itinerario -->
    <div class="itinerario">
        @foreach ($itinerario->dias as $dia)
        <div class="row mb-5 align-items-center {{ $loop->iteration % 2 == 0 ? 'flex-row-reverse' : '' }}">
            <!-- Descripción del Día -->
            <div class="col-md-6">
                <h4 class="fw-bold mb-3">Día {{ $loop->iteration }}</h4>
                <p class="text-white">{{ $dia->descripcion }}</p>

                @if (!empty($dia->url))
                <p class="mt-3">
                    <a href="{{ $dia->url }}" target="_blank" class="btn btn-primary btn-sm">Ver en Google Maps</a>
                </p>
                @endif
            </div>

            <!-- Imágenes del Día -->
            <div class="col-md-6">
                @if ($dia->imagenes && $dia->imagenes->isNotEmpty())
                <div id="carouselDia{{ $loop->iteration }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($dia->imagenes as $index => $imagen)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $imagen->path) }}" alt="Imagen del día" class="d-block w-100 rounded shadow-sm">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDia{{ $loop->iteration }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselDia{{ $loop->iteration }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @else
                <p class="text-white">No hay imágenes para este día.</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Botones de acciones -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('itinerarios.edit', $itinerario->id) }}" class="btn btn-warning me-2">Editar Itinerario</a>

        <form action="{{ route('itinerarios.destroy', $itinerario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este itinerario?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar Itinerario</button>
        </form>
    </div>

</div>
@endsection
