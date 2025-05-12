<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'features',
        'amenities',
        'base_price',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    // Relaciones
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Scopes
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('base_price', [$min, $max]);
    }

    // Accessors
    public function getAvailableRoomsCountAttribute()
    {
        return $this->rooms()->where('available', true)->count();
    }

    public function getMinPriceAttribute()
    {
        return $this->rooms()->min('price_per_night') ?? $this->base_price;
    }

    public function getMaxPriceAttribute()
    {
        return $this->rooms()->max('price_per_night') ?? $this->base_price;
    }

    // Métodos
    public function hasAvailableRooms()
    {
        return $this->rooms()->where('available', true)->exists();
    }

    public function getFeaturesList()
    {
        return $this->features ? explode(',', $this->features) : [];
    }

    public function getAmenitiesList()
    {
        return $this->amenities ? explode(',', $this->amenities) : [];
    }
}
