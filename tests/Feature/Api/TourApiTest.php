<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Guide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TourApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        $category = Category::factory()->create();
        $guide = Guide::factory()->create();
        
        Tour::factory()->count(15)->create([
            'category_id' => $category->id,
            'guide_id' => $guide->id,
            'is_active' => true,
        ]);
        
        Tour::factory()->count(3)->create([
            'category_id' => $category->id,
            'guide_id' => $guide->id,
            'is_active' => true,
            'is_featured' => true,
        ]);
    }

    
    public function it_can_list_all_tours()
    {
        $response = $this->getJson('/api/v1/tours');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'title',
                             'slug',
                             'description',
                             'price',
                             'duration_days',
                             'reviews_count',
                             'reviews_avg_rating',
                         ]
                     ],
                     'pagination' => [
                         'total',
                         'per_page',
                         'current_page',
                         'last_page',
                     ]
                 ]);
    }

    
    public function it_can_filter_tours_by_search()
    {
        $tour = Tour::first();
        
        $response = $this->getJson('/api/v1/tours?search=' . substr($tour->title, 0, 5));

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
    }

    
    public function it_can_filter_tours_by_price_range()
    {
        $response = $this->getJson('/api/v1/tours?min_price=100&max_price=500');

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
    }

    
    public function it_can_sort_tours_by_price_low_to_high()
    {
        $response = $this->getJson('/api/v1/tours?sort=price_low');

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
        
        $tours = $response->json('data');
        $prices = array_column($tours, 'price');
        $sortedPrices = $prices;
        sort($sortedPrices);
        $this->assertEquals($sortedPrices, array_values($prices));
    }

    
    public function it_can_sort_tours_by_price_high_to_low()
    {
        $response = $this->getJson('/api/v1/tours?sort=price_high');

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
        
        $tours = $response->json('data');
        $prices = array_column($tours, 'price');
        $sortedPrices = $prices;
        rsort($sortedPrices);
        $this->assertEquals($sortedPrices, array_values($prices));
    }

    
    public function it_can_get_featured_tours()
    {
        $response = $this->getJson('/api/v1/tours/featured');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'title',
                             'slug',
                             'is_featured',
                         ]
                     ]
                 ]);
        
        $tours = $response->json('data');
        foreach ($tours as $tour) {
            $this->assertTrue($tour['is_featured']);
        }
    }

    
    public function it_can_get_a_single_tour_by_slug()
    {
        $tour = Tour::first();
        
        $response = $this->getJson('/api/v1/tours/' . $tour->slug);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'title',
                         'slug',
                         'description',
                         'price',
                         'category',
                         'reviews_count',
                         'reviews_avg_rating',
                     ]
                 ])
                 ->assertJsonPath('data.slug', $tour->slug);
    }

    
    public function it_returns_404_for_non_existent_tour()
    {
        $response = $this->getJson('/api/v1/tours/non-existent-tour');

        $response->assertStatus(404)
                 ->assertJsonPath('success', false)
                 ->assertJsonPath('message', 'Tour not found');
    }

    
    public function it_can_paginate_tours()
    {
        $response = $this->getJson('/api/v1/tours?per_page=5');

        $response->assertStatus(200)
                 ->assertJsonPath('pagination.per_page', 5)
                 ->assertJsonCount(5, 'data');
    }

    
    public function it_can_filter_tours_by_category()
    {
        $category = Category::first();
        
        $response = $this->getJson('/api/v1/tours?category=' . $category->slug);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
    }

    
    public function it_includes_reviews_in_tour_details()
    {
        $tour = Tour::first();
        
        $response = $this->getJson('/api/v1/tours/' . $tour->slug);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'reviews',
                         'reviews_count',
                         'reviews_avg_rating',
                     ]
                 ]);
    }
}
