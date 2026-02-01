<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number', 'tour_id', 'user_id',
        'customer_name', 'customer_email', 'customer_phone',
        'booking_date', 'number_of_people',
        'price_per_person', 'total_amount',
        'special_requirements', 'notes',
        'status', 'payment_status', 'payment_method', 'payment_reference',
        'confirmed_at', 'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'price_per_person' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'number_of_people' => 'integer',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate booking number
        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BOOK-' . date('Y') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        // Update tour bookings count
        static::created(function ($booking) {
            $booking->tour->increment('total_bookings');
        });
    }

    // Relationships
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now());
    }

    // Methods
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
