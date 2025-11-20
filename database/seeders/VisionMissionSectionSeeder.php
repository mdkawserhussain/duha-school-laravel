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
                'description' => 'Rooted in Islamic values and guided by the Qur\'an and Sunnah, we unite world-class Cambridge education with comprehensive Tarbiyah to nurture God-conscious scholars, compassionate leaders, and ethical global citizens.',
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'data' => [
                    'badge_text' => 'Our Islamic Charter',
                    'heading_line1' => 'Nurturing Faith,',
                    'heading_line2' => 'Inspiring Excellence',
                    'vision_title' => 'Our Vision',
                    'vision_text' => 'To be a beacon of Islamic education excellence, cultivating generations of God-conscious learners who embody Taqwa, pursue knowledge with Ihsan, and lead with wisdom, integrity, and compassion to serve humanity and please Allah (SWT).',
                    'mission_title' => 'Our Mission',
                    'mission_text' => 'To provide holistic Islamic education that seamlessly integrates Cambridge academic excellence with Qur\'anic sciences, Arabic mastery, and prophetic character development—preparing students to excel in both Dunya and Akhirah while serving as ambassadors of Islam.',
                    'features' => [
                        ['text' => 'Qur\'an & Sunnah Foundation'],
                        ['text' => 'Cambridge IGCSE & A-Level'],
                        ['text' => 'Hifz, Tajweed & Arabic Excellence'],
                        ['text' => 'Islamic Character & Leadership'],
                        ['text' => 'Service to Ummah & Humanity'],
                    ],
                    'image_title' => 'Our Islamic Campus',
                    'image_subtitle' => 'Where Iman meets Innovation',
                    'values_title' => 'Islamic Core Values',
                    'core_values' => [
                        ['value' => 'Tawheed - Oneness of Allah'],
                        ['value' => 'Taqwa - God Consciousness'],
                        ['value' => 'Ihsan - Excellence in All'],
                        ['value' => 'Amanah - Trust & Responsibility'],
                        ['value' => 'Adab - Prophetic Manners'],
                        ['value' => 'Ilm - Pursuit of Knowledge'],
                        ['value' => 'Sabr - Patience & Perseverance'],
                        ['value' => 'Shukr - Gratitude to Allah'],
                        ['value' => 'Rahmah - Mercy & Compassion'],
                        ['value' => 'Khidmah - Service to Others'],
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ]
        );
    }
}
