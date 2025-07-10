<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Hotel;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['roomType.hotel'])->orderBy('floor')->orderBy('room_number')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::where('active', true)->with('roomTypes')->get();
        $roomTypes = RoomType::with('hotel')->get();
        return view('admin.rooms.create', compact('hotels', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10',
            'floor' => 'required|integer|min:1|max:50',
            'available' => 'boolean'
        ]);

        // Verificar que no exista una habitación con el mismo número en el mismo hotel
        $roomType = RoomType::find($validated['room_type_id']);
        $existingRoom = Room::whereHas('roomType', function($q) use ($roomType) {
            $q->where('hotel_id', $roomType->hotel_id);
        })->where('room_number', $validated['room_number'])->first();

        if ($existingRoom) {
            return back()->withErrors([
                'room_number' => 'Ya existe una habitación con este número en el hotel seleccionado.'
            ])->withInput();
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Habitación creada exitosamente.');
    }

    public function show(Room $room)
    {
        $room->load(['roomType.hotel']);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $room->load(['roomType.hotel']);
        $hotels = Hotel::where('active', true)->with('roomTypes')->get();
        $roomTypes = RoomType::with('hotel')->get();
        return view('admin.rooms.edit', compact('room', 'hotels', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10',
            'floor' => 'required|integer|min:1|max:50',
            'available' => 'boolean'
        ]);

        // Verificar que no exista una habitación con el mismo número en el mismo hotel (excluyendo la actual)
        $roomType = RoomType::find($validated['room_type_id']);
        $existingRoom = Room::whereHas('roomType', function($q) use ($roomType) {
            $q->where('hotel_id', $roomType->hotel_id);
        })->where('room_number', $validated['room_number'])
          ->where('id', '!=', $room->id)
          ->first();

        if ($existingRoom) {
            return back()->withErrors([
                'room_number' => 'Ya existe una habitación con este número en el hotel seleccionado.'
            ])->withInput();
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Habitación actualizada exitosamente.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Habitación eliminada exitosamente.');
    }

    // Método AJAX para obtener tipos de habitación por hotel
    public function getRoomTypesByHotel(Request $request)
    {
        $hotelId = $request->get('hotel_id');
        $roomTypes = RoomType::where('hotel_id', $hotelId)->get();
        
        return response()->json($roomTypes);
    }
}