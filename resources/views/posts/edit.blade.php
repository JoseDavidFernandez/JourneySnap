@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Publicación</div>

                <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Campo para la descripción -->
                        <div class="form-group">
                            <label for="descripcion_post">Descripción:</label>
                            <textarea name="descripcion_post" id="descripcion_post" class="form-control @error('descripcion_post') is-invalid @enderror" rows="5" required>{{ old('descripcion_post', $post->descripcion_post) }}</textarea>
                            @error('descripcion_post')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Botón para actualizar -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
