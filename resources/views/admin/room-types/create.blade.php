@extends('layouts.admin')

@section('title', 'Crear Tipo de Habitación')

@section('content')
    <a href="{{ route('admin.room-types.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver a Tipos de Habitación
    </a>

    <h1 class="text-3xl font-semibold mb-6 text-gray-900">Crear nuevo tipo de habitación</h1>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" 
          class="max-w-2xl bg-white p-6 rounded-lg shadow">
        @csrf

        <!-- Hotel -->
        <div class="mb-4">
            <label for="hotel_id" class="block mb-1 font-medium text-gray-700">Hotel:</label>
            <select id="hotel_id" name="hotel_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Seleccione un hotel...</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nombre del tipo -->
        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium text-gray-700">Nombre del tipo:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                placeholder="Ej: Habitación Simple, Suite Ejecutiva" required maxlength="50"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="description" class="block mb-1 font-medium text-gray-700">Descripción:</label>
            <textarea id="description" name="description" rows="4" required
                placeholder="Describe las características de este tipo de habitación..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Capacidad -->
            <div>
                <label for="capacity" class="block mb-1 font-medium text-gray-700">Capacidad (personas):</label>
                <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}"
                    min="1" max="10" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Precio base -->
            <div>
                <label for="base_price" class="block mb-1 font-medium text-gray-700">Precio base:</label>
                <input type="number" step="0.01" id="base_price" name="base_price" value="{{ old('base_price') }}"
                    min="0" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Imagen principal -->
        <div class="mb-6">
            <label for="main_image" class="block mb-1 font-medium text-gray-700">Imagen principal:</label>
            <input type="file" id="main_image" name="main_image" accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p class="text-sm text-gray-600 mt-1">Formatos: JPG, PNG. Máximo 2MB</p>
        </div>

        <!-- Botones -->
        <div class="flex justify-between">
            <a href="{{ route('admin.room-types.index') }}" 
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Crear Tipo de Habitación
            </button>
        </div>
    </form>
@endsection