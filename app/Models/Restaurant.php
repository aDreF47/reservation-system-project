<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'cuisine_type',
        'capacity',
        'opening_hours',
        'images',
        'active'
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'images' => 'array',
        'active' => 'boolean',
        'capacity' => 'integer'
    ];

    public function tables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function reservations(): MorphMany
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    // Scope para obtener solo restaurantes activos
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Verificar si está abierto en un horario específico
    public function isOpen($dateTime)
    {
        $dayOfWeek = strtolower($dateTime->format('l'));
        $time = $dateTime->format('H:i');

        if (isset($this->opening_hours[$dayOfWeek])) {
            $hours = $this->opening_hours[$dayOfWeek];
            return $time >= $hours['open'] && $time <= $hours['close'];
        }

        return false;
    }

    // Obtener rating promedio
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('approved', true)->avg('rating') ?? 0;
    }
}
