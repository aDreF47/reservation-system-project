<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'reservable_type', 'reservable_id', 'check_in', 'check_out',
        'guests', 'total_price', 'status', 'payment_status', 'special_requests',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reservable()
    {
        return $this->morphTo(); // Soporta habitaciones, tours, etc.
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
