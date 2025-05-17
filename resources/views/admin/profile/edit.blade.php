@extends('layouts.admin')

@section('title', 'Editar Perfil')

@section('content')
<a href="{{ route('admin.dashboard') }}" class="inline-block mb-6 text-blue-600 hover:underline">
    ← Volver al Dashboard
</a>

<h1 class="text-3xl font-semibold mb-6">Editar Perfil</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" class="max-w-md space-y-6">
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

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
        Actualizar Perfil
    </button>
</form>
@endsection
