<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpiar tablas en orden inverso de dependencias
        DB::table('reviews')->truncate();
        DB::table('payments')->truncate();
        DB::table('reservations')->truncate();
        DB::table('room_images')->truncate();
        DB::table('rooms')->truncate();
        DB::table('hotel_types')->truncate();
        DB::table('hotels')->truncate();
        DB::table('users')->truncate();


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ejecutar seeders en orden correcto
        $this->call([
            UserSeeder::class,
            HotelSeeder::class,
            HotelTypeSeeder::class,
            RoomSeeder::class,
            RoomImageSeeder::class,
            ReservationSeeder::class,
            PaymentSeeder::class,
            ReviewSeeder::class,
        ]);

        $this->command->info('Seeders ejecutados correctamente!');
    }
}

