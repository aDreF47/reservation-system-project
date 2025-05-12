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

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = Reservation::whereIn('payment_status', ['paid', 'refunded'])->get();

        foreach ($reservations as $reservation) {
            Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price,
                'payment_method' => ['Tarjeta de crédito', 'PayPal', 'Transferencia bancaria'][rand(0, 2)],
                'transaction_id' => 'TRX' . strtoupper(uniqid()),
                'status' => $reservation->payment_status == 'paid' ? 'completed' : 'failed',
                'paid_at' => $reservation->payment_status == 'paid' ? $reservation->created_at->addMinutes(rand(5, 30)) : null,
            ]);
        }
    }
}

