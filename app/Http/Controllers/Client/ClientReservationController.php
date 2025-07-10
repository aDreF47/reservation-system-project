<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;


class ClientReservationController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $status = $request->get('status', 'all');

        $query = $user->reservations()
            ->with(['room.roomType.hotel'])
            ->orderBy('created_at', 'desc');

        // Filtrar por estado si se especifica
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reservations = $query->paginate(10);

        // Contadores para las pestañas
        $counts = [
            'all' => $user->reservations()->count(),
            'pending' => $user->reservations()->where('status', 'pending')->count(),
            'confirmed' => $user->reservations()->where('status', 'confirmed')->count(),
            'cancelled' => $user->reservations()->where('status', 'cancelled')->count(),
        ];

        return view('client.reservations.index', compact('reservations', 'status', 'counts'));
    }

    public function show($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $reservation = $user->reservations()
            ->with(['room.roomType.hotel', 'payments'])
            ->findOrFail($id);

        return view('client.reservations.show', compact('reservation'));
    }

    public function cancel($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $reservation = $user->reservations()->findOrFail($id);

        // Verificar si la reservación puede ser cancelada
        if (!$reservation->canBeCancelled()) {
            return redirect()->back()->with('error', 'Esta reservación no puede ser cancelada.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('client.reservations')
            ->with('success', 'Reservación cancelada exitosamente.');
    }
}
