<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relaciones
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Accessors
    public function getUserAttribute()
    {
        return $this->reservation->user;
    }

    public function getFormattedAmountAttribute()
    {
        return 'S/. ' . number_format($this->amount, 2);
    }

    // Métodos
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now()
        ]);

        $this->reservation->update(['payment_status' => 'paid']);
    }

    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }

    public function process()
    {
        // Aquí iría la lógica de procesamiento del pago
        // Por ejemplo, integración con pasarela de pago

        // Simulación simple:
        if (rand(1, 100) <= 95) { // 95% de éxito
            $this->markAsCompleted();
            return true;
        }

        $this->markAsFailed();
        return false;
    }
}
