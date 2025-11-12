<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;

class HomePageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            // Hero Slide 1 - Robotics Week
            [
                'section_key' => 'hero',
                'section_type' => 'hero',
                'title' => 'AL-MAGHRIB',
                'subtitle' => 'INTERNATIONAL SCHOOL',
                'content' => null,
                'description' => 'Join us for an exciting week of robotics and innovation',
                'button_text' => 'Learn More',
                'button_link' => '/events',
                'data' => [
                    'academic_highlights' => [
                        'Academic: Cambridge Early Years Foundation Stage (Play, Nursery and Reception)',
                        'Islamic Studies',
                        'Cambridge Primary - Key Stage 1 & 2 (Class 1 to 6)',
                        'Character Development Curriculum',
                        'Hifz Curriculum',
                    ],
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            // Hero Slide 2 - Admission Open
            [
                'section_key' => 'hero_2',
                'section_type' => 'hero',
                'title' => 'ADMISSION',
                'subtitle' => 'NOW OPEN',
                'content' => null,
                'description' => 'Enroll your child in a world-class education that combines Cambridge curriculum with Islamic values',
                'button_text' => 'Apply Now',
                'button_link' => '/admission',
                'data' => [
                    'academic_highlights' => [
                        'Cambridge IGCSE & A-Level Programs',
                        'Comprehensive Islamic Education',
                        'Modern Facilities & Technology',
                        'Experienced International Faculty',
                        'Holistic Character Development',
                    ],
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            // Hero Slide 3 - Excellence in Education
            [
                'section_key' => 'hero_3',
                'section_type' => 'hero',
                'title' => 'EXCELLENCE IN',
                'subtitle' => 'EDUCATION',
                'content' => null,
                'description' => 'Nurturing future leaders through academic excellence and Islamic principles',
                'button_text' => 'Discover More',
                'button_link' => '/about/vision',
                'data' => [
                    'academic_highlights' => [
                        'Award-Winning Academic Programs',
                        'State-of-the-Art Learning Facilities',
                        'Dedicated & Qualified Teachers',
                        'Strong Community Values',
                        'Global Recognition & Accreditation',
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'section_key' => 'info_enrollment',
                'section_type' => 'info_block',
                'title' => 'Enrollment News',
                'content' => 'Join our institution. Participate in a universe of excitement and education.',
                'description' => 'Join our institution. Participate in a universe of excitement and education.',
                'button_text' => 'Apply Now',
                'button_link' => '/admission',
                'data' => ['icon' => 'plus'],
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'section_key' => 'info_events',
                'section_type' => 'info_block',
                'title' => 'Regular Events',
                'content' => 'Discover the beauty of regular Islamic events, fostering understanding, unity, and spiritual growth in a nurturing environment.',
                'description' => 'Discover the beauty of regular Islamic events, fostering understanding, unity, and spiritual growth in a nurturing environment.',
                'button_text' => 'View Events',
                'button_link' => '/events',
                'data' => ['icon' => 'calendar'],
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'section_key' => 'info_notice',
                'section_type' => 'info_block',
                'title' => 'Notice Board',
                'content' => 'Stay informed with the latest announcements and upcoming news at Al-Maghrib International School.',
                'description' => 'Stay informed with the latest announcements and upcoming news at Al-Maghrib International School.',
                'button_text' => 'View Notices',
                'button_link' => '/notices',
                'data' => ['icon' => 'megaphone'],
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'section_key' => 'why_choose',
                'section_type' => 'content',
                'title' => 'Why Choose Al-Maghrib',
                'content' => 'Our comprehensive curriculum combines Cambridge education with Islamic values, ensuring students receive a well-rounded education that prepares them for the challenges of the 21st century while maintaining strong Islamic principles. We are committed to fostering global citizens who are grounded in faith and equipped with modern knowledge.',
                'description' => 'Our comprehensive curriculum combines Cambridge education with Islamic values, ensuring students receive a well-rounded education that prepares them for the challenges of the 21st century while maintaining strong Islamic principles.',
                'data' => [
                    'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&h=400&fit=crop',
                ],
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'section_key' => 'children_responsibility',
                'section_type' => 'content',
                'title' => 'Your Children, Our Responsibility',
                'content' => '<p>Welcome to Al-Maghrib International School, established in 2012 in Chittagong, Bangladesh. We are dedicated to providing holistic education that combines academic excellence with moral development.</p><p>Our commitment extends beyond the classroom, focusing on Islamic values and Cambridge curriculum integration to nurture well-rounded individuals who excel both academically and spiritually.</p>',
                'description' => 'Welcome to Al-Maghrib International School, established in 2012 in Chittagong, Bangladesh. We are dedicated to providing holistic education that combines academic excellence with moral development.',
                'data' => [
                    'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop',
                ],
                'sort_order' => 14,
                'is_active' => true,
            ],
            [
                'section_key' => 'values',
                'section_type' => 'list',
                'title' => 'Our Values',
                'content' => null,
                'description' => 'Core values that guide our institution',
                'data' => [
                    'values' => [
                        'Tawheed & God Consciousness',
                        'Courage',
                        'Charitable',
                        'Patience',
                        'Consultation',
                        'Hard Work',
                        'Respect',
                        'Excellence',
                        'Discipline',
                        'Humility',
                        'Gratitude',
                        'Resistance to Evil',
                        'Self-Control',
                        'Unity in Diversity',
                        'Dependency',
                        'Honesty',
                    ],
                ],
                'sort_order' => 15,
                'is_active' => true,
            ],
            [
                'section_key' => 'advisors',
                'section_type' => 'advisors',
                'title' => 'Here are Our Advisors',
                'subtitle' => 'Distinguished scholars and educators guiding our institution',
                'content' => null,
                'description' => null,
                'data' => [
                    'advisors' => [
                        [
                            'name' => 'SHEIKH DR. MAHMUDUL HASAN AL-AZHARI',
                            'title' => 'CHIEF ADVISOR',
                            'description' => 'Khateeb & Principal, Green Lane Masjid & Islamic Centre, London, UK',
                            'subtitle' => 'Former Professor, University of Chittagong, Bangladesh',
                        ],
                        [
                            'name' => 'DR. GOLAM QUADER CHY NOBEL',
                            'title' => 'ADVISOR',
                            'description' => 'MBBS, MD (in CVTS), PgD (Mgmt) (UK), PGDip (Public Health & Medicine) (UK), CCT (UK), CCD (Member of the Royal College of Physicians), London, UK',
                            'subtitle' => 'Chairman, Royal Primary Health Institute, Bangladesh',
                        ],
                        [
                            'name' => 'PROFESSOR KHANDAKAR KABIR UDDIN',
                            'title' => 'ADVISOR',
                            'description' => 'Chairman & Principal, Manarat Foundation Islamic Center, Mirpur, Dhaka, Bangladesh',
                            'subtitle' => 'Former Professor, Islamic University, Bangladesh',
                        ],
                    ],
                ],
                'sort_order' => 16,
                'is_active' => true,
            ],
            [
                'section_key' => 'video_1',
                'section_type' => 'video',
                'title' => 'Academic Director & CEO',
                'subtitle' => 'Let\'s hear from our Academic Director & CEO, Md. Neazul Hoque',
                'content' => null,
                'description' => null,
                'data' => [
                    'video_url' => null,
                    'youtube_url' => null,
                ],
                'sort_order' => 17,
                'is_active' => true,
            ],
            [
                'section_key' => 'video_2',
                'section_type' => 'video',
                'title' => 'Inter-School Quran Competition',
                'subtitle' => 'Let\'s relive the spirit of the Inter-School Quran Competition!',
                'content' => null,
                'description' => null,
                'data' => [
                    'video_url' => null,
                    'youtube_url' => 'https://www.youtube.com/watch?v=example',
                ],
                'sort_order' => 18,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomePageSection::firstOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
