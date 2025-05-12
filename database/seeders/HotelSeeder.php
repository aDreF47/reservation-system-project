<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Hotel Marriott Lima',
                'address' => 'Av. La Mar 2450, Miraflores',
                'city' => 'Lima',
                'phone' => '01-2157000',
                'email' => 'reservas@marriottlima.com',
                'stars' => 5,
                'description' => 'Hotel de lujo frente al océano Pacífico con vistas espectaculares. Cuenta con spa, gimnasio y restaurante gourmet.',
                'main_image' => json_encode(['marriott-main.jpg']),
                'active' => true,
            ],
            [
                'name' => 'Hotel Hilton Miraflores',
                'address' => 'Av. La Paz 1099, Miraflores',
                'city' => 'Lima',
                'phone' => '01-7207000',
                'email' => 'info@hiltonlima.com',
                'stars' => 5,
                'description' => 'Hotel ejecutivo en el corazón de Miraflores. Ideal para viajes de negocios y placer.',
                'main_image' => json_encode(['hilton-main.jpg']),
                'active' => true,
            ],
            [
                'name' => 'Hotel Costa del Sol',
                'address' => 'Calle Los Eucaliptos 550, San Isidro',
                'city' => 'Lima',
                'phone' => '01-5055000',
                'email' => 'reservas@costadelsol.pe',
                'stars' => 4,
                'description' => 'Hotel boutique con servicio personalizado. Ubicado en el distrito financiero de San Isidro.',
                'main_image' => json_encode(['costadelsol-main.jpg']),
                'active' => true,
            ],
            [
                'name' => 'Hotel Plaza Mayor',
                'address' => 'Jr. de la Unión 218, Centro Histórico',
                'city' => 'Lima',
                'phone' => '01-4284600',
                'email' => 'contacto@plazamayor.pe',
                'stars' => 3,
                'description' => 'Hotel tradicional en el centro histórico de Lima. Cerca de los principales atractivos turísticos.',
                'main_image' => json_encode(['plazamayor-main.jpg']),
                'active' => true,
            ],
            [
                'name' => 'Hotel Los Delfines',
                'address' => 'Los Eucaliptos 555, San Isidro',
                'city' => 'Lima',
                'phone' => '01-2157000',
                'email' => 'reservas@losdelfineshotel.com',
                'stars' => 5,
                'description' => 'Resort urbano con piscina, spa y centro de convenciones. Ideal para vacaciones y eventos corporativos.',
                'main_image' => json_encode(['delfines-main.jpg']),
                'active' => true,
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }

        // Crear 10 registros de hoteles clientes
        Hotel::factory()->count(30)->create(); // Utilizando Factory si deseas generar muchos registros aleatorios.
    }
}
