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
        $culinary = Category::where('slug', 'culinary-tours')->first();

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
            [
                'title' => 'Angkor Wat Sunrise Tour',
                'slug' => 'angkor-wat-sunrise-tour',
                'description' => 'Experience the breathtaking sunrise over the magnificent Angkor Wat, one of the most spectacular archaeological sites in Southeast Asia. This early morning tour includes visits to Angkor Thom and Ta Prohm jungle temple.',
                'price' => 89.99,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 12,
                'location' => 'Siem Reap, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1563492065421-a00d6c1c5a56?w=1200',
                'category_id' => $cultural ? $cultural->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Mekong River Sunset Cruise',
                'slug' => 'mekong-river-sunset-cruise',
                'description' => 'Relax on a scenic sunset cruise along the mighty Mekong River. Enjoy traditional Cambodian snacks, live music, and stunning views of riverside landmarks as the sun sets over the water.',
                'price' => 65.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 30,
                'location' => 'Phnom Penh, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200',
                'category_id' => $culinary ? $culinary->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Tonle Sap Floating Village',
                'slug' => 'tonle-sap-floating-village',
                'description' => 'Discover the unique lifestyle of floating villages on Tonle Sap Lake, the largest freshwater lake in Southeast Asia. Visit local homes, schools, and markets built on water and learn about traditional fishing communities.',
                'price' => 55.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 15,
                'location' => 'Siem Reap, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=1200',
                'category_id' => $cultural ? $cultural->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Cardamom Mountains Trekking',
                'slug' => 'cardamom-mountains-trekking',
                'description' => 'Embark on an adventurous 3-day trekking expedition through pristine Cardamom Mountains rainforest. Experience wildlife spotting, camp under stars, swim in waterfalls, and explore one of Southeast Asia last great wildernesses.',
                'price' => 399.00,
                'duration_days' => 3,
                'duration_nights' => 2,
                'max_people' => 8,
                'location' => 'Cardamom Mountains, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1200',
                'category_id' => $adventure ? $adventure->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Battambang Countryside Bike Tour',
                'slug' => 'battambang-countryside-bike-tour',
                'description' => 'Cycle through picturesque rice paddies and traditional villages surrounding Battambang. Visit local workshops, ancient temples, and experience authentic rural Cambodian life while enjoying a leisurely bike ride through scenic countryside.',
                'price' => 48.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 10,
                'location' => 'Battambang, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1523948142633-a4b34c067ebb?w=1200',
                'category_id' => $cultural ? $cultural->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Phnom Penh Food Walking Tour',
                'slug' => 'phnom-penh-food-walking-tour',
                'description' => 'Taste your way through vibrant street food scene on this guided culinary adventure. Sample authentic Khmer dishes, tropical fruits, and local delicacies while learning about Cambodian food culture and history.',
                'price' => 42.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 12,
                'location' => 'Phnom Penh, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1200',
                'category_id' => $culinary ? $culinary->id : null,
                'is_active' => true,
            ],
            [
                'title' => 'Preah Vihear Temple Adventure',
                'slug' => 'preah-vihear-temple-adventure',
                'description' => 'Journey to the remote mountaintop temple of Preah Vihear, a UNESCO World Heritage site perched dramatically on cliffs with breathtaking views over Cambodia and Thailand. This full-day adventure combines history, scenery, and cultural immersion.',
                'price' => 125.00,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_people' => 6,
                'location' => 'Preah Vihear, Cambodia',
                'featured_image' => 'https://images.unsplash.com/photo-1548013146-72479768bada?w=1200',
                'category_id' => $cultural ? $cultural->id : null,
                'is_active' => true,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}
