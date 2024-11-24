@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Itinerario para "{{ $post->ciudad }}, {{ $post->pais }}"</div>

                <div class="card-body">
                    <form action="{{ route('itinerarios.store', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nombre del itinerario -->
                        <div class="form-group">
                            <label for="nombre">Nombre del itinerario</label>
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                value="Itinerario {{ $post->ciudad }}, {{ $post->pais }}" readonly>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Descripción del itinerario -->
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3" required></textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Bloque para los días -->
                        <h5 class="mt-4">Días del itinerario</h5>
                        <div id="dias-container">
                            <!-- Día 1 (bloque inicial) -->
                            <div class="dia-block card mb-3" data-dia="1">
                                <div class="card-header">Día 1</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Descripción del día</label>
                                        <textarea name="dias[0][descripcion]" class="form-control @error('dias.*.descripcion') is-invalid @enderror" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Imágenes del día</label>
                                        <input type="file" name="dias[0][imagenes][]" class="form-control @error('dias.*.imagenes') is-invalid @enderror" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="add-dia" class="btn btn-primary mt-2">Añadir Día</button>
                        </div>

                        <!-- Botón para enviar -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Itinerario</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('add-dia').addEventListener('click', function () {
            const container = document.getElementById('dias-container');
            const diaCount = container.children.length + 1;

            const diaBlock = document.createElement('div');
            diaBlock.className = 'dia-block card mb-3';
            diaBlock.dataset.dia = diaCount;
            diaBlock.innerHTML = `
                <div class="card-header">Día ${diaCount}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Descripción del día</label>
                        <textarea name="dias[${diaCount - 1}][descripcion]" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Imágenes del día</label>
                        <input type="file" name="dias[${diaCount - 1}][imagenes][]" class="form-control" multiple>
                    </div>
                </div>
            `;
            container.appendChild(diaBlock);
        });
    });
</script>

@endsection
