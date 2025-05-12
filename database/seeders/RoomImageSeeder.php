<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelType;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class RoomImageSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $imageCount = rand(3, 6); // Entre 3 y 6 imágenes por habitación

            for ($i = 1; $i <= $imageCount; $i++) {
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => 'rooms/room-' . $room->id . '-' . $i . '.jpg',
                    'alt_text' => 'Vista ' . $i . ' de la habitación ' . $room->room_number,
                    'is_featured' => $i == 1, // Primera imagen es destacada
                    'display_order' => $i,
                ]);
            }
        }
    }
}
