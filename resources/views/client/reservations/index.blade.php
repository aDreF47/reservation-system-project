@extends('layouts.app')

@section('title', 'Mis Reservaciones')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mis Reservaciones</h1>
        <p class="text-gray-600 mt-2">Gestiona y revisa todas tus reservas</p>
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

    <!-- Pestañas de filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('client.reservations', ['status' => 'all']) }}"
                   class="py-4 px-6 text-sm font-medium border-b-2 {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Todas ({{ $counts['all'] }})
                </a>
                <a href="{{ route('client.reservations', ['status' => 'pending']) }}"
                   class="py-4 px-6 text-sm font-medium border-b-2 {{ $status === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pendientes ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('client.reservations', ['status' => 'confirmed']) }}"
                   class="py-4 px-6 text-sm font-medium border-b-2 {{ $status === 'confirmed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Confirmadas ({{ $counts['confirmed'] }})
                </a>
                <a href="{{ route('client.reservations', ['status' => 'cancelled']) }}"
                   class="py-4 px-6 text-sm font-medium border-b-2 {{ $status === 'cancelled' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Canceladas ({{ $counts['cancelled'] }})
                </a>
            </nav>
        </div>
    </div>

    <!-- Lista de reservaciones -->
    <div class="bg-white rounded-lg shadow">
        @forelse($reservations as $reservation)
            <div class="p-6 border-b border-gray-200 last:border-b-0">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 mr-3">
                                {{ $reservation->room->roomType->hotel->name }}
                            </h3>
                            <span class="px-3 py-1 text-sm rounded-full
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Habitación</p>
                                <p class="font-medium">{{ $reservation->room->roomType->name }} - Habitación {{ $reservation->room->room_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Huéspedes</p>
                                <p class="font-medium">{{ $reservation->guest }} {{ $reservation->guest === 1 ? 'persona' : 'personas' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Fechas</p>
                                <p class="font-medium">
                                    {{ $reservation->check_in->format('d/m/Y') }} - {{ $reservation->check_out->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $reservation->nights }} {{ $reservation->nights === 1 ? 'noche' : 'noches' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="font-bold text-lg text-gray-900">S/ {{ number_format($reservation->total_price, 2) }}</p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500">
                            Reservado el {{ $reservation->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('client.reservations.show', $reservation->id) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
                            Ver Detalles
                        </a>

                        @if($reservation->canBeCancelled())
                            <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full"
                                        onclick="return confirm('¿Estás seguro de que quieres cancelar esta reservación?')">
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reservaciones</h3>
                <p class="text-gray-500 mb-6">
                    @if($status === 'all')
                        Aún no tienes reservaciones. ¡Haz tu primera reserva!
                    @else
                        No tienes reservaciones {{ $status === 'pending' ? 'pendientes' : ($status === 'confirmed' ? 'confirmadas' : 'canceladas') }}.
                    @endif
                </p>
                <a href="{{ route('hotels.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    Buscar Hoteles
                </a>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($reservations->hasPages())
        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection
