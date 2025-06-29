@extends('layouts.admin')

@section('title', 'Editar Habitación')

@section('content')
    <a href="{{ route('admin.rooms.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver a Habitaciones
    </a>

    <h1 class="text-3xl font-semibold mb-6 text-gray-900">Editar habitación</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" 
          class="max-w-2xl bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <!-- Tipo de habitación -->
        <div class="mb-4">
            <label for="room_type_id" class="block mb-1 font-medium text-gray-700">Tipo de habitación:</label>
            <select id="room_type_id" name="room_type_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Seleccione un tipo de habitación...</option>
                @foreach($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}" {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                        {{ $roomType->hotel->name }} - {{ $roomType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Número de habitación -->
        <div class="mb-4">
            <label for="room_number" class="block mb-1 font-medium text-gray-700">Número de habitación:</label>
            <input type="text" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                placeholder="Ej: 101, 201A, Suite-01" required maxlength="10"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Piso -->
        <div class="mb-4">
            <label for="floor" class="block mb-1 font-medium text-gray-700">Piso:</label>
            <input type="number" id="floor" name="floor" value="{{ old('floor', $room->floor) }}"
                min="1" max="50" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Estado disponible -->
        <div class="mb-6">
            <div class="flex items-center">
                <input class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                       type="checkbox" name="available" id="available" value="1" 
                       {{ old('available', $room->available) ? 'checked' : '' }}>
                <label class="text-sm font-medium text-gray-700" for="available">
                    Habitación disponible
                </label>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-between">
            <a href="{{ route('admin.rooms.index') }}" 
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Actualizar Habitación
            </button>
        </div>
    </form>
@endsection