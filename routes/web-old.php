<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Ruta principal
Route::get('/', fn() => view('home'))->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Registro
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [RegisterController::class, 'register']); // Esta ruta falta

    // Recuperación de contraseña
    Route::get('/request', fn() => view('auth.password.request'))->name('request_pass');

    // Páginas legales
    Route::get('/terminos', fn() => view('auth.terms'))->name('terms');
    Route::get('/privacy', fn() => view('auth.privacy'))->name('privacy');
});

// Rutas protegidas para administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
    // Aquí irán más rutas de administrador
});

// Rutas protegidas para clientes
Route::middleware(['auth', 'cliente'])->prefix('client')->group(function () {
    Route::get('/', fn() => view('client.dashboard'))->name('client.dashboard');
    // Aquí irán más rutas de cliente
});

// Rutas públicas de servicios
Route::get('/hotels', fn() => view('public.hotels.index'))->name('hotels.index');

// Ruta de logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
