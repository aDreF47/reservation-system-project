<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHotelController extends Controller
{

    /*public function __construct()
    {
        // Solo usar el middleware de autenticación básico
        //parent::middleware('auth');
    }*/

    public function index()
    {
        $hotels = Hotel::all();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'stars' => 'required|integer|between:1,5',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('hotels', 'public');
            $validated['main_image'] = $path;
        }

        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel creado exitosamente.');
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'stars' => 'required|integer|between:1,5',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('main_image')) {
            if ($hotel->main_image) {
                Storage::disk('public')->delete($hotel->main_image);
            }
            $path = $request->file('main_image')->store('hotels', 'public');
            $validated['main_image'] = $path;
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        
        if ($hotel->main_image) {
            Storage::disk('public')->delete($hotel->main_image);
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel eliminado exitosamente.');
    }
}