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
        'reservable_type',
        'reservable_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'payment_status',
        'special_requests'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'guests' => 'integer',
        'total_price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payment(): HasOne
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

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Métodos de estado
    public function confirm()
    {
        $this->update(['status' => 'confirmed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function markAsPaid()
    {
        $this->update(['payment_status' => 'paid']);
    }

    // Verificar si puede ser cancelada
    public function canBeCancelled()
    {
        return $this->status !== 'cancelled' &&
               $this->check_in->isFuture();
    }
}
