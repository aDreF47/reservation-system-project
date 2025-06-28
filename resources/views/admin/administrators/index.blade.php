@extends('layouts.admin')

@section('title', 'Administradores')

@section('content')

<div x-data="adminList()" class="space-y-4">

    <h1 class="text-2xl font-bold mb-6">Lista de Administradores</h1>

    <a href="{{ route('admin.administrators.create') }}"
       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-4">
       + Nuevo Administrador
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 border-b border-gray-200">Nombre</th>
                    <th class="py-3 px-6 border-b border-gray-200">Email</th>
                    <th class="py-3 px-6 border-b border-gray-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($admins as $admin)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $admin->name }}</td>
                    <td class="py-3 px-6">{{ $admin->email }}</td>
                    <td class="py-3 px-6 space-x-2">
                        <button @click="openViewModal(@js($admin))"
                                class="text-blue-600 hover:underline">Ver</button>
                        <a href="{{ route('admin.administrators.edit', $admin->id) }}"
                           class="text-green-600 hover:underline">Editar</a>
                        <button @click="openDeleteModal(@js($admin))"
                                class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Ver Administrador -->
    <div
        x-show="showViewModal"
        x-transition
        style="display: none;"
        class="fixed inset-0 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button @click="showViewModal = false"
                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-2xl font-semibold mb-4">Detalle del Administrador</h2>
            <p><strong>Nombre:</strong> <span x-text="selectedAdmin.name"></span></p>
            <p><strong>Email:</strong> <span x-text="selectedAdmin.email"></span></p>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div
        x-show="showDeleteModal"
        x-transition
        style="display: none;"
        class="fixed inset-0 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button @click="showDeleteModal = false"
                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-semibold mb-4 text-red-600">Confirmar Eliminación</h2>
            <p>¿Estás seguro de eliminar al administrador <strong x-text="selectedAdmin.name"></strong>?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button @click="showDeleteModal = false"
                        class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">Cancelar</button>

                <form :action="`/admin/administrators/${selectedAdmin.id}`" method="POST" x-ref="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function adminList() {
    return {
        showViewModal: false,
        showDeleteModal: false,
        selectedAdmin: null,

        openViewModal(admin) {
            this.selectedAdmin = admin;
            this.showViewModal = true;
        },

        openDeleteModal(admin) {
            this.selectedAdmin = admin;
            this.showDeleteModal = true;
        }
    }
}
</script>

@endsection
