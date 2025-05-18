<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        // Crear habitaciones para cada tipo
        $roomsData = [];

        // Para cada tipo de habitación
        for ($roomTypeId = 1; $roomTypeId <= 9; $roomTypeId++) {
            // Crear entre 3 y 10 habitaciones de cada tipo
            $numRooms = rand(3, 10);
            $floor = 1;

            for ($i = 1; $i <= $numRooms; $i++) {
                // Cada 4 habitaciones incrementamos el piso
                if ($i % 4 == 1 && $i > 1) {
                    $floor++;
                }

                $roomNumber = $floor . str_pad($i % 4 == 0 ? 4 : $i % 4, 2, '0', STR_PAD_LEFT);

                $roomsData[] = [
                    'room_type_id' => $roomTypeId,
                    'room_number' => $roomNumber,
                    'floor' => $floor,
                    'available' => rand(0, 1), // Algunas habitaciones disponibles, otras no
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('rooms')->insert($roomsData);
    }
}
