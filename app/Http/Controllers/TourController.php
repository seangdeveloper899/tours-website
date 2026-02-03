<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('is_active', true)
            ->with(['category:id,name,slug'])
            ->withCount(['reviews' => function ($q) {
                $q->where('is_approved', true);
            }])
            ->withAvg('reviews as reviews_avg_rating', 'rating');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('duration')) {
            $query->where('duration_days', $request->duration);
        }

        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderByDesc('is_featured')->latest();
        }

        $tours = $query->paginate(12)->withQueryString();
        
        $categories = Cache::remember('all_categories', 3600, function () {
            return Category::select('id', 'name', 'slug', 'icon')->get();
        });

        $toursSettings = SiteSetting::where('group', 'tours')->get()->keyBy('key');

        return view('tours.index', compact('tours', 'categories', 'toursSettings'));
    }

    public function show($slug)
    {
        $tour = Cache::remember("tour_{$slug}", 1800, function () use ($slug) {
            return Tour::where('slug', $slug)
                ->where('is_active', true)
                ->with([
                    'category:id,name,slug',
                    'reviews' => function ($query) {
                        $query->where('is_approved', true)
                            ->latest()
                            ->select('id', 'tour_id', 'reviewer_name', 'rating', 'comment', 'is_verified', 'created_at');
                    }
                ])
                ->firstOrFail();
        });

        $relatedTours = Cache::remember("related_tours_{$tour->category_id}_{$tour->id}", 1800, function () use ($tour) {
            return Tour::where('category_id', $tour->category_id)
                ->where('id', '!=', $tour->id)
                ->where('is_active', true)
                ->select('id', 'title', 'slug', 'price', 'duration_days', 'featured_image')
                ->inRandomOrder()
                ->take(3)
                ->get();
        });

        return view('tours.show', compact('tour', 'relatedTours'));
    }
}
