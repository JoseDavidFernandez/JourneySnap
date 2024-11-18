@extends('layouts.app')

@section('content')
<div class="container max-w-6xl mx-auto py-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Todos los Itinerarios</h1>

    <!-- Listado de Itinerarios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($itinerarios as $itinerario)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Nombre del itinerario -->
                <div class="p-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $itinerario->nombre }}</h2>
                    <p class="text-gray-600 mt-2">{{ Str::limit($itinerario->descripcion, 100) }}</p>
                </div>

                <!-- Lista breve de días -->
                @if($itinerario->dias->count() > 0)
                    <div class="p-4 bg-gray-100">
                        <h3 class="text-gray-700 font-medium mb-2">Días:</h3>
                        <ul class="list-disc list-inside text-gray-600">
                            @foreach($itinerario->dias->take(3) as $dia)
                                <li>Día {{ $dia->numero_dia }}: {{ Str::limit($dia->descripcion, 50) }}</li>
                            @endforeach
                            @if($itinerario->dias->count() > 3)
                                <li class="text-blue-500">...</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <!-- Botón para ver más -->
                <div class="p-4 text-center">
                    <a href="{{ route('itinerarios.show', $itinerario->id) }}" class="text-blue-500 hover:underline">
                        Ver detalles &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
