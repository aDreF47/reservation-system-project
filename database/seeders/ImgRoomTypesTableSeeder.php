<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImgRoomTypesTableSeeder extends Seeder
{
    public function run()
    {
        // Arreglo de URLs de imágenes por tipo y perspectiva
        $imageUrls = [
            // Para el tipo de habitación 1 (Habitación Estándar - Hotel Miraflores)
            1 => [
                'general' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1505693314120-0d443867891c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1517686469429-8bdb88b9f907?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Para el tipo de habitación 2 (Habitación Superior - Hotel Miraflores)
            2 => [
                'general' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1560185007-5f0bb1866cab?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Para el tipo de habitación 3 (Suite Ejecutiva - Hotel Miraflores)
            3 => [
                'general' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1580977276076-ae4b8c219b2e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1589834390005-5d4fb9bf3d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Para el tipo de habitación 4 (Habitación Deluxe - Grand Hotel San Isidro)
            4 => [
                'general' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1588046130717-0eb0c9a3ba15?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1574643156929-51fa098b0394?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1612320583354-02dd8304d91c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            // Continuación para los demás tipos...
            5 => [
                'general' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1604709177225-055f99402ea3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1617098600599-c7b3cfaf0b90?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1517449905587-f80695d63382?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            6 => [
                'general' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1563911302283-d2bc129e7570?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            7 => [
                'general' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1459789098149-d1a4813a5375?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1501949997128-2fdb9f6428f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1599619351208-3e6c839d6828?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            8 => [
                'general' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1576698483491-8c43f0862543?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1594130139005-21492285c2f0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1518438788254-d2309b6a2b1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1578536899999-5f9ada8ffcbd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ],

            9 => [
                'general' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bathroom' => 'https://images.unsplash.com/photo-1585412727339-54e4bae3bbf9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'bed' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'view' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'detail' => 'https://images.unsplash.com/photo-1561501878-aabd62634533?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
            ]
        ];

        $images = [];

        // Para cada tipo de habitación, agregamos varias imágenes
        for ($roomTypeId = 1; $roomTypeId <= 9; $roomTypeId++) {
            // Nombres de las vistas/perspectivas para las imágenes
            $perspectives = ['general', 'bathroom', 'bed', 'view', 'detail'];

            foreach ($perspectives as $perspective) {
                $images[] = [
                    'room_type_id' => $roomTypeId,
                    'img_path' => $imageUrls[$roomTypeId][$perspective],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('img_room_types')->insert($images);
    }
}
