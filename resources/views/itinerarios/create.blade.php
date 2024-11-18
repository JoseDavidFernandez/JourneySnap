@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Itinerario para "{{ $post->ciudad }}, {{ $post->pais }}"</h1>

    <form action="{{ route('itinerarios.store', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Título del itinerario -->
        <div class="form-group">
            <label for="nombre">Nombre del itinerario</label>
            <input type="text" id="nombre" name="nombre" class="form-control" 
                value="Itinerario {{ $post->ciudad }}, {{ $post->pais }}" readonly>
        </div>

        <!-- Descripción del itinerario -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control editor" rows="3"></textarea>
        </div>

        <!-- Bloque para los días -->
        <h3>Días del itinerario</h3>
        <div id="dias-container">
            <!-- Día 1 (bloque inicial) -->
            <div class="dia-block" data-dia="1">
                <h4>Día 1</h4>
                <div class="form-group">
                    <label>Descripción del día</label>
                    <textarea name="dias[0][descripcion]" class="form-control editor" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Imágenes del día</label>
                    <input type="file" name="dias[0][imagenes][]" class="form-control" multiple>
                </div>
                <div class="form-group">
                    <label>URL de Google Maps</label>
                    <input type="url" name="dias[0][url]" class="form-control" placeholder="https://maps.google.com">
                </div>
            </div>
        </div>

        <button type="button" id="add-dia" class="btn btn-secondary mt-3">Añadir Día</button>

        <!-- Botón para enviar -->
        <button type="submit" class="btn btn-primary mt-4">Guardar Itinerario</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('add-dia').addEventListener('click', function () {
        const container = document.getElementById('dias-container');
        const diaCount = container.children.length + 1;

        const diaBlock = document.createElement('div');
        diaBlock.className = 'dia-block';
        diaBlock.dataset.dia = diaCount;
        diaBlock.innerHTML = `
            <h4>Día ${diaCount}</h4>
            <div class="form-group">
                <label>Descripción del día</label>
                <textarea name="dias[${diaCount - 1}][descripcion]" class="form-control editor" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Imágenes del día</label>
                <input type="file" name="dias[${diaCount - 1}][imagenes][]" class="form-control" multiple>
            </div>
            <div class="form-group">
                <label>URL de Google Maps</label>
                <input type="url" name="dias[${diaCount - 1}][url]" class="form-control" placeholder="https://maps.google.com">
            </div>
        `;
        container.appendChild(diaBlock);

        // Inicializa el editor enriquecido si es necesario
        if (typeof initializeEditor === 'function') {
            initializeEditor();
        }
    });
});


</script>
@endsection
