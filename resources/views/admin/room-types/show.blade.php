@extends('layouts.admin')

@section('title', 'Ver Tipo de Habitación')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.room-types.index') }}" class="inline-block text-blue-600 hover:underline">
            ← Volver a Tipos de Habitación
        </a>
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.room-types.edit', $roomType) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            <form action="{{ route('admin.room-types.destroy', $roomType) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 flex items-center"
                        onclick="return confirm('¿Está seguro de eliminar este tipo de habitación?')">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header con imagen -->
        <div class="relative h-64 bg-gray-200">
            @if($roomType->main_image)
                <img src="{{ asset('storage/' . $roomType->main_image) }}" 
                     alt="{{ $roomType->name }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-300">
                    <i class="fas fa-image text-6xl text-gray-500"></i>
                </div>
            @endif
            
            <!-- Overlay con título -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                <h1 class="text-3xl font-bold text-white">{{ $roomType->name }}</h1>
                <p class="text-white/90 mt-1">{{ $roomType->hotel->name }}</p>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información Principal -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información General</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-hotel text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Hotel:</span>
                            </div>
                            <span class="text-gray-900">{{ $roomType->hotel->name }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-bed text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Tipo:</span>
                            </div>
                            <span class="text-gray-900">{{ $roomType->name }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-users text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Capacidad:</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $roomType->capacity }} personas
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign text-green-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Precio Base:</span>
                            </div>
                            <span class="text-2xl font-bold text-green-600">${{ number_format($roomType->base_price, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Creado:</span>
                            </div>
                            <span class="text-gray-900">{{ $roomType->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Descripción</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $roomType->description }}</p>
                    </div>

                    <!-- Estadísticas adicionales -->
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">0</div>
                            <div class="text-sm text-blue-800">Habitaciones</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">0</div>
                            <div class="text-sm text-green-800">Reservas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection