@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido de nuevo</h1>
        <p class="text-gray-600">Por favor ingresa tus datos para continuar</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <!-- Campo de correo electrónico -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required autofocus>
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de contraseña -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required>
            @error('password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Parte inferior con opciones adicionales -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Recordar por 30 días</label>
            </div>
            <a href="{{ route('request_pass') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <!-- Botón de submit -->
        <button type="submit"
            class="w-full py-3 px-4 bg-indigo-700 hover:bg-indigo-800 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
            Iniciar sesión
        </button>

        <!-- Separador -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">O continúa con</span>
            </div>
        </div>

        <!-- Botón de Google -->
        <a {{-- href="{{ route('login.google') }}"  --}}
            class="flex justify-center items-center w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.794-1.661-4.181-2.673-6.735-2.673-5.523 0-10.005 4.482-10.005 10.005s4.482 10.005 10.005 10.005c8.396 0 10.005-7.142 10.005-10.005 0-0.787-0.107-1.392-0.107-1.392h-9.898z" />
            </svg>
            Iniciar sesión con Google
        </a>

        <!-- Link para registrarse -->
        <p class="text-center text-sm text-gray-600 mt-6">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:text-indigo-800">
                Regístrate
            </a>
        </p>
    </form>
@endsection
