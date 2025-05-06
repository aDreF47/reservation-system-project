<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EventVenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'capacity',
        'facilities',
        'price_per_hour',
        'description',
        'images',
        'available'
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
        'available' => 'boolean',
        'price_per_hour' => 'decimal:2',
        'capacity' => 'integer'
    ];

    public function reservations(): MorphMany
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    // Scope para obtener solo locales disponibles
    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    // Verificar disponibilidad para fechas específicas
    public function isAvailable($startDateTime, $endDateTime)
    {
        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('check_in', [$startDateTime, $endDateTime])
                    ->orWhereBetween('check_out', [$startDateTime, $endDateTime])
                    ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                        $q->where('check_in', '<=', $startDateTime)
                          ->where('check_out', '>=', $endDateTime);
                    });
            })
            ->exists();
    }

    // Calcular precio total basado en horas
    public function calculatePrice($startDateTime, $endDateTime)
    {
        $hours = $startDateTime->diffInHours($endDateTime);
        return $hours * $this->price_per_hour;
    }

    // Obtener rating promedio
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('approved', true)->avg('rating') ?? 0;
    }
}
