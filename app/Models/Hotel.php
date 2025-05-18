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
        'active' => 'integer',
        'stars' => 'integer',
    ];

    // Relaciones
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, RoomType::class);
    }

    // Accessors
    public function averageRating()
    {
        return $this->reviews()->where('approved', 1)->avg('rating') ?? 0;
    }

    /**
     * Scope a query to only include active hotels.
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // Métodos
    public function getStarsAsText()
    {
        return str_repeat('★', $this->stars) . str_repeat('☆', 5 - $this->stars);
    }
}
