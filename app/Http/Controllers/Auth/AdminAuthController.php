<?php

// app/Http/Controllers/Auth/AdminAuthController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Mostrar formulario de login de admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Procesar el login de admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar primero
        if (Auth::attempt($credentials)) {
            // Verificar si el usuario autenticado es admin
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }

            // Si no es admin, cerrar sesión y devolver error
            Auth::logout();
            return back()->withErrors([
                'email' => 'No tienes permisos de administrador.',
            ])->onlyInput('email');
        }

        // Si las credenciales son incorrectas
        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->onlyInput('email');
    }


    /**
     * Cerrar sesión de admin
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
