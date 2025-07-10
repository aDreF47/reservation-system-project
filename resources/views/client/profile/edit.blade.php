@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mi Perfil</h1>
        <p class="text-gray-600 mt-2">Actualiza tu información personal</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información Personal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Información Personal</h2>

                <form action="{{ route('client.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="tel"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <input type="text"
                                   id="address"
                                   name="address"
                                   value="{{ old('address', $user->address) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Actualizar Información
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Información de la Cuenta -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Cuenta</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Miembro desde</p>
                        <p class="font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email verificado</p>
                        <p class="font-medium">
                            @if($user->email_verified_at)
                                <span class="text-green-600">Verificado</span>
                            @else
                                <span class="text-red-600">No verificado</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Última actualización</p>
                        <p class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total de reservaciones</span>
                        <span class="font-medium">{{ $user->reservations()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Reservaciones activas</span>
                        <span class="font-medium">{{ $user->reservations()->where('status', '!=', 'cancelled')->where('check_out', '>', now())->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Comentarios</span>
                        <span class="font-medium">{{ $user->reviews()->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                <div class="space-y-3">
                    <a href="{{ route('client.reservations') }}"
                       class="block w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">
                        Ver Mis Reservaciones
                    </a>
                    <a href="{{ route('client.dashboard') }}"
                       class="block w-full bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 text-center">
                        Ir al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cambiar Contraseña -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Cambiar Contraseña</h2>

        <form action="{{ route('client.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700">
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
