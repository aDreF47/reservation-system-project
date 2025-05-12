@extends('layouts.app')

@section('title', 'Hoteles')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Barra de búsqueda -->
        <div class="mb-6 flex justify-between items-center">
            <input type="text" placeholder="Buscar hoteles..." class="px-4 py-2 border border-gray-300 rounded-md w-1/2">
            <button class="px-6 py-2 bg-blue-600 text-white rounded-md">Buscar</button>
        </div>

        <div class="flex space-x-6">
            <!-- Filtros -->
            <div class="w-1/4 p-4 bg-gray-50  rounded-lg ">
                <h3 class="font-semibold text-lg mb-4">Filtros</h3>
                <div class="space-y-4">
                    <div>
                        <label for="stars" class="block text-sm">Estrellas</label>
                        <select id="stars" class="w-full p-2 border rounded-md">
                            <option value="all">Todas</option>
                            <option value="5">5 Estrellas</option>
                            <option value="4">4 Estrellas</option>
                            <option value="3">3 Estrellas</option>
                        </select>
                    </div>
                    <div>
                        <label for="price-range" class="block text-sm">Rango de precios</label>
                        <input type="range" id="price-range" min="0" max="1000" class="w-full">
                    </div>
                    <button class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-md">Aplicar filtros</button>
                </div>
            </div>

            <!-- Lista de hoteles -->
            <div class="flex-1">
                <!-- Aquí usamos un contenedor para asegurarnos que las tarjetas están en lista -->
                <div class="space-y-6">
                    @foreach ($hotels as $hotel)
                        <x-cards.hotel-card :hotel="$hotel" />
                    @endforeach
                </div>

                <!-- Paginación (si es necesario) -->
                <div class="mt-6 flex justify-center">
                    {{ $hotels->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
