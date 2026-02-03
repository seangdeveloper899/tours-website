<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bio',
        'photo',
        'languages',
        'rating',
        'total_tours',
        'is_available',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'total_tours' => 'integer',
        'is_available' => 'boolean',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function getLanguagesArrayAttribute()
    {
        return $this->languages ? explode(',', $this->languages) : [];
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeTopRated($query)
    {
        return $query->where('rating', '>=', 4.5)->orderBy('rating', 'desc');
    }
}
