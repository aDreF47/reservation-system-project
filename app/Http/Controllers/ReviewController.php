<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'hotel_id' => $validated['hotel_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => 1, // Por defecto las reseñas no requieren aprobación
        ]);

        return back()->with('success', 'Tu comentario ha sido enviado y está pendiente de aprobación.');
    }
}
