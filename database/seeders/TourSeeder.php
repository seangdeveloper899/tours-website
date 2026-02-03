<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\Category;
use App\Models\Guide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{

    public function run(): void
    {
        $adventure = Category::where('slug', 'adventure-tours')->first();
        $cultural = Category::where('slug', 'cultural-tours')->first();
        $beach = Category::where('slug', 'beach-tours')->first();

        $johnGuide = Guide::where('email', 'john@toursguide.com')->first();
        $mariaGuide = Guide::where('email', 'maria@toursguide.com')->first();

        $tours = [
            [
                'title' => 'Mountain Hiking Adventure',
                'slug' => 'mountain-hiking-adventure',
                'description' => 'Experience breathtaking views on this challenging mountain hike. Perfect for adventure seekers looking for an unforgettable experience.',
                'highlights' => [
                    'Summit view at 3000m',
                    'Professional guide included',
                    'Small group (max 8 people)',
                    'All equipment provided'
                ],
                'included' => [
                    'Professional guide',
                    'Hiking equipment',
                    'Lunch and snacks',
                    'Transportation',
                    'Insurance'
                ],
                'excluded' => [
                    'Personal expenses',
                    'Tips for guide',
                    'Alcoholic beverages'
                ],
                'price' => 149.99,
                'original_price' => 199.99,
                'duration_days' => 1,
                'duration_nights' => 0,
                'location' => 'Rocky Mountains, Colorado',
                'meeting_point' => 'Base Camp Parking Lot',
                'latitude' => 39.7392,
                'longitude' => -104.9903,
                'max_people' => 8,
                'min_people' => 2,
                'category_id' => $adventure->id,
                'guide_id' => $johnGuide->id,
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'total_reviews' => 45,
                'total_bookings' => 120,
            ],
            [
                'title' => 'Historical City Walking Tour',
                'slug' => 'historical-city-walking-tour',
                'description' => 'Discover the rich history and culture of our beautiful city with an expert local guide.',
                'highlights' => [
                    'Visit 10+ historical landmarks',
                    'Expert local historian guide',
                    'Stop at local cafes',
                    'Photo opportunities'
                ],
                'included' => [
                    'Professional guide',
                    'Entrance fees',
                    'Coffee break',
                    'City map'
                ],
                'excluded' => [
                    'Lunch',
                    'Personal purchases',
                    'Transportation to meeting point'
                ],
                'price' => 45.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'location' => 'Old Town District',
                'meeting_point' => 'City Hall Main Entrance',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'max_people' => 15,
                'min_people' => 4,
                'category_id' => $cultural->id,
                'guide_id' => $mariaGuide->id,
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'total_reviews' => 78,
                'total_bookings' => 200,
            ],
            [
                'title' => 'Tropical Beach Escape',
                'slug' => 'tropical-beach-escape',
                'description' => 'Relax on pristine beaches with crystal-clear waters. Perfect 3-day getaway!',
                'highlights' => [
                    'Private beach access',
                    'Snorkeling equipment',
                    'Beachfront accommodation',
                    'Daily breakfast'
                ],
                'included' => [
                    'Accommodation (2 nights)',
                    'Daily breakfast',
                    'Beach activities',
                    'Airport transfer',
                    'Tour guide'
                ],
                'excluded' => [
                    'Flights',
                    'Lunch and dinner',
                    'Spa treatments',
                    'Travel insurance'
                ],
                'price' => 599.00,
                'original_price' => 799.00,
                'duration_days' => 3,
                'duration_nights' => 2,
                'location' => 'Paradise Island',
                'meeting_point' => 'Island Airport',
                'latitude' => 25.0343,
                'longitude' => -77.3963,
                'max_people' => 20,
                'min_people' => 1,
                'category_id' => $beach->id,
                'guide_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'rating' => 4.6,
                'total_reviews' => 34,
                'total_bookings' => 85,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}
