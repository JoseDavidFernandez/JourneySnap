@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Itinerario "{{ $itinerario->nombre }}"</h1>

    <form action="{{ route('itinerarios.update', $itinerario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Título del itinerario -->
        <div class="form-group">
            <label for="nombre">Nombre del itinerario</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $itinerario->nombre }}">
        </div>

        <!-- Descripción del itinerario -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control editor" rows="3">{{ $itinerario->descripcion }}</textarea>
        </div>

        <!-- Bloque para los días -->
        <h3>Días del itinerario</h3>
        <div id="dias-container">
            @foreach ($itinerario->dias as $dia)
            <div class="dia-block" data-dia="{{ $loop->iteration }}">
                <h4>Día {{ $loop->iteration }}</h4>
                <input type="hidden" name="dias[{{ $loop->index }}][id]" value="{{ $dia->id }}">
                <div class="form-group">
                    <label>Descripción del día</label>
                    <textarea name="dias[{{ $loop->index }}][descripcion]" class="form-control editor" rows="3">{{ $dia->descripcion }}</textarea>
                </div>
                <div class="form-group">
                    <label>Imágenes del día</label>
                    <input type="file" name="dias[{{ $loop->index }}][imagenes][]" class="form-control" multiple>
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-4">Actualizar Itinerario</button>
    </form>
</div>
@endsection
