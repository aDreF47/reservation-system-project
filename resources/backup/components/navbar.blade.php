<nav class="luxury-gradient text-white shadow-md" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo y nombre del sitio -->
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-3">
                    <!-- Usamos la etiqueta <img> para mostrar el logo -->
                    <img src="{{ asset('images/logo.png') }}" alt="BookEase Logo" class="h-27 w-27">
                    <span class="text-3xl font-semibold tracking-wider">TripNJoy</span>
                </a>
            </div>
            <!-- Navegación escritorio -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/"
                    class="font-medium hover:text-gold-200 transition duration-300 border-b-2 border-transparent hover:border-gold-200 pb-1">Inicio</a>
                <a href="/hotels"
                    class="font-medium hover:text-gold-200 transition duration-300 border-b-2 border-transparent hover:border-gold-200 pb-1">Hoteles</a>
                <a href="/restaurants"
                    class="font-medium hover:text-gold-200 transition duration-300 border-b-2 border-transparent hover:border-gold-200 pb-1">Restaurantes</a>
                <a href="/venues"
                    class="font-medium hover:text-gold-200 transition duration-300 border-b-2 border-transparent hover:border-gold-200 pb-1">Locales
                    para Eventos</a>
                <a href="/about"
                    class="font-medium hover:text-gold-200 transition duration-300 border-b-2 border-transparent hover:border-gold-200 pb-1">Acerca
                    de</a>
            </div>

            <!-- Botones de autenticación -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 border border-white hover:bg-white hover:text-blue-900 rounded-md transition duration-300">
                        Iniciar Sesión</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-white text-blue-900 hover:bg-opacity-90 rounded-md transition duration-300">
                        Registrarse</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-white focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            @if (Auth::user()->isAdmin())
                                <a href="/admin/dashboard" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Panel
                                    Admin</a>
                            @else
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Mi
                                    Panel</a>
                            @endif

                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Mi Perfil</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Menú móvil -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú móvil expandido -->
    <div x-show="open" class="md:hidden bg-blue-800 pb-6 pt-4">
        <div class="px-4 space-y-3">
            <a href="/" class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Inicio</a>
            <a href="/hotels" class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Hoteles</a>
            <a href="/restaurants"
                class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Restaurantes</a>
            <a href="/venues" class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Locales para
                Eventos</a>
            <a href="/about" class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Acerca de</a>

            @guest
                <div class="pt-4 mt-4 border-t border-blue-700">
                    <a href="{{ route('login') }}"
                        class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Iniciar Sesión</a>
                    <a href="{{ route('register') }}"
                        class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Registrarse</a>
                </div>
            @else
                <div class="pt-4 mt-4 border-t border-blue-700">
                    <span class="block text-gray-300 px-3 pb-2">{{ Auth::user()->name }}</span>

                    @if (Auth::user()->isAdmin())
                        <a href="/admin/dashboard"
                            class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Panel Admin</a>
                    @else
                        <a href="/client/dashboard"
                            class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Mi Panel</a>
                    @endif

                    <a href="#" class="block text-white py-2 font-medium hover:bg-blue-700 rounded px-3">Mi Perfil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left text-white py-2 font-medium hover:bg-blue-700 rounded px-3">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>
