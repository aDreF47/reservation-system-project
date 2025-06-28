@extends('layouts.admin')

@section('title', 'Lista de Usuarios')

@section('content')

    <div x-data="{ showModal: false, selectedUser: null }">

        <h1 class="text-2xl font-bold mb-4">Gestión de Usuarios</h1>

        <div class="mb-6">
            <a href="{{ route('admin.users.create') }}"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Nuevo Usuario
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 border-b border-gray-200">Nombre</th>
                        <th class="py-3 px-6 border-b border-gray-200">Correo Electrónico</th>
                        <th class="py-3 px-6 border-b border-gray-200">Rol</th>
                        <th class="py-3 px-6 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($users as $user)
                        @if ($user->role !== 'admin')
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ $user->name }}</td>
                                <td class="py-3 px-6">{{ $user->email }}</td>
                                <td class="py-3 px-6 capitalize">{{ $user->role }}</td>
                                <td class="py-3 px-6 space-x-2">
                                    <button @click="selectedUser = @js($user); showModal = true"
                                        class="text-blue-600 hover:underline">
                                        Ver
                                    </button>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="text-green-600 hover:underline">Editar</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-transition style="display: none;"
            class="fixed inset-0 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
                <button @click="showModal = false"
                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
                <h2 class="text-2xl font-semibold mb-4">Detalle del Usuario</h2>
                <p><strong>Nombre:</strong> <span x-text="selectedUser ? selectedUser.name : ''"></span></p>
                <p><strong>Email:</strong> <span x-text="selectedUser ? selectedUser.email : ''"></span></p>
                <p><strong>Rol:</strong> <span x-text="selectedUser ? selectedUser.role : ''"></span></p>
            </div>
        </div>


    </div>

@endsection
