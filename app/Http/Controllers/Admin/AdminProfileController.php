<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
{
    /** @var User $admin */
    $admin = Auth::user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:users,email,{$admin->id}",
    ]);

    $admin->update($validated);

    return redirect()->route('admin.profile')->with('success', 'Perfil actualizado correctamente.');
}

    public function showPasswordForm()
    {
        return view('admin.profile.password');
    }

    public function updatePassword(Request $request)
{
    /** @var User $admin */
    $admin = Auth::user();

    $validated = $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    if (!Hash::check($validated['current_password'], $admin->password)) {
        return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
    }

    $admin->password = Hash::make($validated['password']);
    $admin->save();

    return redirect()->route('admin.profile')->with('success', 'Contraseña actualizada correctamente.');
}

}
