<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '999999999',
            'address' => 'Lima, Perú'
        ]);

        // Crear algunos usuarios clientes
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'cliente@ejemplo.com',
            'password' => Hash::make('cliente123'),
            'role' => 'cliente',
            'phone' => '987654321',
            'address' => 'Miraflores, Lima'
        ]);

        // Crear más clientes de prueba
        User::factory()->count(10)->create([
            'role' => 'cliente'
        ]);
    }
}
