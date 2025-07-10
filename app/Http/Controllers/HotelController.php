<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;


class HotelController extends Controller
{
    public function index(){
        $hotels = Hotel::all();
        $hotels = Hotel::paginate(6);  // Número de hoteles por página
        return view('public.hotels.index',compact('hotels'));//
    }

    
    /**
     * Display the specified hotel with its room types.
     */
    public function show(Hotel $hotel)
    {
        // Cargar el hotel con sus tipos de habitaciones, características y habitaciones
    $hotel->load([
        'roomTypes' => function($query) {
            $query->with(['characteristics', 'images', 'rooms']);
        }
    ]);

    // Cargar todas las reseñas aprobadas de este hotel específico
    $approvedReviews = $hotel->reviews()->where('approved', 1)->with('user')->get();

        // Calcular disponibilidad para cada tipo de habitación
        foreach ($hotel->roomTypes as $roomType) {
            $roomType->available_rooms_count = $roomType->rooms()->where('available', 1)->count();
        }

        // Obtener la calificación promedio del hotel
        $avgRating = $hotel->reviews()->where('approved', 1)->avg('rating') ?: 0;

        return view('public.hotels.show', compact('hotel', 'approvedReviews'));
    }



}
