<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;

class NewsEventsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePageSection::updateOrCreate(
            ['section_key' => 'news_events'],
            [
                'section_type' => 'news_events',
                'title' => 'Upcoming Events & Key Dates',
                'subtitle' => 'Calendar',
                'description' => 'Stay aligned with admission briefings, community gatherings, and student showcases inspired by Duha\'s rhythm.',
                'is_active' => true,
                'sort_order' => 4,
                'data' => [
                    'events_title' => 'Upcoming Events',
                    'events_count' => 3,
                    'show_events' => true,
                    'notices_title' => 'Important Notices',
                    'notices_count' => 3,
                    'show_notices' => true,
                    'cta_text' => 'Download Academic Calendar',
                    'cta_link' => '#calendar',
                    'show_cta' => true,
                    'show_view_all_events' => true,
                    'show_view_all_notices' => true,
                ],
            ]
        );
    }
}
