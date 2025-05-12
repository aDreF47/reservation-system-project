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

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'cliente')->get();
        $rooms = Room::where('available', true)->get();

        // Crear 50 reservas de ejemplo
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $room = $rooms->random();

            $checkIn = now()->addDays(rand(-30, 60)); // Entre 30 días atrás y 60 días adelante
            $nights = rand(1, 7); // Entre 1 y 7 noches
            $checkOut = clone $checkIn;
            $checkOut->addDays($nights);

            $status = match(true) {
                $checkIn->isPast() => 'confirmed',
                $checkIn->isFuture() => ['pending', 'confirmed'][rand(0, 1)],
                default => 'pending'
            };

            $paymentStatus = match($status) {
                'confirmed' => 'paid',
                'cancelled' => 'refunded',
                default => 'pending'
            };

            $reservation = Reservation::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guests' => rand(1, $room->capacity),
                'total_price' => $room->price_per_night * $nights,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'special_requests' => rand(0, 100) > 70 ? 'Habitación en piso alto, cama extra' : null,
            ]);

            // Si el check-in ya pasó, la habitación debería estar no disponible
            if ($checkIn->isPast() && $checkOut->isFuture()) {
                $room->update(['available' => false]);
            }
        }
    }
}
