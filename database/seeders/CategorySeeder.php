<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Adventure Tours',
                'slug' => 'adventure-tours',
                'description' => 'Thrilling outdoor activities and extreme sports',
                'icon' => 'fa-mountain',
                'sort_order' => 1,
            ],
            [
                'name' => 'Cultural Tours',
                'slug' => 'cultural-tours',
                'description' => 'Explore history, heritage and local traditions',
                'icon' => 'fa-landmark',
                'sort_order' => 2,
            ],
            [
                'name' => 'Beach Tours',
                'slug' => 'beach-tours',
                'description' => 'Relaxing seaside getaways and water activities',
                'icon' => 'fa-umbrella-beach',
                'sort_order' => 3,
            ],
            [
                'name' => 'City Tours',
                'slug' => 'city-tours',
                'description' => 'Urban exploration and sightseeing',
                'icon' => 'fa-city',
                'sort_order' => 4,
            ],
            [
                'name' => 'Wildlife Tours',
                'slug' => 'wildlife-tours',
                'description' => 'Safari and nature experiences',
                'icon' => 'fa-paw',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
