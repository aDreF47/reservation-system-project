<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;

class AdminReservationController extends Controller
{
    public function index(){
        $hotels = Hotel::where('active', 1)->get();

        // Obtener todas las reservas ordenadas por fecha de creación
        $reservations = Reservation::with(['user', 'room.roomType.hotel'])
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10);

        return view('admin.reservations.index', compact('hotels', 'reservations'));
    }

    public function getRoomTypes($hotelId) {
        $roomTypes = RoomType::where('hotel_id', $hotelId)->get();
        return response()->json($roomTypes);
    }

    public function getRooms($roomTypeId) {
        $rooms = Room::where('room_type_id', $roomTypeId)
                    ->where('available', 1)
                    ->get();
        return response()->json($rooms);
    }

    public function getAvailableRooms(Request $request) {
        $roomTypeId = $request->room_type_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $rooms = Room::where('room_type_id', $roomTypeId)
                    ->where('available', 1)
                    ->whereDoesntHave('reservations', function($query) use ($checkIn, $checkOut) {
                        $query->where('status', '!=', 'cancelled')
                              ->where(function($q) use ($checkIn, $checkOut) {
                                  $q->whereBetween('check_in', [$checkIn, $checkOut])
                                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                                    ->orWhere(function($q2) use ($checkIn, $checkOut) {
                                        $q2->where('check_in', '<=', $checkIn)
                                           ->where('check_out', '>=', $checkOut);
                                    });
                              });
                    })
                    ->get();

        return response()->json($rooms);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0'
        ]);

        // Crear o encontrar usuario
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => bcrypt('temporal123'),
                'role' => 'cliente'
            ]
        );

        // Crear reserva
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in_date,
            'check_out' => $request->check_out_date,
            'guest' => $request->number_of_guests,
            'total_price' => $request->total_price,
            'status' => 'confirmed',
            'payment_status' => 'pending'
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reserva creada exitosamente');
    }

    // Método para actualizar el estado de una reserva
    public function updateStatus(Request $request, $id) {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:pending,paid,refunded'
        ]);

        $reservation->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Estado de reserva actualizado');
    }

    // Método para ver detalles de una reserva
    public function show($id) {
        $reservation = Reservation::with(['user', 'room.roomType.hotel'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }
}
