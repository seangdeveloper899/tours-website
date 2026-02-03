<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_id',
        'guide_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'number_of_participants',
        'number_of_people',
        'booking_date',
        'total_price',
        'total_amount',
        'deposit_amount',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'payment_date',
        'booking_reference',
        'booking_number',
        'special_requests',
        'special_requirements',
        'notes',
        'price_per_person',
        'payment_reference',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'payment_date' => 'datetime',
        'total_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'price_per_person' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BOOK-' . date('Y') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->transactions()
            ->where('status', 'completed')
            ->where('transaction_type', 'payment')
            ->sum('amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        return max(0, ($this->total_price ?? $this->total_amount ?? 0) - $this->total_paid);
    }

    public function isFullyPaid(): bool
    {
        return $this->remaining_balance <= 0;
    }

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

