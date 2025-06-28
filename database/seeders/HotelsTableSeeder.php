<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelsTableSeeder extends Seeder
{
    public function run()
    {
        $hotels = [
            [
                'name' => 'Hotel Miraflores',
                'address' => 'Av. Larco 345',
                'city' => 'Lima',
                'phone' => '5114567890',
                'email' => 'info@hotelmiraflores.com',
                'stars' => 4,
                'description' => 'Hermoso hotel ubicado en el corazón de Miraflores con vistas al océano Pacífico.',
                'main_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'active' => 1
            ],
            [
                'name' => 'Grand Hotel San Isidro',
                'address' => 'Calle Las Palmeras 123',
                'city' => 'Lima',
                'phone' => '5114123456',
                'email' => 'reservas@grandhotelsanisidro.com',
                'stars' => 5,
                'description' => 'Hotel de lujo con instalaciones de primer nivel en la zona financiera de Lima.',
                'main_image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'active' => 1
            ],
            [
                'name' => 'Hotel Barranco Arts',
                'address' => 'Jr. Unión 350',
                'city' => 'Lima',
                'phone' => '5112345678',
                'email' => 'hola@barrancoarts.com',
                'stars' => 3,
                'description' => 'Hotel boutique en el distrito bohemio de Barranco, rodeado de galerías y cafés.',
                'main_image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'active' => 1
            ],
            [
                'name' => 'Hotel Centro Histórico',
                'address' => 'Jr. De la Unión 432',
                'city' => 'Lima',
                'phone' => '5113456789',
                'email' => 'reservas@hotelcentro.com',
                'stars' => 3,
                'description' => 'Hotel con encanto colonial ubicado cerca de la Plaza de Armas de Lima.',
                'main_image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'active' => 1
            ],
            [
                'name' => 'Resort Paracas Bay',
                'address' => 'Playa El Chaco s/n',
                'city' => 'Paracas',
                'phone' => '5665432190',
                'email' => 'info@paracasbay.com',
                'stars' => 5,
                'description' => 'Resort de lujo frente al mar con acceso directo a la Bahía de Paracas.',
                'main_image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'active' => 1
            ]
        ];

        foreach ($hotels as $hotel) {
            DB::table('hotels')->insert(array_merge($hotel, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
