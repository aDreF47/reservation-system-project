@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Crear una cuenta</h1>
        <p class="text-gray-600">Únete a nosotros y ten las reservas al instante</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <!-- Campo de nombre -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required autofocus>
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de correo electrónico -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required>
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de teléfono -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono (opcional)</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('phone')
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

        <!-- Campo de confirmación de contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar
                contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required>
        </div>

        <!-- Términos y condiciones -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input type="checkbox" id="terms" name="terms"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-gray-700">
                    Acepto los <a href="https://bim.pavcowavin.com.pe/wp-content/uploads/2023/10/Terminos-y-condiciones.pdf" class="text-indigo-600 hover:text-indigo-800">términos y
                        condiciones</a> y la <a href="{{ route('privacy') }}"
                        class="text-indigo-600 hover:text-indigo-800">política de privacidad</a>
                </label>
                @error('terms')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Botón de submit -->
        <button type="submit"
            class="w-full py-3 px-4 bg-indigo-700 hover:bg-indigo-800 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 mt-6">
            Crear cuenta
        </button>

        <!-- Separador -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">O regístrate con</span>
            </div>
        </div>

        <!-- Botón de Google -->
        <a {{-- href="{{ route('register.google') }}"  --}}
            class="flex justify-center items-center w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.794-1.661-4.181-2.673-6.735-2.673-5.523 0-10.005 4.482-10.005 10.005s4.482 10.005 10.005 10.005c8.396 0 10.005-7.142 10.005-10.005 0-0.787-0.107-1.392-0.107-1.392h-9.898z" />
            </svg>
            Registrarse con Google
        </a>

        <!-- Link para iniciar sesión -->
        <p class="text-center text-sm text-gray-600 mt-6">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:text-indigo-800">
                Iniciar sesión
            </a>
        </p>
    </form>
@endsection
