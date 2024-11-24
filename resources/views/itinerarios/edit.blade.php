@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Itinerario "{{ $itinerario->nombre }}"</div>

                <div class="card-body">
                    <form action="{{ route('itinerarios.update', $itinerario->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del itinerario -->
                        <div class="form-group">
                            <label for="nombre">Nombre del Itinerario:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $itinerario->nombre }}">
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Descripción del itinerario -->
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3">{{ $itinerario->descripcion }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Bloque para los días -->
                        <h4 class="mt-4">Días del Itinerario</h4>
                        <div id="dias-container">
                            @foreach ($itinerario->dias as $dia)
                                <div class="dia-block border p-3 mb-3" data-dia="{{ $loop->iteration }}">
                                    <h5>Día {{ $loop->iteration }}</h5>
                                    <input type="hidden" name="dias[{{ $loop->index }}][id]" value="{{ $dia->id }}">
                                    
                                    <div class="form-group">
                                        <label>Descripción del Día:</label>
                                        <textarea name="dias[{{ $loop->index }}][descripcion]" class="form-control @error('dias.{{ $loop->index }}.descripcion') is-invalid @enderror" rows="3">{{ $dia->descripcion }}</textarea>
                                        @error('dias.{{ $loop->index }}.descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Imágenes del Día:</label>
                                        <input type="file" name="dias[{{ $loop->index }}][imagenes][]" class="form-control @error('dias.{{ $loop->index }}.imagenes') is-invalid @enderror" multiple>
                                        @error('dias.{{ $loop->index }}.imagenes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón para actualizar -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar Itinerario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
