<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TypeRoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;

// Controladores del panel de administración
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminTypeController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Vista de hoteles públicos
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{hotel}/type-room/{idtype}', [TypeRoomController::class, 'show'])->name('hotels.type-room');

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN PARA CLIENTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Recuperación de contraseña
    Route::get('/password/reset', [AuthController::class, 'showPasswordResetForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendPasswordResetEmail'])->name('password.email');
});

// Logout (disponible para usuarios autenticados)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN PARA ADMINISTRADORES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

// Logout de admin
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS PARA CLIENTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:cliente'])->prefix('user')->group(function () {
    // Reservaciones del cliente
    Route::get('/reservation', [ReservationController::class, 'index'])->name('user.reservations');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('user.reservation.delete');

    // Perfil del cliente
    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS PARA ADMINISTRADORES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Gestión de Reservaciones
    Route::get('/reservation', [AdminReservationController::class, 'index'])->name('admin.reservations');
    Route::get('/reservation/{id}', [AdminReservationController::class, 'show'])->name('admin.reservation.show');
    Route::delete('/reservation/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservation.delete');

    // Gestión de Hoteles
    Route::get('/hotels', [AdminHotelController::class, 'index'])->name('admin.hotels');
    Route::get('/hotels/create', [AdminHotelController::class, 'create'])->name('admin.hotels.create');
    Route::post('/hotels', [AdminHotelController::class, 'store'])->name('admin.hotels.store');
    Route::get('/hotels/{id}', [AdminHotelController::class, 'show'])->name('admin.hotels.show');
    Route::get('/hotels/{id}/edit', [AdminHotelController::class, 'edit'])->name('admin.hotels.edit');
    Route::put('/hotels/{id}', [AdminHotelController::class, 'update'])->name('admin.hotels.update');
    Route::delete('/hotels/{id}', [AdminHotelController::class, 'destroy'])->name('admin.hotels.delete');

    // [... resto de rutas de admin ...]
});

/*
|--------------------------------------------------------------------------
| PÁGINAS LEGALES
|--------------------------------------------------------------------------
*/
Route::get('/terms', fn() => view('legal.terms'))->name('terms');
Route::get('/privacy', fn() => view('legal.privacy'))->name('privacy');
