@extends('layouts.admin')

@section('title', 'Ver Hotel')

@section('content')
    <a href="{{ route('admin.hotels.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver
    </a>

    <div class="flex justify-between items-start mb-6">
        <h1 class="text-3xl font-semibold">{{ $hotel->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.hotels.edit', $hotel) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                <i class="fas fa-edit mr-1"></i>Editar
            </a>
            <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
                        onclick="return confirm('¿Está seguro de eliminar este hotel?')">
                    <i class="fas fa-trash mr-1"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Información General</h3>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Nombre:</span>
                        <span class="ml-2">{{ $hotel->name }}</span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Ciudad:</span>
                        <span class="ml-2">{{ $hotel->city }}</span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Dirección:</span>
                        <span class="ml-2">{{ $hotel->address }}</span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Teléfono:</span>
                        <span class="ml-2">{{ $hotel->phone }}</span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="ml-2">{{ $hotel->email }}</span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Estrellas:</span>
                        <span class="ml-2">
                            @for($i = 0; $i < $hotel->stars; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </span>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Estado:</span>
                        <span class="ml-2">
                            @if($hotel->active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactivo
                                </span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Descripción</h3>
                <p class="text-gray-700">{{ $hotel->description }}</p>
            </div>
        </div>

        @if($hotel->images && count($hotel->images) > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4">Imágenes</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($hotel->images as $image)
                    <div class="rounded-lg overflow-hidden shadow">
                        <img src="{{ asset('storage/' . $image) }}" alt="Hotel imagen" class="w-full h-48 object-cover">
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection