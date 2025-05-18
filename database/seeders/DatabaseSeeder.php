<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Desactivar restricciones de clave foránea
        Schema::disableForeignKeyConstraints();

        // Truncar todas las tablas para comenzar con datos limpios
        $this->truncateTables([
            'users',
            'password_reset_tokens',
            'sessions',
            'hotels',
            'characteristics',
            'room_types',
            'characteristic_types',
            'rooms',
            'img_room_types',
            'reservations',
            'payments',
            'reviews'
        ]);

        // Llamar a todos los seeders en orden
        $this->call([
            // Primero las tablas independientes
            UsersTableSeeder::class,
            HotelsTableSeeder::class,
            CharacteristicsTableSeeder::class,

            // Tablas que dependen de las anteriores
            RoomTypesTableSeeder::class,
            CharacteristicTypesTableSeeder::class,
            RoomsTableSeeder::class,
            ImgRoomTypesTableSeeder::class,

            // Tablas de transacciones
            ReservationsTableSeeder::class,
            PaymentsTableSeeder::class,
            ReviewsTableSeeder::class,
        ]);

        // Reactivar restricciones de clave foránea
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Trunca las tablas especificadas.
     *
     * @param array $tables
     * @return void
     */
    protected function truncateTables(array $tables): void
    {
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
