@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
    <a href="{{ route('admin.users.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver
    </a>

    <h1 class="text-3xl font-semibold mb-6">Editar usuario</h1>

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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium text-gray-700">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 font-medium text-gray-700">Nueva contraseña (opcional):</label>
            <input type="password" id="password" name="password"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Confirmar nueva contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        {{-- Campo para rol, solo si quieres permitir editar rol --}}
        <div class="mb-6">
            <label for="role" class="block mb-1 font-medium text-gray-700">Rol:</label>
            <select id="role" name="role" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="cliente" {{ old('role', $user->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                {{-- Agrega más roles si tienes --}}
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Actualizar Usuario
        </button>
    </form>
@endsection
