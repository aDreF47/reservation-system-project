@extends('layouts.app')

@section('title', 'Mi Panel')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mi Panel</h1>
        <p class="text-gray-600 mt-2">Bienvenido, {{ auth()->user()->name }}</p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Reservaciones</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_reservations'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Reservaciones Activas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_reservations'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Completadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_reservations'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_reservations'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Próximas Reservaciones -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Próximas Reservaciones</h3>
            </div>
            <div class="p-6">
                @forelse($upcomingReservations as $reservation)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $reservation->room->roomType->hotel->name }}</h4>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $reservation->room->roomType->name }} - Habitación {{ $reservation->room->room_number }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $reservation->check_in->format('d/m/Y') }} - {{ $reservation->check_out->format('d/m/Y') }}
                        </p>
                        <p class="text-sm font-medium text-gray-900 mt-2">S/ {{ number_format($reservation->total_price, 2) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No tienes reservaciones próximas</p>
                @endforelse

                @if($upcomingReservations->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('client.reservations') }}" class="text-blue-600 hover:text-blue-800">
                            Ver todas las reservaciones
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reservaciones Recientes -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Reservaciones Recientes</h3>
            </div>
            <div class="p-6">
                @forelse($recentReservations as $reservation)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $reservation->room->roomType->hotel->name }}</h4>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $reservation->room->roomType->name }} - Habitación {{ $reservation->room->room_number }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $reservation->check_in->format('d/m/Y') }} - {{ $reservation->check_out->format('d/m/Y') }}
                        </p>
                        <p class="text-sm font-medium text-gray-900 mt-2">S/ {{ number_format($reservation->total_price, 2) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No tienes reservaciones recientes</p>
                @endforelse

                @if($recentReservations->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('client.reservations') }}" class="text-blue-600 hover:text-blue-800">
                            Ver historial completo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('hotels.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-search text-blue-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Buscar Hoteles</p>
                    <p class="text-sm text-gray-600">Encuentra tu próximo destino</p>
                </div>
            </a>
            <a href="{{ route('client.reservations') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-calendar-alt text-green-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Mis Reservaciones</p>
                    <p class="text-sm text-gray-600">Gestiona tus reservas</p>
                </div>
            </a>
            <a href="{{ route('client.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-user text-purple-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Mi Perfil</p>
                    <p class="text-sm text-gray-600">Actualiza tu información</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
