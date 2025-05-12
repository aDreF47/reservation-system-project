<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'payment_status',
        'special_requests',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'decimal:2',
        'guests' => 'integer',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCurrent($query)
    {
        return $query->where('check_in', '<=', now())
                    ->where('check_out', '>=', now())
                    ->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>', now())
                    ->where('status', '!=', 'cancelled');
    }

    public function scopePast($query)
    {
        return $query->where('check_out', '<', now());
    }

    // Accessors
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getHotelAttribute()
    {
        return $this->room->hotelType->hotel;
    }

    public function getIsActiveAttribute()
    {
        return $this->check_in <= now() && $this->check_out >= now() && $this->status === 'confirmed';
    }

    public function getCanCancelAttribute()
    {
        return $this->status === 'pending' ||
               ($this->status === 'confirmed' && $this->check_in->isAfter(now()->addDay()));
    }

    // Métodos
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        // Si es para hoy, marcar habitación como ocupada
        if ($this->check_in->isToday()) {
            $this->room->markAsOccupied();
        }
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);

        if ($this->payment_status === 'paid') {
            $this->update(['payment_status' => 'refunded']);
        }

        // Liberar la habitación si estaba ocupada
        if ($this->is_active) {
            $this->room->markAsAvailable();
        }
    }

    public function calculatePrice()
    {
        $nights = $this->nights;
        $pricePerNight = $this->room->price_per_night;
        return $nights * $pricePerNight;
    }
}
