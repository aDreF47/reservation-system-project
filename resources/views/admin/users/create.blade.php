@extends('layouts.admin')

@section('title', 'Crear Usuario Cliente')

@section('content')
    <a href="{{ route('admin.users.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver
    </a>

    <h1 class="text-3xl font-semibold mb-6">Crear usuario cliente</h1>

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

    <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-md">
        @csrf

        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium text-gray-700">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 font-medium text-gray-700">Contraseña:</label>
            <input type="password" id="password" name="password" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Confirmar contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        {{-- Campo oculto para asignar rol cliente --}}
        <input type="hidden" name="role" value="cliente" />

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Crear Usuario
        </button>
    </form>
@endsection
