<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '123456789',
            'address' => 'Admin Address 123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Clientes
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'name' => 'Cliente ' . $i,
                'email' => 'cliente' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'phone' => '9' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'address' => 'Dirección Cliente ' . $i,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
