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
        'main_image',
        'active',
    ];

    protected $casts = [
        'main_image' => 'array',
        'active' => 'boolean',
        'stars' => 'integer',
    ];

    // Relaciones
    public function hotelTypes()
    {
        return $this->hasMany(HotelType::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, HotelType::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByStars($query, $stars)
    {
        return $query->where('stars', $stars);
    }

    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('approved', true)->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->where('approved', true)->count();
    }

    public function getAvailableRoomsCountAttribute()
    {
        return $this->rooms()->where('available', true)->count();
    }

    // Métodos
    public function getStarsAsText()
    {
        return str_repeat('★', $this->stars) . str_repeat('☆', 5 - $this->stars);
    }
}
