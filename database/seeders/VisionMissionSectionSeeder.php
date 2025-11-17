<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;

class VisionMissionSectionSeeder extends Seeder
{
    public function run(): void
    {
        HomePageSection::updateOrCreate(
            ['section_key' => 'vision'],
            [
                'section_type' => 'vision_mission',
                'title' => null,
                'subtitle' => null,
                'description' => 'We follow the footsteps of Duha with a distinctly Islamic ethos—uniting rigorous academics and tarbiyah to nurture resilient, compassionate leaders.',
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'data' => [
                    'badge_text' => 'Our Charter',
                    'heading_line1' => 'Empowering Minds,',
                    'heading_line2' => 'Enriching Hearts',
                    'vision_title' => 'Vision',
                    'vision_text' => 'To cultivate God-conscious learners who lead with integrity and scholarship across the globe.',
                    'mission_title' => 'Mission',
                    'mission_text' => 'Deliver Cambridge excellence infused with Qur\'anic sciences, Arabic, and service learning pathways.',
                    'features' => [
                        ['text' => 'Cambridge Primary to A-Level'],
                        ['text' => 'Hifz & Nazira Tracks'],
                        ['text' => 'Leadership & Service Labs'],
                    ],
                    'image_title' => 'Our Campus',
                    'image_subtitle' => 'Where tradition meets innovation',
                    'values_title' => 'Core Values',
                    'core_values' => [
                        ['value' => 'Ihsan in every lesson'],
                        ['value' => 'Amanah & compassion'],
                        ['value' => 'Lifelong inquiry'],
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ]
        );
    }
}
