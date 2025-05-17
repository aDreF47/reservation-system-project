<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelType;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($hotelId, $typeId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $typeRoom = $hotel->hotelTypes()->where('id', $typeId)->firstOrFail();

        return view('public.reservations.create', compact('hotel', 'typeRoom'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:type_rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $room = hotelTypes::findOrFail($request->room_id);

        // Calcular total de noches
        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $nights = $checkIn->diff($checkOut)->days;

        if ($nights < 1) {
            return back()->withErrors(['check_out' => 'La fecha de salida debe ser al menos un día después de la entrada.']);
        }

        // Calcular precio total
        $totalPrice = $nights * $room->base_price;

        // Crear reserva
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('reservations.show', $reservation->id)->with('success', 'Reserva realizada con éxito.');
    }
}

