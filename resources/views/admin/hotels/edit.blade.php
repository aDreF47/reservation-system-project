@extends('layouts.admin')

@section('title', 'Editar Hotel')

@section('content')
    <a href="{{ route('admin.hotels.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver
    </a>

    <h1 class="text-3xl font-semibold mb-6">Editar hotel</h1>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block mb-1 font-medium text-gray-700">Nombre del Hotel:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $hotel->name) }}"
                    required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="city" class="block mb-1 font-medium text-gray-700">Ciudad:</label>
                <input type="text" id="city" name="city" value="{{ old('city', $hotel->city) }}"
                    required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <div class="mb-4">
            <label for="address" class="block mb-1 font-medium text-gray-700">Dirección:</label>
            <textarea id="address" name="address" rows="2" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $hotel->address) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block mb-1 font-medium text-gray-700">Teléfono:</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $hotel->phone) }}"
                    required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $hotel->email) }}"
                    required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <div class="mb-4">
            <label for="stars" class="block mb-1 font-medium text-gray-700">Estrellas:</label>
            <select id="stars" name="stars" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Seleccione...</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('stars', $hotel->stars) == $i ? 'selected' : '' }}>
                        {{ $i }} {{ $i == 1 ? 'Estrella' : 'Estrellas' }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="mb-4">
            <label for="description" class="block mb-1 font-medium text-gray-700">Descripción:</label>
            <textarea id="description" name="description" rows="4" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $hotel->description) }}</textarea>
        </div>

        @if($hotel->images && count($hotel->images) > 0)
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Imágenes actuales:</label>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
                @foreach($hotel->images as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Hotel imagen" class="w-full h-20 object-cover rounded">
                @endforeach
            </div>
            <p class="text-sm text-gray-600">Las imágenes actuales serán reemplazadas si selecciona nuevas.</p>
        </div>
        @endif

        <div class="mb-6">
            <label for="images" class="block mb-1 font-medium text-gray-700">Nuevas imágenes:</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p class="text-sm text-gray-600 mt-1">Puede seleccionar múltiples imágenes</p>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Actualizar Hotel
        </button>
    </form>
@endsection