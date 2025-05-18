<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'capacity',
        'base_price',
        'main_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacity' => 'integer',
        'base_price' => 'decimal:2',
    ];

    /**
     * Get the hotel that owns the room type.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the rooms for the room type.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the characteristics for the room type.
     */
    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'characteristic_types');
    }

    /**
     * Get the images for the room type.
     */
    public function images()
    {
        return $this->hasMany(ImgRoomType::class);
    }

    /**
     * Get available rooms for this room type.
     */
    public function availableRooms()
    {
        return $this->rooms()->where('available', 1);
    }
}
