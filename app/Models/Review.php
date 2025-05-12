<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Review extends Model
{


    protected $fillable = [
        'user_id',
        'hotel_id',
        'rating',
        'comment',
        'approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Métodos
    public function approve()
    {
        $this->update(['approved' => true]);
    }

    public function reject()
    {
        $this->delete();
    }

    public function getRatingStars()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function canBeEditedBy(User $user)
    {
        return $this->user_id === $user->id && $this->created_at->isAfter(now()->subHours(24));
    }
}
