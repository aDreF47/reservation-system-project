@extends('layouts.app')

@section('title', 'Detalle de Reservación')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalle de Reservación</h1>
                <p class="text-gray-600 mt-2">Reservación #{{ $reservation->id }}</p>
            </div>
            <a href="{{ route('client.reservations') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Volver a Mis Reservaciones
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información Principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $reservation->room->roomType->hotel->name }}</h2>
                    <span class="px-4 py-2 text-sm rounded-full
                        @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Información del Hotel</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Dirección:</span> {{ $reservation->room->roomType->hotel->address }}</p>
                            <p><span class="font-medium">Ciudad:</span> {{ $reservation->room->roomType->hotel->city }}</p>
                            <div class="flex items-center">
                                <span class="font-medium mr-2">Estrellas:</span>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $reservation->room->roomType->hotel->stars)
                                        <i class="fas fa-star text-yellow-500"></i>
                                    @else
                                        <i class="far fa-star text-yellow-500"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Información de la Habitación</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Tipo:</span> {{ $reservation->room->roomType->name }}</p>
                            <p><span class="font-medium">Número:</span> {{ $reservation->room->room_number }}</p>
                            <p><span class="font-medium">Capacidad:</span> {{ $reservation->room->roomType->capacity }} personas</p>
                            <p><span class="font-medium">Precio base:</span> S/ {{ number_format($reservation->room->roomType->base_price, 2) }} por noche</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de la Reservación -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Reservación</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Fecha de Check-in</p>
                        <p class="text-lg font-medium">{{ $reservation->check_in->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $reservation->check_in->format('l') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Fecha de Check-out</p>
                        <p class="text-lg font-medium">{{ $reservation->check_out->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $reservation->check_out->format('l') }}</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Número de Huéspedes</p>
                        <p class="text-lg font-medium">{{ $reservation->guest }} {{ $reservation->guest === 1 ? 'persona' : 'personas' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Noches</p>
                        <p class="text-lg font-medium">{{ $reservation->nights }} {{ $reservation->nights === 1 ? 'noche' : 'noches' }}</p>
                    </div>
                </div>

                @if($reservation->special_requests)
                    <div class="mt-6">
                        <p class="text-sm text-gray-600 mb-1">Solicitudes Especiales</p>
                        <p class="bg-gray-50 p-3 rounded">{{ $reservation->special_requests }}</p>
                    </div>
                @endif
            </div>

            <!-- Servicios de la Habitación -->
            @if($reservation->room->roomType->characteristics->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Servicios Incluidos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($reservation->room->roomType->characteristics as $characteristic)
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-sm">{{ $characteristic->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Resumen de Costos -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen de Costos</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>{{ $reservation->nights }} {{ $reservation->nights === 1 ? 'noche' : 'noches' }} × S/ {{ number_format($reservation->room->roomType->base_price, 2) }}</span>
                        <span>S/ {{ number_format($reservation->nights * $reservation->room->roomType->base_price, 2) }}</span>
                    </div>

                    <div class="border-t pt-3">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>S/ {{ number_format($reservation->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado de Pago -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado de Pago</h3>
                <div class="flex items-center">
                    <span class="px-3 py-1 text-sm rounded-full
                        @if($reservation->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($reservation->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($reservation->payment_status) }}
                    </span>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Adicional</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="font-medium">Reservado el:</span>
                        <p class="text-gray-600">{{ $reservation->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="font-medium">Última actualización:</span>
                        <p class="text-gray-600">{{ $reservation->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                <div class="space-y-3">
                    @if($reservation->canBeCancelled())
                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700"
                                    onclick="return confirm('¿Estás seguro de que quieres cancelar esta reservación?')">
                                Cancelar Reservación
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">
                            Esta reservación no puede ser cancelada.
                        </p>
                    @endif

                    <a href="{{ route('hotels.show', $reservation->room->roomType->hotel->id) }}"
                       class="block w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">
                        Ver Hotel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
