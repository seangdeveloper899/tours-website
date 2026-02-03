<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description',
        'highlights', 'included', 'excluded',
        'price', 'original_price',
        'duration_days', 'duration_nights',
        'location', 'meeting_point', 'latitude', 'longitude',
        'max_people', 'min_people',
        'featured_image', 'gallery', 'video_url',
        'category_id', 'guide_id',
        'is_featured', 'is_active',
        'rating', 'total_reviews', 'total_bookings',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'highlights' => 'array',
        'included' => 'array',
        'excluded' => 'array',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
        'duration_days' => 'integer',
        'duration_nights' => 'integer',
        'max_people' => 'integer',
        'min_people' => 'integer',
        'total_reviews' => 'integer',
        'total_bookings' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function banners()
    {
        return $this->hasMany(TourBanner::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('total_bookings', 'desc');
    }

    public function scopeTopRated($query)
    {
        return $query->where('rating', '>=', 4)->orderBy('rating', 'desc');
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount_percentage > 0;
    }

    public function updateRating()
    {
        $approvedReviews = $this->reviews()->approved();
        $avgRating = $approvedReviews->avg('rating');
        $totalReviews = $approvedReviews->count();

        $this->update([
            'rating' => $avgRating ? round($avgRating, 2) : 0,
            'total_reviews' => $totalReviews,
        ]);
    }
}
