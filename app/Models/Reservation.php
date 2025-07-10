<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guest',
        'total_price',
        'status',
        'payment_status',
        'special_requests',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'guest' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that is reserved.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the payment for the reservation.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calculate the number of nights.
     */
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Check if reservation can be cancelled.
     */
    public function canBeCancelled()
    {
        return $this->status !== 'cancelled' && $this->check_in->isFuture();
    }

    /**
     * Scope a query to only include pending reservations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed reservations.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include cancelled reservations.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
