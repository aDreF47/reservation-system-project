<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelType;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $hotelTypes = HotelType::all();

        foreach ($hotelTypes as $hotelType) {
            $roomCount = match($hotelType->name) {
                'Suite Presidencial' => 1,  // Solo 1 suite presidencial
                'Suite Junior' => 3,        // 3 suites junior
                'Deluxe' => 10,            // 10 habitaciones deluxe
                'Estándar' => 20,          // 20 habitaciones estándar
                default => 5
            };

            $floorPrefix = match($hotelType->name) {
                'Suite Presidencial' => '10', // Último piso
                'Suite Junior' => '9',        // Penúltimo piso
                'Deluxe' => rand(5, 8),      // Pisos medios-altos
                'Estándar' => rand(2, 4),    // Pisos bajos-medios
                default => '1'
            };

            for ($i = 1; $i <= $roomCount; $i++) {
                $roomNumber = $floorPrefix . str_pad($i, 2, '0', STR_PAD_LEFT);

                Room::create([
                    'hotel_type_id' => $hotelType->id,
                    'room_number' => $roomNumber,
                    'capacity' => match($hotelType->name) {
                        'Suite Presidencial' => 4,
                        'Suite Junior' => 3,
                        'Deluxe' => 2,
                        'Estándar' => 2,
                        default => 2
                    },
                    'price_per_night' => $hotelType->base_price + rand(-20, 50),
                    'facilities' => json_encode(match($hotelType->name) {
                        'Suite Presidencial' => ['TV 65"', 'WiFi Premium', 'Minibar Premium', 'Jacuzzi', 'Sala de estar', 'Comedor', 'Cocina'],
                        'Suite Junior' => ['TV 55"', 'WiFi Premium', 'Minibar', 'Sala de estar', 'Cafetera Nespresso'],
                        'Deluxe' => ['TV 42"', 'WiFi', 'Minibar', 'Cafetera', 'Caja fuerte'],
                        'Estándar' => ['TV 32"', 'WiFi', 'Cafetera', 'Caja fuerte'],
                        default => ['TV', 'WiFi']
                    }),
                    'available' => rand(0, 100) > 10, // 90% disponibles
                ]);
            }
        }
    }
}
