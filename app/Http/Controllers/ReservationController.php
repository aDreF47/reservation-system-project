<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{

    public function store(Request $request)
    {
        $room = Room::findOrFail($request->room_id);
        $maxGuests = $room->roomType->capacity;

        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guest' => "required|integer|min:1|max:$maxGuests",
        ], [
            'guest.max' => "La habitación no admite más de $maxGuests huéspedes.",
        ]);
        $existeReserva = Reservation::where('room_id', $room->id)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut->copy()->subDay()])
                    ->orWhereBetween('check_out', [$checkIn->copy()->addDay(), $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();

        if ($existeReserva) {
            return redirect()->back()->with('error', 'Esta habitación ya está reservada en ese rango de fechas.');
        }

        $nights = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $total = $nights * $room->roomType->base_price;


        $reservation = \App\Models\Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guest' => $request->guest,
            'total_price' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);
        return redirect()->back()->with('success', 'Reserva realizada correctamente');
        return redirect()->back()->withInput()->with('error', 'Esta habitación ya está reservada en ese rango de fechas.');
    }
}
