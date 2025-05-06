@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Campo de usuario -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de contraseña -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Recordar sesión -->
        <div class="form-check">
            <input type="checkbox" id="remember" name="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Recordar sesión</label>
        </div>

        <!-- Botón de submit -->
        <button type="submit" class="btn btn-primary mt-3">Iniciar Sesión</button>

        <!-- Enlace para recuperar contraseña -->
        <div class="mt-2">
            {{-- <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a> --}}
        </div>
    </form>
@endsection
