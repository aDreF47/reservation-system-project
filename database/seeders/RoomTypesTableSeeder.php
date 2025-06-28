<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypesTableSeeder extends Seeder
{
    public function run()
    {
        $roomTypes = [
            // Hotel Miraflores (id: 1)
            [
                'hotel_id' => 1,
                'name' => 'Habitación Estándar',
                'description' => 'Habitación confortable con todas las comodidades básicas.',
                'capacity' => 2,
                'base_price' => 150.00,
                'main_image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'hotel_id' => 1,
                'name' => 'Habitación Superior',
                'description' => 'Amplia habitación con vistas a la ciudad y amenidades premium.',
                'capacity' => 2,
                'base_price' => 200.00,
                'main_image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'hotel_id' => 1,
                'name' => 'Suite Ejecutiva',
                'description' => 'Suite espaciosa con sala de estar separada y vistas al océano.',
                'capacity' => 3,
                'base_price' => 300.00,
                'main_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Grand Hotel San Isidro (id: 2)
            [
                'hotel_id' => 2,
                'name' => 'Habitación Deluxe',
                'description' => 'Elegante habitación con decoración de lujo y vistas al jardín.',
                'capacity' => 2,
                'base_price' => 250.00,
                'main_image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'hotel_id' => 2,
                'name' => 'Suite Premium',
                'description' => 'Suite de lujo con sala de estar, comedor y baño con jacuzzi.',
                'capacity' => 2,
                'base_price' => 400.00,
                'main_image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'hotel_id' => 2,
                'name' => 'Suite Presidencial',
                'description' => 'La suite más exclusiva del hotel con servicio de mayordomo 24/7.',
                'capacity' => 4,
                'base_price' => 800.00,
                'main_image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Continúa con los otros hoteles...
            [
                'hotel_id' => 3,
                'name' => 'Habitación Artística',
                'description' => 'Habitación con decoración única creada por artistas locales.',
                'capacity' => 2,
                'base_price' => 180.00,
                'main_image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            [
                'hotel_id' => 4,
                'name' => 'Habitación Colonial',
                'description' => 'Habitación con estilo colonial y muebles de época.',
                'capacity' => 2,
                'base_price' => 160.00,
                'main_image' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            [
                'hotel_id' => 5,
                'name' => 'Bungalow Frente al Mar',
                'description' => 'Bungalow privado con acceso directo a la playa.',
                'capacity' => 3,
                'base_price' => 450.00,
                'main_image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ]
        ];

        foreach ($roomTypes as $roomType) {
            DB::table('room_types')->insert(array_merge($roomType, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
