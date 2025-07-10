<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Estadísticas del cliente
        // Estadísticas del cliente
        $stats = [
            'total_reservations' => $user->reservations()->count(),
            'active_reservations' => $user->reservations()->where('status', '!=', 'cancelled')->where('check_out', '>', now())->count(),
            'completed_reservations' => $user->reservations()->where('check_out', '<=', now())->count(),
            'pending_reservations' => $user->reservations()->where('status', 'pending')->count(),
        ];

        // Próximas reservaciones
        $upcomingReservations = $user->reservations()
            ->where('status', '!=', 'cancelled')
            ->where('check_out', '>', now())
            ->with(['room.roomType', 'room.roomType.hotel'])
            ->orderBy('check_in')
            ->limit(3)
            ->get();

        // Reservaciones recientes
        $recentReservations = $user->reservations()
            ->with(['room.roomType', 'room.roomType.hotel'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('client.dashboard', compact('stats', 'upcomingReservations', 'recentReservations'));
    }
}
