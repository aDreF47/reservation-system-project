<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'stars',
        'description',
        'images',
        'active'
    ];

    protected $casts = [
        'images' => 'array',
        'active' => 'boolean',
        'stars' => 'integer'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function reservations(): MorphMany
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    // Scope para obtener solo hoteles activos
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Obtener rating promedio
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('approved', true)->avg('rating') ?? 0;
    }
}
