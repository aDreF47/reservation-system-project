<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'image_path',
        'alt_text',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    // Relaciones
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    // Accessors
    public function getFullPathAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    // Métodos
    public function makeFeatured()
    {
        // Quitar featured de otras imágenes
        $this->room->roomImages()->update(['is_featured' => false]);

        // Marcar esta como featured
        $this->update(['is_featured' => true]);
    }
}
