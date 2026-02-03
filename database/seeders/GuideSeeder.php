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
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@toursguide.com',
                'phone' => '+1-555-0102',
                'bio' => 'Cultural heritage expert specializing in historical tours.',
                'languages' => 'Spanish,English',
                'rating' => 4.9,
                'total_tours' => 200,
            ],
            [
                'name' => 'David Chen',
                'email' => 'david@toursguide.com',
                'phone' => '+1-555-0103',
                'bio' => 'Wildlife photographer and safari guide.',
                'languages' => 'English,Mandarin',
                'rating' => 4.7,
                'total_tours' => 120,
            ],
        ];

        foreach ($guides as $guide) {
            Guide::create($guide);
        }
    }
}
