<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('hotel')->get();
        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        $hotels = Hotel::where('active', true)->get();
        return view('admin.room-types.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
            'main_image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('room-types', 'public');
        }

        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipo de habitación creado exitosamente.');
    }

    public function show(RoomType $roomType)
    {
        return view('admin.room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        $hotels = Hotel::where('active', true)->get();
        return view('admin.room-types.edit', compact('roomType', 'hotels'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
            'main_image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('main_image')) {
            // Eliminar imagen anterior
            if ($roomType->main_image) {
                Storage::disk('public')->delete($roomType->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('room-types', 'public');
        }

        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipo de habitación actualizado exitosamente.');
    }

    public function destroy(RoomType $roomType)
    {
        // Eliminar imagen
        if ($roomType->main_image) {
            Storage::disk('public')->delete($roomType->main_image);
        }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipo de habitación eliminado exitosamente.');
    }
}