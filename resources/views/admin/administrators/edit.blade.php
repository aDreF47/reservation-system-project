@extends('layouts.admin')

@section('title', 'Editar Administrador')

@section('content')
    <a href="{{ route('admin.administrators.index') }}" class="inline-block mb-6 text-blue-600 hover:underline">
        ← Volver
    </a>

    <h1 class="text-3xl font-semibold mb-6">Editar Administrador</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.administrators.update', $admin->id) }}" method="POST" class="max-w-md space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block mb-1 font-medium text-gray-700">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="password" class="block mb-1 font-medium text-gray-700">Nueva contraseña (opcional):</label>
            <input type="password" id="password" name="password"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Confirmar nueva contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Actualizar Administrador
        </button>
    </form>
@endsection
