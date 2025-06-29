@extends('layouts.admin')

@section('title', 'Ver Habitación')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="inline-block text-blue-600 hover:underline">
            ← Volver a Habitaciones
        </a>
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.rooms.edit', $room) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 flex items-center"
                        onclick="return confirm('¿Está seguro de eliminar esta habitación?')">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8">
            <div class="flex items-center">
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-door-open text-3xl text-white"></i>
                </div>
                <div class="ml-6">
                    <h1 class="text-3xl font-bold text-white">Habitación {{ $room->room_number }}</h1>
                    <p class="text-blue-100 mt-1">{{ $room->roomType->hotel->name }}</p>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información de la Habitación -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información de la Habitación</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-hashtag text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Número:</span>
                            </div>
                            <span class="text-gray-900 font-semibold">{{ $room->room_number }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-building text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Piso:</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Piso {{ $room->floor }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-toggle-on text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Estado:</span>
                            </div>
                            @if($room->available)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></div>
                                    Ocupada
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-blue-600 w-5"></i>
                                <span class="ml-3 font-medium text-gray-700">Creada:</span>
                            </div>
                            <span class="text-gray-900">{{ $room->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Información del Tipo -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información del Tipo</h2>
                    
                    <div class="bg-purple-50 rounded-lg p-4 mb-4">
                        <h3 class="font-semibold text-purple-900">{{ $room->roomType->name }}</h3>
                        <p class="text-purple-700 text-sm mt-1">{{ $room->roomType->description }}</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Hotel:</span>
                            <span class="font-medium">{{ $room->roomType->hotel->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Capacidad:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-users mr-1"></i>{{ $room->roomType->capacity }} personas
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Precio base:</span>
                            <span class="text-xl font-bold text-green-600">${{ number_format($room->roomType->base_price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">0</div>
                            <div class="text-sm text-blue-800">Reservas</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">0</div>
                            <div class="text-sm text-green-800">Total noches</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection