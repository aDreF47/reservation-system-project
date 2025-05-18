<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        // Obtener las reservas que tienen estado de pago "paid"
        $paidReservations = DB::table('reservations')
            ->where('payment_status', 'paid')
            ->get();

        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer'];
        $payments = [];

        foreach ($paidReservations as $reservation) {
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $paidAt = Carbon::parse($reservation->created_at)->addHours(rand(1, 48));

            $payments[] = [
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price,
                'payment_method' => $paymentMethod,
                'transaction_id' => strtoupper(substr(md5(rand()), 0, 15)),
                'status' => 'completed',
                'paid_at' => $paidAt,
                'created_at' => $paidAt,
                'updated_at' => $paidAt
            ];
        }

        // También crear algunos pagos pendientes
        $pendingReservations = DB::table('reservations')
            ->where('payment_status', 'pending')
            ->get();

        foreach ($pendingReservations as $reservation) {
            // Solo crear pagos pendientes para algunas reservas (50% de probabilidad)
            if (rand(0, 1) == 1) {
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

                $payments[] = [
                    'reservation_id' => $reservation->id,
                    'amount' => $reservation->total_price,
                    'payment_method' => $paymentMethod,
                    'transaction_id' => null,
                    'status' => 'pending',
                    'paid_at' => null,
                    'created_at' => Carbon::parse($reservation->created_at),
                    'updated_at' => Carbon::parse($reservation->created_at)
                ];
            }
        }

        DB::table('payments')->insert($payments);
    }
}
