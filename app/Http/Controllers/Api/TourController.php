<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class TourController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $query = Tour::with(['category', 'reviews'])
            ->where('is_active', true);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('duration')) {
            $query->where('duration_days', $request->duration);
        }

        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'popular':
                $query->withCount('reviews')
                      ->orderBy('reviews_count', 'desc');
                break;
            case 'featured':
            default:
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
        }

        $tours = $query->paginate($request->get('per_page', 10));

        $tours->getCollection()->transform(function ($tour) {
            $tour->reviews_count = $tour->reviews->count();
            $tour->reviews_avg_rating = round($tour->reviews->avg('rating') ?? 0, 1);
            return $tour;
        });

        return response()->json([
            'success' => true,
            'data' => $tours->items(),
            'pagination' => [
                'total' => $tours->total(),
                'per_page' => $tours->perPage(),
                'current_page' => $tours->currentPage(),
                'last_page' => $tours->lastPage(),
                'from' => $tours->firstItem(),
                'to' => $tours->lastItem(),
            ]
        ]);
    }

    public function featured(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 6);
        $cacheKey = "featured_tours_{$limit}";
        
        $tours = Cache::remember($cacheKey, now()->addHours(1), function () use ($limit) {
            return Tour::with(['category', 'reviews'])
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });

        $tours->transform(function ($tour) {
            $tour->reviews_count = $tour->reviews->count();
            $tour->reviews_avg_rating = round($tour->reviews->avg('rating') ?? 0, 1);
            return $tour;
        });

        return response()->json([
            'success' => true,
            'data' => $tours
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $cacheKey = "tour_details_{$slug}";
        
        $tour = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug) {
            return Tour::with(['category', 'reviews', 'reviews.booking'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });

        if (!$tour) {
            return response()->json([
                'success' => false,
                'message' => 'Tour not found'
            ], 404);
        }

        $tour->reviews_count = $tour->reviews->count();
        $tour->reviews_avg_rating = round($tour->reviews->avg('rating') ?? 0, 1);

        $tour->reviews->transform(function ($review) {
            return [
                'id' => $review->id,
                'customer_name' => $review->booking->customer_name ?? 'Anonymous',
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->format('Y-m-d'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $tour
        ]);
    }
}
