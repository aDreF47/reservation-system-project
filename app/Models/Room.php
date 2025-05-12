<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_type_id',
        'room_number',
        'capacity',
        'price_per_night',
        'facilities',
        'available',
    ];

    protected $casts = [
        'facilities' => 'array',
        'available' => 'boolean',
        'price_per_night' => 'decimal:2',
        'capacity' => 'integer',
    ];

    // Relaciones
    public function hotelType()
    {
        return $this->belongsTo(HotelType::class);
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function scopeByCapacity($query, $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price_per_night', [$min, $max]);
    }

    // Accessors
    public function getHotelAttribute()
    {
        return $this->hotelType->hotel;
    }

    public function getFeaturedImageAttribute()
    {
        return $this->roomImages()->where('is_featured', true)->first();
    }

    public function getFloorAttribute()
    {
        return substr($this->room_number, 0, -2);
    }

    // Métodos
    public function isAvailableForDates($checkIn, $checkOut)
    {
        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();
    }

    public function markAsOccupied()
    {
        $this->update(['available' => false]);
    }

    public function markAsAvailable()
    {
        $this->update(['available' => true]);
    }
}
