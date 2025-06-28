<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        // Obtener reservas confirmadas y completadas (check_out en el pasado)
        $completedReservations = DB::table('reservations')
            ->where('status', 'confirmed')
            ->where('check_out', '<', now())
            ->get();

        $reviews = [];
        $comments = [
            'Excelente servicio, habitaciones muy limpias.',
            'El personal fue muy amable, lo recomendaría.',
            'Buena relación calidad-precio, volveré a hospedarme aquí.',
            'Ubicación perfecta para disfrutar de la ciudad.',
            'Me encantó la vista desde la habitación.',
            'La habitación era más pequeña de lo que esperaba.',
            'El desayuno podría mejorar, pero en general una buena experiencia.',
            'Muy cómodo y tranquilo, ideal para descansar.',
            'Las instalaciones están un poco desactualizadas.',
            'Increíble experiencia, superó mis expectativas.'
        ];

        foreach ($completedReservations as $reservation) {
            // No todos los huéspedes dejan reseñas (70% de probabilidad)
            if (rand(1, 10) <= 7) {
                // Obtener el hotel_id a través de la relación room -> room_type -> hotel
                $room = DB::table('rooms')->where('id', $reservation->room_id)->first();
                $roomType = DB::table('room_types')->where('id', $room->room_type_id)->first();
                $hotelId = $roomType->hotel_id;

                // Calificación entre 3.0 y 5.0
                $rating = round(rand(30, 50) / 10, 1);

                // Las reseñas con calificación alta tienen más probabilidad de ser aprobadas
                $approved = $rating >= 4.0 ? rand(0, 10) <= 8 : rand(0, 10) <= 5;

                // Fecha de la reseña entre 1 y 7 días después del check-out
                $reviewDate = Carbon::parse($reservation->check_out)->addDays(rand(1, 7));

                $reviews[] = [
                    'user_id' => $reservation->user_id,
                    'hotel_id' => $hotelId,
                    'rating' => $rating,
                    'comment' => $comments[array_rand($comments)],
                    'approved' => $approved,
                    'created_at' => $reviewDate,
                    'updated_at' => $reviewDate,
                ];
            }
        }

        DB::table('reviews')->insert($reviews);
    }
}
