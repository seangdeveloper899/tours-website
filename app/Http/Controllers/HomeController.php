<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $featuredTours = Cache::remember('featured_tours', 3600, function () {
            return Tour::where('is_featured', true)
                ->where('is_active', true)
                ->with(['category', 'reviews' => function ($query) {
                    $query->where('is_approved', true)->select('id', 'tour_id', 'rating', 'comment', 'reviewer_name');
                }])
                ->select('id', 'category_id', 'title', 'slug', 'description', 'price', 'duration_days', 'max_people', 'featured_image')
                ->take(6)
                ->get();
        });

        $categories = Cache::remember('categories_with_count', 7200, function () {
            return Category::withCount(['tours' => function ($query) {
                $query->where('is_active', true);
            }])->get();
        });

        $recentReviews = Cache::remember('recent_reviews', 1800, function () {
            return Review::where('is_approved', true)
                ->with(['tour:id,title,slug'])
                ->select('id', 'tour_id', 'reviewer_name', 'rating', 'comment', 'created_at')
                ->latest()
                ->take(6)
                ->get();
        });

        $bannerSettings = SiteSetting::where('group', 'banner')->get()->keyBy('key');

        return view('home', compact('featuredTours', 'categories', 'recentReviews', 'bannerSettings'));
    }
}
