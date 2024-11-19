@extends('layouts.app')

@section('content')

<div class="container max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Editar publicación</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="descripcion_post" class="block text-gray-700 font-medium mb-2">Descripción:</label>
            <textarea name="descripcion_post" id="descripcion_post" class="form-control w-full p-2 border border-gray-300 rounded" rows="5" required>{{ old('descripcion_post', $post->descripcion_post) }}</textarea>
            @error('descripcion_post')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

@endsection
