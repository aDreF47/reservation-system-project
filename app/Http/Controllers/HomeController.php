<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal
     */
    public function index()
    {
        // Obtener hoteles destacados (los de mayor rating o más reservas)
        $featuredHotels = Hotel::where('active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(3)
            ->get();

        // Estadísticas generales para mostrar en el home
        $totalHotels = Hotel::where('active', true)->count();
        $totalRooms = Room::where('available', true)->count();
        $totalReservations = Reservation::where('status', 'confirmed')->count();

        // Si el usuario está autenticado, obtener información adicional
        $userReservations = null;
        $pendingReservations = null;

        // if (Auth::check()) {
        //     $userReservations = Auth::user()->reservations()
        //         ->with(['room.hotelType.hotel'])
        //         ->orderBy('check_in', 'desc')
        //         ->take(3)
        //         ->get();

        //     $pendingReservations = Auth::user()->reservations()
        //         ->where('status', 'pending')
        //         ->count();
        // }

        // Obtener reseñas recientes
        $recentReviews = Review::where('approved', true)
            ->with(['user', 'hotel'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Calcular estadísticas para el banner
        $stats = [
            'hotels' => $totalHotels,
            'rooms' => $totalRooms,
            'reservations' => $totalReservations,
            'reviews' => Review::where('approved', true)->count(),
        ];

        return view('index', compact(
            'featuredHotels',
            'userReservations',
            'pendingReservations',
            'recentReviews',
            'stats'
        ));
    }

    /**
     * Buscar hoteles desde el home
     */
    public function search(Request $request)
    {
        $query = Hotel::where('active', true);

        // Filtrar por ciudad
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Filtrar por número de estrellas
        if ($request->filled('stars')) {
            $query->where('stars', $request->stars);
        }

        // Filtrar por rango de precio
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('hotelTypes.rooms', function ($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('price_per_night', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price_per_night', '<=', $request->max_price);
                }
            });
        }

        // Filtrar por disponibilidad en fechas específicas
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;

            $query->whereHas('hotelTypes.rooms', function ($q) use ($checkIn, $checkOut) {
                $q->where('available', true)
                  ->whereDoesntHave('reservations', function ($subQ) use ($checkIn, $checkOut) {
                      $subQ->where('status', '!=', 'cancelled')
                           ->where(function ($dateQ) use ($checkIn, $checkOut) {
                               $dateQ->whereBetween('check_in', [$checkIn, $checkOut])
                                     ->orWhereBetween('check_out', [$checkIn, $checkOut])
                                     ->orWhere(function ($overlapQ) use ($checkIn, $checkOut) {
                                         $overlapQ->where('check_in', '<=', $checkIn)
                                                  ->where('check_out', '>=', $checkOut);
                                     });
                           });
                  });
            });
        }

        $hotels = $query->withCount('reviews')
                       ->withAvg('reviews', 'rating')
                       ->orderBy('reviews_avg_rating', 'desc')
                       ->paginate(9);

        return view('public.hotels.index', compact('hotels'));
    }

    /**
     * Mostrar página de "Acerca de"
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Mostrar página de contacto
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Procesar formulario de contacto
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Aquí iría la lógica para enviar el email
        // Por ahora solo retornamos un mensaje de éxito

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado. Te contactaremos pronto.');
    }

    /**
     * Cambiar el idioma de la aplicación
     */
    public function changeLanguage(Request $request)
    {
        $language = $request->input('language', 'es');

        if (in_array($language, ['es', 'en', 'pt'])) {
            session(['locale' => $language]);
        }

        return redirect()->back();
    }
}
