@extends('layouts.app')

@section('content')
<div class="container max-w-6xl mx-auto py-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-6 title-blue-light">Todos los Itinerarios</h1>

    <!-- Listado de Itinerarios -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
        @foreach($itinerarios as $itinerario)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 max-w-md w-full">
                <!-- Ciudad y País -->
                <div class="p-4 bg-gray-100">
                    <h3 class="text-xl text-gray-700 text-center font-semibold">{{ $itinerario->nombre }}</h3>
                </div>

                <!-- Descripción -->
                <div class="p-6">
                    <p class="text-gray-600 mb-4">{{ Str::limit($itinerario->descripcion, 80) }}</p>

                    @if($itinerario->dias->count() > 0)
                        <h4 class="text-gray-700 font-medium mb-2">Días destacados:</h4>
                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                            @foreach($itinerario->dias->take(3) as $dia)
                            <li>Día {{ $dia->numero_dia }}: {{ Str::limit($dia->descripcion, 50) }}</li>
                            @endforeach
                            @if($itinerario->dias->count() > 3)
                                <li class="text-blue-500">Y más...</li>
                            @endif
                        </ul>
                    @endif
                </div>

                <!-- Botón Ver más -->
                <div class="p-4 text-center border-t border-gray-200">
                    <a href="{{ route('itinerarios.show', $itinerario->id) }}" class="inline-block bg-black text-white px-6 py-2 rounded-lg shadow-md hover:bg-white hover:text-black hover:shadow-lg transition-colors duration-300">
                        Ver detalles &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
</div>
@endsection
