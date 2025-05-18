<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgRoomType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_type_id',
        'img_path',
    ];

    /**
     * Get the room type that owns the image.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
