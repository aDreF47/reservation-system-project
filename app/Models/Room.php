<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_type_id',
        'room_number',
        'floor',
        'available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'floor' => 'integer',
        'available' => 'integer',
    ];

    /**
     * Get the room type that owns the room.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the hotel through the room type.
     */
    public function hotel()
    {
        return $this->hasOneThrough(Hotel::class, RoomType::class, 'id', 'id', 'room_type_id', 'hotel_id');
    }

    /**
     * Get the reservations for the room.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check if room is available for a given date range.
     */
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->available) {
            return 1;
        }

        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();
    }

    /**
     * Scope a query to only include available rooms.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }
}
