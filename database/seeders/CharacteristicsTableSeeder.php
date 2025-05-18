<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacteristicsTableSeeder extends Seeder
{
    public function run()
    {
        $characteristics = [
            ['name' => 'Wi-Fi gratis', 'description' => 'Conexión a internet de alta velocidad sin costo'],
            ['name' => 'Aire acondicionado', 'description' => 'Sistema de climatización controlable'],
            ['name' => 'TV de pantalla plana', 'description' => 'Televisor LED de alta definición'],
            ['name' => 'Minibar', 'description' => 'Refrigerador pequeño con bebidas y snacks'],
            ['name' => 'Caja fuerte', 'description' => 'Caja de seguridad para objetos de valor'],
            ['name' => 'Baño privado', 'description' => 'Baño completo con ducha y/o bañera'],
            ['name' => 'Vista al mar', 'description' => 'Vistas panorámicas al océano'],
            ['name' => 'Balcón', 'description' => 'Espacio al aire libre privado'],
            ['name' => 'Servicio a la habitación', 'description' => 'Servicio de comidas a la habitación'],
            ['name' => 'Acceso a piscina', 'description' => 'Acceso a piscina del hotel'],
            ['name' => 'Desayuno incluido', 'description' => 'Desayuno buffet incluido en la tarifa'],
            ['name' => 'Estacionamiento gratuito', 'description' => 'Estacionamiento sin costo adicional'],
            ['name' => 'Gimnasio', 'description' => 'Acceso a gimnasio equipado'],
            ['name' => 'Cama king size', 'description' => 'Cama extra grande'],
            ['name' => 'Camas individuales', 'description' => 'Habitación con camas separadas'],
        ];

        foreach ($characteristics as $characteristic) {
            DB::table('characteristics')->insert(array_merge($characteristic, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
