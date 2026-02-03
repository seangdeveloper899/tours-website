<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $categories = Category::withCount('tours')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->with(['tours' => function ($query) {
                $query->where('is_active', true)
                      ->with('reviews');
            }])
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->tours->transform(function ($tour) {
            $tour->reviews_count = $tour->reviews->count();
            $tour->reviews_avg_rating = round($tour->reviews->avg('rating') ?? 0, 1);
            return $tour;
        });

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }
}
