<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{

    public function run(): void
    {
        $settings = [

            ['key' => 'site_name', 'value' => 'Tours Website', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Discover Your Next Adventure', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Book amazing tours and experiences worldwide', 'type' => 'text', 'group' => 'general'],

            ['key' => 'contact_email', 'value' => 'info@tourswebsite.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+1-555-TOURS', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '123 Travel Street, City, Country', 'type' => 'text', 'group' => 'contact'],

            ['key' => 'facebook_url', 'value' => 'https://facebook.com/tourswebsite', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/tourswebsite', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/tourswebsite', 'type' => 'text', 'group' => 'social'],

            ['key' => 'booking_advance_days', 'value' => '2', 'type' => 'number', 'group' => 'booking'],
            ['key' => 'cancellation_hours', 'value' => '24', 'type' => 'number', 'group' => 'booking'],
            ['key' => 'featured_tours_count', 'value' => '6', 'type' => 'number', 'group' => 'display'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
