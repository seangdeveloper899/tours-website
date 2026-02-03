<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{

    public function run(): void
    {
        $guides = [
            [
                'name' => 'John Smith',
                'email' => 'john@toursguide.com',
                'phone' => '+1-555-0101',
                'bio' => 'Experienced adventure guide with 10+ years leading mountain expeditions.',
                'languages' => 'English,Spanish,French',
                'rating' => 4.8,
                'total_tours' => 150,
                'is_available' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@toursguide.com',
                'phone' => '+1-555-0102',
                'bio' => 'Cultural heritage expert specializing in historical tours.',
                'languages' => 'Spanish,English',
                'rating' => 4.9,
                'total_tours' => 200,
                'is_available' => true,
            ],
            [
                'name' => 'David Chen',
                'email' => 'david@toursguide.com',
                'phone' => '+1-555-0103',
                'bio' => 'Wildlife photographer and safari guide.',
                'languages' => 'English,Mandarin',
                'rating' => 4.7,
                'total_tours' => 120,
                'is_available' => true,
            ],
            [
                'name' => 'Sokha Chea',
                'email' => 'sokha.chea@cambodiatours.com',
                'phone' => '+855 12 345 678',
                'bio' => 'Experienced tour guide with 8 years of expertise in Angkor Wat and ancient Khmer history. Passionate about sharing Cambodian rich cultural heritage with visitors from around the world.',
                'languages' => 'English, Khmer, French',
                'rating' => 4.9,
                'total_tours' => 156,
                'is_available' => true,
            ],
            [
                'name' => 'Bopha Noun',
                'email' => 'bopha.noun@cambodiatours.com',
                'phone' => '+855 92 456 789',
                'bio' => 'Specializes in cultural tours and culinary experiences. Born and raised in Phnom Penh, introducing travelers to authentic Cambodian cuisine and local traditions.',
                'languages' => 'English, Khmer, Chinese',
                'rating' => 4.8,
                'total_tours' => 143,
                'is_available' => true,
            ],
            [
                'name' => 'Rithy Kong',
                'email' => 'rithy.kong@cambodiatours.com',
                'phone' => '+855 77 567 890',
                'bio' => 'Adventure tour specialist with extensive knowledge of Cambodian wilderness and eco-tourism. Certified in first aid and wilderness survival for safe trekking experiences.',
                'languages' => 'English, Khmer, Japanese',
                'rating' => 4.9,
                'total_tours' => 98,
                'is_available' => true,
            ],
            [
                'name' => 'Chanthy Lim',
                'email' => 'chanthy.lim@cambodiatours.com',
                'phone' => '+855 88 678 901',
                'bio' => 'Expert in Cambodian history, archaeology, and temple architecture. Holds a degree in Khmer Studies and has guided tours at UNESCO sites for over 10 years.',
                'languages' => 'English, Khmer, German',
                'rating' => 5.0,
                'total_tours' => 203,
                'is_available' => true,
            ],
            [
                'name' => 'Veasna Phan',
                'email' => 'veasna.phan@cambodiatours.com',
                'phone' => '+855 95 789 012',
                'bio' => 'Friendly and energetic guide specializing in family tours and photography expeditions. Fluent in multiple languages and experienced in tours for all age groups.',
                'languages' => 'English, Khmer, Spanish, Thai',
                'rating' => 4.7,
                'total_tours' => 127,
                'is_available' => true,
            ],
        ];

        foreach ($guides as $guide) {
            Guide::create($guide);
        }
    }
}
