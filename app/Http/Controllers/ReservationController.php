<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        //$reservations = Reservation::all();  // O puedes usar un filtro si es necesario
        return view('reservations.index');
    }

    public function create()
    {
        return view('reservations.create');  // Vista para crear una nueva reserva
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservable_type' => 'required|string',
            'reservable_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $reservation = Reservation::create([
                'user_id' => auth()->id,
                'reservable_type' => $request->reservable_type,
                'reservable_id' => $request->reservable_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'guests' => $request->guests,
                'total_price' => $request->amount,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'special_requests' => $request->special_requests,
            ]);

            Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'transaction_id' => Str::uuid(),
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('reservations.index')->with('success', 'Reserva creada y pagada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la reserva: ' . $e->getMessage());
        }
    }
    public function show()
    {
        //
    }

}
