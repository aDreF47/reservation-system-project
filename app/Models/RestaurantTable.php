<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'table_number',
        'capacity',
        'location',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean',
        'capacity' => 'integer'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations(): MorphMany
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    // Verificar disponibilidad para fecha y hora específicas
    public function isAvailable($dateTime, $duration = 2)
    {
        $endTime = clone $dateTime;
        $endTime->addHours($duration);

        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($dateTime, $endTime) {
                $query->whereBetween('check_in', [$dateTime, $endTime])
                    ->orWhereBetween('check_out', [$dateTime, $endTime])
                    ->orWhere(function ($q) use ($dateTime, $endTime) {
                        $q->where('check_in', '<=', $dateTime)
                          ->where('check_out', '>=', $endTime);
                    });
            })
            ->exists();
    }
}
