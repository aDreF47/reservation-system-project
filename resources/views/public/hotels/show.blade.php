@extends('layouts.app')
@section('title', $hotel->name)
@section('content')
    <!-- Contenedor principal -->
    <div class="container mx-auto py-8 px-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">{{ $hotel->name }}</h1>
            <div class="flex items-center">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $hotel->stars)
                        <i class="fas fa-star text-yellow-500"></i>
                    @else
                        <i class="far fa-star text-yellow-500"></i>
                    @endif
                @endfor
                <span class="ml-2 text-gray-600">{{ $hotel->address }}, {{ $hotel->city }}</span>
            </div>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-8">
            <div class="flex">
                <input type="text"
                    class="w-full border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Buscar...">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-r-md">Buscar</button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Lista de tipos de habitaciones (Columna izquierda) -->
            <div class="md:w-2/3">
                <h3 class="text-2xl font-semibold mb-4 border-b pb-2">Tipos de Habitaciones</h3>

                @forelse($hotel->roomTypes as $roomType)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="flex flex-col md:flex-row">
                            <!-- Imagen de la habitación -->
                            <div class="md:w-1/3">
                                <img src="{{ $roomType->main_image }}" alt="{{ $roomType->name }}"
                                    class="h-full w-full object-cover">
                            </div>

                            <!-- Información de la habitación -->
                            <div class="md:w-2/3 p-6">
                                <h4 class="text-xl font-bold mb-2">{{ $roomType->name }}</h4>
                                <div class="mb-3 flex flex-wrap gap-2">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Capacidad:
                                        {{ $roomType->capacity }}</span>
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Precio:
                                        S/ {{ number_format($roomType->base_price, 2) }} x noche</span>
                                </div>

                                <p class="text-gray-700 mb-3">{{ Str::limit($roomType->description, 100) }}</p>

                                <div class="mb-3">
                                    <p class="font-semibold mb-1">Servicios:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($roomType->characteristics->take(4) as $characteristic)
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $characteristic->name }}</span>
                                        @endforeach

                                        @if ($roomType->characteristics->count() > 4)
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">+{{ $roomType->characteristics->count() - 4 }}
                                                más</span>
                                        @endif
                                    </div>
                                </div>

                                <p class="text-sm text-gray-500 mb-3">Num:
                                    @foreach ($roomType->rooms->take(4) as $room)
                                        {{ $room->room_number }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                    @if ($roomType->rooms->count() > 4)
                                        ...
                                    @endif
                                </p>

                                <div class="flex justify-between items-center mt-4">
                                    <p class="text-blue-600">Disponibles: {{ $roomType->available_rooms_count }}
                                        habitaciones</p>

                                    @if ($roomType->available_rooms_count > 0)
                                            <a href="{{ route('room_types.show', [$hotel, $roomType->id]) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Ver
                                            detalles</a>
                                    @else
                                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                            disabled>No disponible</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="bg-blue-100 text-blue-800 p-4 rounded-lg">
                            No hay habitaciones disponibles en este hotel.
                        </div>
                    @endforelse

                    <!-- Paginación -->
                    <div class="flex justify-center mt-8">
                        <nav class="inline-flex rounded-md shadow-sm">
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                                <span class="sr-only">Anterior</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="py-2 px-3 bg-blue-600 text-white border border-blue-600">1</a>
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 hover:bg-gray-100">2</a>
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 hover:bg-gray-100">3</a>
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 hover:bg-gray-100">4</a>
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 hover:bg-gray-100">5</a>
                            <a href="#" class="py-2 px-3 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100">
                                <span class="sr-only">Siguiente</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Sección de comentarios (Columna derecha) -->
                <!-- Sección de comentarios adaptada al diseño mostrado -->
<div class="md:w-1/3">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Cabecera azul para comentarios -->
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-bold">Comentarios</h4>
        </div>

        <div class="p-6">
            <h5 class="text-lg font-semibold mb-4">Lo que más gusta a quienes se alojan aquí</h5>

            @forelse($hotel->reviews()->where('approved', 1)->with('user')->get() as $review)
                <div class="mb-6 pb-4 border-b border-gray-200">
                    <div class="flex items-start">
                        <!-- Avatar circular con inicial -->
                        <div class="rounded-full bg-blue-600 text-white flex items-center justify-center w-10 h-10 mr-3">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>

                        <div>
                            <h6 class="font-semibold">{{ $review->user->name }}</h6>
                            <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 mt-1 inline-block">Más info</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No hay comentarios para este hotel todavía.</p>
            @endforelse

            <!-- Formulario para añadir comentario -->
            <div class="mt-8">
                <h5 class="text-lg font-semibold mb-4">Deja tu comentario</h5>

                @auth
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Calificación</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2" name="rating" required>
                                <option value="">Selecciona</option>
                                <option value="5">5 estrellas - Excelente</option>
                                <option value="4">4 estrellas - Muy bueno</option>
                                <option value="3">3 estrellas - Bueno</option>
                                <option value="2">2 estrellas - Regular</option>
                                <option value="1">1 estrella - Malo</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Tu comentario</label>
                            <textarea class="w-full border border-gray-300 rounded px-3 py-2" name="comment" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                            Enviar comentario
                        </button>
                    </form>
                @else
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg">
                        <p>Para dejar un comentario, por favor <a href="{{ route('login') }}" class="text-blue-600 hover:underline">inicia sesión</a>.</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    @endsection
