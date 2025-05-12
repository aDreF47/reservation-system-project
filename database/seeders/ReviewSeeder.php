<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Review;



class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Solo reservas confirmadas y pasadas pueden tener reviews
        $reservations = Reservation::where('status', 'confirmed')
            ->where('check_out', '<', now())
            ->get();

        $comments = [
            5 => [
                'Excelente hotel, superó todas mis expectativas. El servicio fue impecable.',
                'Habitación muy cómoda y limpia. La vista al mar es espectacular.',
                'El mejor hotel en el que me he hospedado. Definitivamente volveré.',
                'Servicio de primera clase. El personal muy atento y profesional.',
            ],
            4 => [
                'Muy buen hotel, solo algunos detalles menores que mejorar.',
                'Buena ubicación y servicio. El desayuno podría ser más variado.',
                'Habitación confortable, aunque el aire acondicionado hacía un poco de ruido.',
                'En general muy bien, pero el WiFi era un poco lento.',
            ],
            3 => [
                'Hotel aceptable para el precio. Nada extraordinario.',
                'La habitación estaba bien, pero necesita renovación.',
                'Servicio regular. Tuvimos que esperar mucho en el check-in.',
                'Ubicación conveniente, pero las instalaciones son algo antiguas.',
            ],
            2 => [
                'No cumplió con las expectativas. Varias cosas que mejorar.',
                'La limpieza dejaba que desear. Encontramos polvo en varios lugares.',
                'El ruido de la calle no dejaba dormir bien.',
                'Personal poco atento. Mala experiencia en general.',
            ],
            1 => [
                'Muy decepcionante. No lo recomendaría.',
                'Pésimo servicio y habitación en mal estado.',
                'La peor experiencia hotelera que he tenido.',
                'No vale la pena por el precio que cobran.',
            ],
        ];

        foreach ($reservations->random(min(30, $reservations->count())) as $reservation) {
            $hotelId = $reservation->room->hotelType->hotel_id;
            $rating = rand(3, 5); // Más reviews positivas

            Review::create([
                'user_id' => $reservation->user_id,
                'hotel_id' => $hotelId,
                'rating' => $rating,
                'comment' => $comments[$rating][array_rand($comments[$rating])],
                'approved' => rand(0, 100) > 20, // 80% aprobadas
                'created_at' => $reservation->check_out->addDays(rand(1, 7)),
            ]);
        }
    }
}
