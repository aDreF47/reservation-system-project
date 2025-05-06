<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', fn() => view('home'));
Route::get('/admin', fn() => view('admin.dashboard'));
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('/hotels', fn() => view('hotels.index'));

Route::get('/register', fn() => view('auth.register'))->name('register');
