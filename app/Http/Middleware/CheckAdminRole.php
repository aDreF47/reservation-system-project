<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // No está autenticado
            return redirect()->route('admin.login');
        }

        if (Auth::user()->role !== 'admin') {
            // No tiene permiso
            return redirect('/');
        }

        return $next($request);
    }
}
