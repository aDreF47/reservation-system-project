<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display the specified room type with available rooms.
     */
    public function show(RoomType $roomType)
    {
        // Cargar el tipo de habitación con sus características, imágenes y habitaciones disponibles
        $roomType->load(['characteristics', 'images', 'hotel']);
        $availableRooms = $roomType->rooms()->where('available', 1)->get();

        return view('public.room_types.show', compact('roomType', 'availableRooms'));
    }
}
