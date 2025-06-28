<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

use App\Http\Middleware\CheckAdminRole;

// Controladores del panel de administración
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminTypeController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminAdministratorController;
use App\Http\Controllers\Admin\AdminProfileController;



/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('home'); // hecho

// Vista de hoteles públicos
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index'); // hecho // lista de hoteles
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show'); // dormitorios del hotel agrupados por tipo
Route::get('/room-types/{roomType}', [RoomTypeController::class, 'show'])->name('room_types.show');
Route::get('/reservations/create/{room}', [ReservationController::class, 'create'])->name('reservations.create');

Route::post('/reservations/store', [ReservationController::class, 'store'])
    ->middleware('auth')
    ->name('reservations.store');

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN PARA CLIENTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); //hecho
    Route::post('/login', [AuthController::class, 'login']); //hecho

    // Registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); //hecho
    Route::post('/register', [AuthController::class, 'register']); //hecho

    // Recuperación de contraseña
    Route::get('/password/reset', [AuthController::class, 'showPasswordResetForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendPasswordResetEmail'])->name('password.email');
});

// Logout (disponible para usuarios autenticados)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth'); //hecho

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN PARA ADMINISTRADORES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login'); //hecho prototipo
    Route::post('/admin', [AdminAuthController::class, 'login'])->name('admin.login.post'); //hecho si manda post
});

// Logout de admin
// Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');
// En routes/web.php
Route::post('/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');
// /*
// |--------------------------------------------------------------------------
// | RUTAS PROTEGIDAS PARA CLIENTES
// |--------------------------------------------------------------------------
// */
// Route::middleware(['auth', 'role:cliente'])->prefix('user')->group(function () {
//     // Reservaciones del cliente
//     Route::get('/reservation', [ReservationController::class, 'index'])->name('user.reservations');
//     Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('user.reservation.delete');

//     // Perfil del cliente
//     Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
// });

// /*
// |--------------------------------------------------------------------------
// | RUTAS PROTEGIDAS PARA ADMINISTRADORES
// |--------------------------------------------------------------------------
// */
Route::middleware(['auth', CheckAdminRole::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Gestión de Reservaciones
    Route::get('/reservation', [AdminReservationController::class, 'index'])->name('admin.reservations');
//     Route::get('/reservation/{id}', [AdminReservationController::class, 'show'])->name('admin.reservation.show');
//     Route::delete('/reservation/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservation.delete');

//     // Gestión de Hoteles
//     Route::get('/hotels', [AdminHotelController::class, 'index'])->name('admin.hotels');
//     Route::get('/hotels/create', [AdminHotelController::class, 'create'])->name('admin.hotels.create');
//     Route::post('/hotels', [AdminHotelController::class, 'store'])->name('admin.hotels.store');
//     Route::get('/hotels/{id}', [AdminHotelController::class, 'show'])->name('admin.hotels.show');
//     Route::get('/hotels/{id}/edit', [AdminHotelController::class, 'edit'])->name('admin.hotels.edit');
//     Route::put('/hotels/{id}', [AdminHotelController::class, 'update'])->name('admin.hotels.update');
//     Route::delete('/hotels/{id}', [AdminHotelController::class, 'destroy'])->name('admin.hotels.delete');

// Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');           // listar usuarios
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');  // formulario crear usuario
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');          // guardar nuevo usuario
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');       // mostrar usuario
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');  // formulario editar usuario
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');    // actualizar usuario
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');// eliminar usuario

    // administrator
    Route::get('/administrators', [AdminAdministratorController::class, 'index'])->name('admin.administrators.index');           // listar administrator
    Route::get('/administrators/create', [AdminAdministratorController::class, 'create'])->name('admin.administrators.create');  // formulario crear rol
    Route::post('/administrators', [AdminAdministratorController::class, 'store'])->name('admin.administrators.store');          // guardar nuevo rol
    Route::get('/administrators/{id}', [AdminAdministratorController::class, 'show'])->name('admin.administrators.show');       // mostrar rol
    Route::get('/administrators/{id}/edit', [AdminAdministratorController::class, 'edit'])->name('admin.administrators.edit');  // formulario editar rol
    Route::put('/administrators/{id}', [AdminAdministratorController::class, 'update'])->name('admin.administrators.update');    // actualizar rol
    Route::delete('/administrators/{id}', [AdminAdministratorController::class, 'destroy'])->name('admin.administrators.destroy');// eliminar rol

    // Mostrar formulario para ver o editar perfil
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Opcional: cambiar contraseña (si quieres separarlo)
    Route::get('/profile/password', [AdminProfileController::class, 'showPasswordForm'])->name('admin.profile.password');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password.update');
});

// /*
// |--------------------------------------------------------------------------
// | PÁGINAS LEGALES
// |--------------------------------------------------------------------------
// */
// Route::get('/terms', fn() => view('legal.terms'))->name('terms');
Route::get('/privacy', fn() => view('legal.privacy'))->name('privacy');
