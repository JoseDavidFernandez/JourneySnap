@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Perfil</div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="form-group">
                            <label for="birthdate">Fecha de Nacimiento:</label>
                            <input type="date" name="birthdate" id="birthdate" value="{{ $user->fecha_nacimiento }}" class="form-control @error('birthdate') is-invalid @enderror">
                            @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Descripcion -->
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ $user->descripcion }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Imagen de Perfil -->
                        <div class="form-group">
                            <label for="imagen_perfil">Imagen de Perfil:</label>
                            <br>
                            @if($user->imagen_perfil)
                                <img src="{{ asset('storage/' . $user->imagen_perfil) }}" alt="Imagen Perfil" class="img-thumbnail mb-2" width="150">
                                <div class="form-check">
                                    <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                                    <label for="remove_image" class="form-check-label">Eliminar imagen de perfil</label>
                                </div>
                            @endif
                            <input type="file" name="imagen_perfil" id="imagen_perfil" class="form-control-file @error('imagen_perfil') is-invalid @enderror">
                            @error('imagen_perfil')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
