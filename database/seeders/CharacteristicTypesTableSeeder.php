<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacteristicTypesTableSeeder extends Seeder
{
    public function run()
    {
        $characteristicTypes = [
            // Habitación Estándar - Hotel Miraflores
            ['room_type_id' => 1, 'characteristic_id' => 1], // Wi-Fi
            ['room_type_id' => 1, 'characteristic_id' => 2], // Aire acondicionado
            ['room_type_id' => 1, 'characteristic_id' => 3], // TV
            ['room_type_id' => 1, 'characteristic_id' => 6], // Baño privado

            // Habitación Superior - Hotel Miraflores
            ['room_type_id' => 2, 'characteristic_id' => 1], // Wi-Fi
            ['room_type_id' => 2, 'characteristic_id' => 2], // Aire acondicionado
            ['room_type_id' => 2, 'characteristic_id' => 3], // TV
            ['room_type_id' => 2, 'characteristic_id' => 4], // Minibar
            ['room_type_id' => 2, 'characteristic_id' => 5], // Caja fuerte
            ['room_type_id' => 2, 'characteristic_id' => 6], // Baño privado
            ['room_type_id' => 2, 'characteristic_id' => 8], // Balcón

            // Suite Ejecutiva - Hotel Miraflores
            ['room_type_id' => 3, 'characteristic_id' => 1], // Wi-Fi
            ['room_type_id' => 3, 'characteristic_id' => 2], // Aire acondicionado
            ['room_type_id' => 3, 'characteristic_id' => 3], // TV
            ['room_type_id' => 3, 'characteristic_id' => 4], // Minibar
            ['room_type_id' => 3, 'characteristic_id' => 5], // Caja fuerte
            ['room_type_id' => 3, 'characteristic_id' => 6], // Baño privado
            ['room_type_id' => 3, 'characteristic_id' => 7], // Vista al mar
            ['room_type_id' => 3, 'characteristic_id' => 8], // Balcón
            ['room_type_id' => 3, 'characteristic_id' => 9], // Servicio a la habitación
            ['room_type_id' => 3, 'characteristic_id' => 14], // Cama king size

            // Y así sucesivamente para los demás tipos de habitación...
            // Solo agrego algunos ejemplos más

            // Habitación Deluxe - Grand Hotel San Isidro
            ['room_type_id' => 4, 'characteristic_id' => 1], // Wi-Fi
            ['room_type_id' => 4, 'characteristic_id' => 2], // Aire acondicionado
            ['room_type_id' => 4, 'characteristic_id' => 3], // TV
            ['room_type_id' => 4, 'characteristic_id' => 4], // Minibar
            ['room_type_id' => 4, 'characteristic_id' => 11], // Desayuno incluido

            // Bungalow Frente al Mar - Resort Paracas Bay
            ['room_type_id' => 9, 'characteristic_id' => 1], // Wi-Fi
            ['room_type_id' => 9, 'characteristic_id' => 2], // Aire acondicionado
            ['room_type_id' => 9, 'characteristic_id' => 3], // TV
            ['room_type_id' => 9, 'characteristic_id' => 4], // Minibar
            ['room_type_id' => 9, 'characteristic_id' => 5], // Caja fuerte
            ['room_type_id' => 9, 'characteristic_id' => 6], // Baño privado
            ['room_type_id' => 9, 'characteristic_id' => 7], // Vista al mar
            ['room_type_id' => 9, 'characteristic_id' => 9], // Servicio a la habitación
            ['room_type_id' => 9, 'characteristic_id' => 10], // Acceso a piscina
            ['room_type_id' => 9, 'characteristic_id' => 11], // Desayuno incluido
        ];

        foreach ($characteristicTypes as $characteristicType) {
            DB::table('characteristic_types')->insert($characteristicType);
        }
    }
}
