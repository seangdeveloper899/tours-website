<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Tour;
use App\Models\Guide;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Category::factory()->count(5)->create();
        $guide = Guide::factory()->create();
        
        Category::all()->each(function ($category) use ($guide) {
            Tour::factory()->count(3)->create([
                'category_id' => $category->id,
                'guide_id' => $guide->id,
                'is_active' => true,
            ]);
        });
    }

    
    public function it_can_list_all_categories()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'slug',
                             'tours_count',
                         ]
                     ]
                 ]);
    }

    
    public function it_can_get_a_single_category_with_tours()
    {
        $category = Category::first();
        
        $response = $this->getJson('/api/v1/categories/' . $category->slug);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'name',
                         'slug',
                         'tours' => [
                             '*' => [
                                 'id',
                                 'title',
                                 'slug',
                                 'price',
                             ]
                         ]
                     ]
                 ])
                 ->assertJsonPath('data.slug', $category->slug);
    }

    
    public function it_returns_404_for_non_existent_category()
    {
        $response = $this->getJson('/api/v1/categories/non-existent-category');

        $response->assertStatus(404)
                 ->assertJsonPath('success', false)
                 ->assertJsonPath('message', 'Category not found');
    }

    
    public function it_includes_tour_count_in_categories_list()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200);
        
        $categories = $response->json('data');
        foreach ($categories as $category) {
            $this->assertArrayHasKey('tours_count', $category);
            $this->assertGreaterThanOrEqual(0, $category['tours_count']);
        }
    }

    
    public function it_only_includes_active_tours_in_category_details()
    {
        $category = Category::first();
        
        Tour::factory()->count(2)->create([
            'category_id' => $category->id,
            'is_active' => false,
        ]);
        
        $response = $this->getJson('/api/v1/categories/' . $category->slug);

        $response->assertStatus(200);
        
        $tours = $response->json('data.tours');
        foreach ($tours as $tour) {
            $this->assertTrue($tour['is_active']);
        }
    }
}
