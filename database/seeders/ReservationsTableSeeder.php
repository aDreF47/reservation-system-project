<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    public function run()
    {
        $reservations = [];
        $statuses = ['pending', 'confirmed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'refunded'];

        // Obtener IDs de habitaciones y usuarios disponibles
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $userIds = DB::table('users')->where('role', 'cliente')->pluck('id')->toArray();

        // Crear 30 reservaciones con datos aleatorios
        for ($i = 1; $i <= 30; $i++) {
            $checkIn = Carbon::now()->addDays(rand(-30, 60)); // Entre 30 días atrás y 60 días adelante
            $checkOut = (clone $checkIn)->addDays(rand(1, 7)); // Estancia de 1 a 7 días
            $userId = $userIds[array_rand($userIds)];
            $roomId = $roomIds[array_rand($roomIds)];
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];

            // Si la fecha de check-in ya pasó, la reserva debería estar confirmada o cancelada
            if ($checkIn->isPast() && $status == 'pending') {
                $status = 'confirmed';
            }

            // Si la reserva está cancelada, el pago debería estar pendiente o reembolsado
            if ($status == 'cancelled' && $paymentStatus == 'paid') {
                $paymentStatus = array_rand([0, 1]) ? 'pending' : 'refunded';
            }

            // Si la reserva está confirmada, el pago generalmente está pagado
            if ($status == 'confirmed') {
                $paymentStatus = rand(1, 10) <= 8 ? 'paid' : 'pending'; // 80% pagado, 20% pendiente
            }

            $reservations[] = [
                'user_id' => $userId,
                'room_id' => $roomId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guest' => rand(1, 4), // Entre 1 y 4 huéspedes
                'total_price' => rand(100, 1000) + (rand(0, 99) / 100), // Precio aleatorio entre 100 y 1000
                'status' => $status,
                'payment_status' => $paymentStatus,
                'created_at' => Carbon::now()->subDays(rand(1, 60)), // Creada hace entre 1 y 60 días
                'updated_at' => now(),
            ];
        }

        DB::table('reservations')->insert($reservations);
    }
}
