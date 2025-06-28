<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAdministratorController extends Controller
{
    // Mostrar lista de administradores
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.administrators.index', compact('admins'));
    }

    // Mostrar formulario para crear nuevo administrador
    public function create()
    {
        return view('admin.administrators.create');
    }

    // Guardar nuevo administrador
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'admin';

        User::create($validated);

        return redirect()->route('admin.administrators.index')->with('success', 'Administrador creado exitosamente.');
    }

    // Mostrar detalle de un administrador
    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.administrators.show', compact('admin'));
    }

    // Mostrar formulario para editar administrador
    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.administrators.edit', compact('admin'));
    }

    // Actualizar administrador
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.administrators.index')->with('success', 'Administrador actualizado correctamente.');
    }

    // Eliminar administrador
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.administrators.index')->with('success', 'Administrador eliminado correctamente.');
    }
}
