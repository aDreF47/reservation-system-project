<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin - @yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-raleway { font-family: 'Raleway', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-raleway">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col" x-data="{ open: true }">
            <!-- Logo/Brand -->
            <div class="p-6 text-center border-b border-gray-700">
                <h3 class="text-xl font-bold font-playfair">TripNJoy</h3>
                <p class="text-sm text-gray-400 mt-1">Panel de Administración</p>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 mt-6">
                <div class="px-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    
                    <!-- Hoteles -->
                    <a href="{{ route('admin.hotels.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.hotels*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-hotel w-5"></i>
                        <span class="ml-3">Hoteles</span>
                    </a>
                    
                    <!-- Tipos de Habitación -->
                    <a href="{{ route('admin.room-types.index') }}" 
                    class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.room-types*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-bed w-5"></i>
                        <span class="ml-3">Tipos de Habitación</span>
                    </a>
                    
                    <!-- Habitaciones -->
                    <a href="#" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.rooms*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-door-open w-5"></i>
                        <span class="ml-3">Habitaciones</span>
                    </a>
                    
                    <!-- Reservas -->
                    <a href="{{ route('admin.reservations') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.reservations*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-calendar-check w-5"></i>
                        <span class="ml-3">Reservas</span>
                    </a>
                    
                    <!-- Usuarios -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Usuarios</span>
                    </a>
                    
                    <!-- Reseñas -->
                    <a href="#" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.reviews*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-star w-5"></i>
                        <span class="ml-3">Reseñas</span>
                    </a>

                    <!-- Administradores -->
                    <a href="{{ route('admin.administrators.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.administrators*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-user-shield w-5"></i>
                        <span class="ml-3">Administradores</span>
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button class="lg:hidden text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-user-circle text-xl mr-2"></i>
                            <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            
                            <a href="{{ route('admin.profile') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user w-4 mr-3"></i>
                                Perfil
                            </a>
                            
                            <hr class="my-1">
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt w-4 mr-3"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-info-circle mr-3"></i>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts adicionales -->
    @yield('scripts')
</body>
</html>