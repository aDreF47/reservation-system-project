<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelType;


class HotelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = Hotel::all();

        $types = [
            [
                'name' => 'Suite Presidencial',
                'description' => 'La habitación más lujosa del hotel. Vista panorámica, sala de estar, comedor y jacuzzi privado.',
                'features' => 'Vista al mar, Jacuzzi, Sala de estar, Comedor, Minibar premium',
                'amenities' => 'WiFi gratis, Desayuno incluido, Servicio 24h, Transfer aeropuerto',
                'base_price' => 850.00,
            ],
            [
                'name' => 'Suite Junior',
                'description' => 'Amplia habitación con sala de estar integrada. Ideal para estadías largas.',
                'features' => 'Sala de estar, Escritorio, Vista a la ciudad, Minibar',
                'amenities' => 'WiFi gratis, Desayuno incluido, Servicio de habitación',
                'base_price' => 450.00,
            ],
            [
                'name' => 'Deluxe',
                'description' => 'Habitación espaciosa con todas las comodidades modernas.',
                'features' => 'King size bed, Balcón, Vista parcial al mar',
                'amenities' => 'WiFi gratis, Desayuno continental, Gimnasio',
                'base_price' => 280.00,
            ],
            [
                'name' => 'Estándar',
                'description' => 'Habitación confortable con todo lo necesario para una estadía placentera.',
                'features' => 'Queen size bed, Escritorio, TV LED',
                'amenities' => 'WiFi gratis, Desayuno básico',
                'base_price' => 150.00,
            ],
        ];

        foreach ($hotels as $hotel) {
            // Cada hotel tendrá tipos de habitación según sus estrellas
            if ($hotel->stars >= 5) {
                // Hoteles 5 estrellas tienen todos los tipos
                foreach ($types as $type) {
                    $type['hotel_id'] = $hotel->id;
                    HotelType::create($type);
                }
            } elseif ($hotel->stars == 4) {
                // Hoteles 4 estrellas no tienen Suite Presidencial
                foreach (array_slice($types, 1) as $type) {
                    $type['hotel_id'] = $hotel->id;
                    $type['base_price'] *= 0.8; // 20% más barato
                    HotelType::create($type);
                }
            } else {
                // Hoteles 3 estrellas solo tienen Estándar y Deluxe
                foreach (array_slice($types, 2) as $type) {
                    $type['hotel_id'] = $hotel->id;
                    $type['base_price'] *= 0.6; // 40% más barato
                    HotelType::create($type);
                }
            }
        }
    }
}
