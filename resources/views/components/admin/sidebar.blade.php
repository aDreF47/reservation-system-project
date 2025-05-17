<div class="sidebar bg-white shadow-md w-64 min-h-screen flex flex-col justify-between">
    <div>
        <div class="header text-3xl font-bold text-center py-6 border-b border-gray-200">
            <a href="{{ route('home') }}" class="block hover:text-blue-600 transition">
                TripNJoy
            </a>
        </div>

        <nav class="mt-6 flex flex-col space-y-1 px-4">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-blue-200 text-blue-800' : 'text-gray-700' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.reservations') }}"
                class="block px-4 py-3 rounded-lg font-semibold  hover:bg-blue-100 transition
                {{ request()->routeIs('admin.reservations') ? 'bg-blue-200 text-blue-800' : 'text-gray-700' }}">
                Gestión Reservas
            </a>
            <a href="#"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition text-gray-700">
                Gestión Hoteles
            </a>
            <a href="#"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition text-gray-700">
                Gestión Types
            </a>
            <a href="#"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition text-gray-700">
                Gestión Dormitorios
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition
                {{ request()->routeIs('admin.users.*') ? 'bg-blue-200 text-blue-800' : 'text-gray-700' }}">
                Gestión Usuarios
            </a>
            <a href="#"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition text-gray-700">
                Gestión Reviews
            </a>
            <a href="{{ route('admin.administrators.index') }}"
                class="block px-4 py-3 rounded-lg font-semibold hover:bg-blue-100 transition
                {{ request()->routeIs('admin.administrators.*') ? 'bg-blue-200 text-blue-800' : 'text-gray-700' }}">
                Gestión Administrador
            </a>
        </nav>
    </div>

    <div class="footer border-t border-gray-200 p-4 flex items-center justify-between">
        <a href="{{ route('admin.profile') }}" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900">
            <!-- Icono usuario -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-semibold">{{ auth()->user()->name }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}"
            onsubmit="return confirm('¿Seguro que deseas cerrar sesión?');">
            @csrf
            <button type="submit" class="text-gray-800 font-medium px-4 py-2 rounded hover:bg-gray-100 transition">
                Salir
            </button>
        </form>

    </div>

</div>
