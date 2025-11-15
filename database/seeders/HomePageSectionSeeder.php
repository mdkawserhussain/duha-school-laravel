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
                'title' => 'DUHA',
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
                'sort_order' => 11,
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
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'section_key' => 'info_notice',
                'section_type' => 'info_block',
                'title' => 'Notice Board',
                'content' => 'Stay informed with the latest announcements and upcoming news at Duha International School.',
                'description' => 'Stay informed with the latest announcements and upcoming news at Duha International School.',
                'button_text' => 'View Notices',
                'button_link' => '/notices',
                'data' => ['icon' => 'megaphone'],
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'section_key' => 'why_choose',
                'section_type' => 'content',
                'title' => 'Why Choose Duha',
                'content' => 'Our comprehensive curriculum combines Cambridge education with Islamic values, ensuring students receive a well-rounded education that prepares them for the challenges of the 21st century while maintaining strong Islamic principles. We are committed to fostering global citizens who are grounded in faith and equipped with modern knowledge.',
                'description' => 'Our comprehensive curriculum combines Cambridge education with Islamic values, ensuring students receive a well-rounded education that prepares them for the challenges of the 21st century while maintaining strong Islamic principles.',
                'data' => [
                    'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&h=400&fit=crop',
                ],
                'sort_order' => 14,
                'is_active' => true,
            ],
            [
                'section_key' => 'children_responsibility',
                'section_type' => 'content',
                'title' => 'Your Children, Our Responsibility',
                'content' => '<p>Welcome to Duha International School, established in 2012 in Chittagong, Bangladesh. We are dedicated to providing holistic education that combines academic excellence with moral development.</p><p>Our commitment extends beyond the classroom, focusing on Islamic values and Cambridge curriculum integration to nurture well-rounded individuals who excel both academically and spiritually.</p>',
                'description' => 'Welcome to Duha International School, established in 2012 in Chittagong, Bangladesh. We are dedicated to providing holistic education that combines academic excellence with moral development.',
                'data' => [
                    'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop',
                ],
                'sort_order' => 15,
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
                'sort_order' => 16,
                'is_active' => true,
            ],
            [
                'section_key' => 'advisors',
                'section_type' => 'advisors',
                'title' => 'Advisors & Board of Governors',
                'subtitle' => 'Leadership',
                'content' => null,
                'description' => 'Distinguished scholars, Cambridge examiners, and community leaders steward our Islamic ethos and academic rigor.',
                'data' => [
                    'advisors' => [
                        [
                            'name' => 'Dr. Samira Ameen',
                            'role' => 'Chair, Board of Governors',
                            'bio' => 'Former Cambridge examiner & Islamic pedagogy researcher.',
                            'image' => 'images/advisors/samira.svg',
                            'linkedin' => '#'
                        ],
                        [
                            'name' => 'Sheikh Farid Rahman',
                            'role' => 'Religious Advisor',
                            'bio' => 'Graduate of Al-Azhar, leads Quran sciences curriculum.',
                            'image' => 'images/advisors/farid.svg',
                            'linkedin' => '#'
                        ],
                        [
                            'name' => 'Md. Kawser Hussain',
                            'role' => 'Founder & Advisor',
                            'bio' => 'Visionary behind AISD-inspired transformation.',
                            'image' => 'images/advisors/kawser.svg',
                            'linkedin' => '#'
                        ],
                        [
                            'name' => 'Ayesha Siddiqua',
                            'role' => 'Academic Director',
                            'bio' => 'Leads STEAM integration across Middle & Senior school.',
                            'image' => 'images/advisors/ayesha.svg',
                            'linkedin' => '#'
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
            // Achievements Section
            [
                'section_key' => 'achievements',
                'section_type' => 'achievements',
                'title' => 'Recognising Our Learners',
                'subtitle' => 'Highlights',
                'content' => null,
                'description' => 'From Qur\'an recitation championships to Cambridge distinctions, our students lead locally and globally.',
                'data' => [
                    'subtitle' => 'Highlights',
                    'achievements' => [
                        [
                            'title' => 'Cambridge Top Achievers',
                            'copy' => 'Multiple "Top in Bangladesh" awards in Mathematics & English.',
                            'badge' => 'IGCSE',
                            'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                        ],
                        [
                            'title' => 'International Quran Recital',
                            'copy' => 'Gold medal at the 2024 Kuala Lumpur Tilawah.',
                            'badge' => 'Hifz',
                            'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'
                        ],
                        [
                            'title' => 'STEM Innovation Fair',
                            'copy' => 'Solar desalination project crowned champion at city science fair.',
                            'badge' => 'STEM',
                            'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
                        ],
                        [
                            'title' => 'Model OIC Summit',
                            'copy' => 'Best Delegate recognition for our secondary students.',
                            'badge' => 'Leadership',
                            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                        ],
                    ],
                ],
                'sort_order' => 4,
                'is_active' => true,
            ],
            // Stats Main Section
            [
                'section_key' => 'stats_main',
                'section_type' => 'stats',
                'title' => 'Our School in Numbers',
                'subtitle' => null,
                'content' => null,
                'description' => 'A snapshot of growth across our Cambridge and Islamic streams.',
                'data' => [
                    'subtitle' => 'Impact',
                    'stats' => [
                        [
                            'label' => 'Students',
                            'value' => '1200+',
                            'copy' => 'Across Early Years to A-Level',
                            'icon' => 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z'
                        ],
                        [
                            'label' => 'Teachers',
                            'value' => '85',
                            'copy' => 'Certified international faculty',
                            'icon' => 'M5 13l4 4L19 7'
                        ],
                        [
                            'label' => 'Years',
                            'value' => '15+',
                            'copy' => 'Established excellence',
                            'icon' => 'M9 12l2 2 4-4'
                        ],
                        [
                            'label' => 'Success Rate',
                            'value' => '98%',
                            'copy' => 'IGCSE & A-Level results',
                            'icon' => 'M5 13l4 4L19 7'
                        ],
                    ],
                    'cta' => [
                        'title' => 'Join a community grounded in faith and excellence.',
                        'button1' => [
                            'text' => 'Schedule a Visit',
                            'link' => '/campus'
                        ],
                        'button2' => [
                            'text' => 'Talk to Admissions',
                            'link' => '/admission'
                        ],
                    ],
                ],
                'sort_order' => 5,
                'is_active' => true,
            ],
            // Parallax Experience Section
            [
                'section_key' => 'parallax_experience',
                'section_type' => 'parallax',
                'title' => null,
                'subtitle' => null,
                'content' => null,
                'description' => null,
                'data' => [
                    'badge' => 'Experience',
                    'title' => 'Where tradition meets innovation every school day.',
                    'description' => 'Borrowing AISD\'s parallax rhythm, this slice of campus life highlights collaborative learning pods, Arabic storytelling corners, and maker labs.',
                    'feature_pills' => [
                        ['text' => 'Dedicated Musalla & Hifz Pods'],
                        ['text' => 'Robotics & Design Thinking Lab'],
                        ['text' => 'Outdoor Play Courts'],
                    ],
                    'cta' => [
                        'text' => 'Explore Our Campus',
                        'link' => '/campus'
                    ],
                ],
                'sort_order' => 8,
                'is_active' => true,
            ],
            // Competitions Section
            [
                'section_key' => 'competitions',
                'section_type' => 'competitions',
                'title' => 'Excellence in Academic & Islamic Pursuits',
                'subtitle' => null,
                'content' => null,
                'description' => 'Celebrating our students\' achievements in tournaments, Olympiads, and Qur\'anic competitions that showcase both knowledge and character.',
                'data' => [
                    'title' => 'Excellence in Academic & Islamic Pursuits',
                    'description' => 'Celebrating our students\' achievements in tournaments, Olympiads, and Qur\'anic competitions that showcase both knowledge and character.',
                    'competitions' => [
                        [
                            'title' => 'Arabic Oratory League',
                            'copy' => 'Students deliver khutbah-style speeches judged by scholars, developing eloquence and understanding of Islamic principles.',
                            'gradient' => 'linear-gradient(135deg, #173B7A, #0F224C)',
                            'iconBg' => '#173B7A',
                            'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'
                        ],
                        [
                            'title' => 'Mathematics Olympiad',
                            'copy' => 'Regional gold in junior category with perfect logic scores, demonstrating analytical excellence and problem-solving prowess.',
                            'gradient' => 'linear-gradient(135deg, #0C1B3D, #173B7A)',
                            'iconBg' => '#0C1B3D',
                            'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                        ],
                        [
                            'title' => 'Qira\'ah Championship',
                            'copy' => 'National runner-up with flawless maqamat transitions, honoring the beauty and precision of Qur\'anic recitation.',
                            'gradient' => 'linear-gradient(135deg, #0F224C, #0C1B3D)',
                            'iconBg' => '#0F224C',
                            'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'
                        ],
                    ],
                ],
                'sort_order' => 9,
                'is_active' => true,
            ],
            // Academic Programs Section
            [
                'section_key' => 'academic_programs',
                'section_type' => 'programs',
                'title' => 'Our Academic Programs',
                'subtitle' => null,
                'content' => null,
                'description' => 'Comprehensive educational pathways designed to nurture intellectual growth, spiritual development, and global competency from early years through secondary education.',
                'data' => [
                    'subtitle' => 'Academic Excellence',
                    'title' => 'Our Academic Programs',
                    'description' => 'Comprehensive educational pathways designed to nurture intellectual growth, spiritual development, and global competency from early years through secondary education.',
                    'programs' => [
                        [
                            'title' => 'Early Years Foundation',
                            'grade_range' => 'Play, Nursery, Reception',
                            'description' => 'Cambridge Early Years Foundation Stage curriculum with Islamic values integration, focusing on play-based learning and character development.',
                            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'icon_bg_color' => '#6EC1F5',
                            'features' => [
                                ['text' => 'Play-based learning approach'],
                                ['text' => 'Qur\'an & Arabic introduction'],
                                ['text' => 'Character building activities'],
                                ['text' => 'Cambridge assessment framework'],
                            ],
                        ],
                        [
                            'title' => 'Cambridge Primary',
                            'grade_range' => 'Class 1 to 6',
                            'description' => 'Cambridge Primary curriculum (Key Stage 1 & 2) with comprehensive Islamic Studies, Arabic language, and Hifz program options.',
                            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                            'icon_bg_color' => '#173B7A',
                            'features' => [
                                ['text' => 'Cambridge Primary Checkpoint'],
                                ['text' => 'Integrated Islamic curriculum'],
                                ['text' => 'Hifz & Nazira tracks'],
                                ['text' => 'STEAM enrichment programs'],
                            ],
                        ],
                        [
                            'title' => 'Cambridge Secondary',
                            'grade_range' => 'Class 7 to 10',
                            'description' => 'Cambridge Lower Secondary and IGCSE programs with advanced Islamic Studies, preparing students for international qualifications.',
                            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'icon_bg_color' => '#0C1B3D',
                            'features' => [
                                ['text' => 'Cambridge IGCSE preparation'],
                                ['text' => 'Advanced Islamic Sciences'],
                                ['text' => 'Leadership development'],
                                ['text' => 'Career guidance & counseling'],
                            ],
                        ],
                        [
                            'title' => 'Cambridge A-Level',
                            'grade_range' => 'Class 11 to 12',
                            'description' => 'Advanced Level program with subject specialization, Islamic leadership training, and university preparation.',
                            'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                            'icon_bg_color' => '#F4C430',
                            'features' => [
                                ['text' => 'AS & A-Level qualifications'],
                                ['text' => 'Subject specialization'],
                                ['text' => 'University preparation'],
                                ['text' => 'Islamic leadership program'],
                            ],
                        ],
                    ],
                    'special_features' => [
                        'title' => 'Beyond the Classroom',
                        'description' => 'Our holistic approach extends beyond academics, offering specialized programs that develop character, leadership, and global citizenship.',
                        'features' => [
                            [
                                'title' => 'Hifz Program',
                                'subtitle' => 'Qur\'an Memorization',
                                'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'
                            ],
                            [
                                'title' => 'STEAM Labs',
                                'subtitle' => 'Innovation & Design',
                                'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
                            ],
                            [
                                'title' => 'Leadership',
                                'subtitle' => 'Service Learning',
                                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                            ],
                            [
                                'title' => 'Arabic Excellence',
                                'subtitle' => 'Language Mastery',
                                'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'
                            ],
                        ],
                        'cta' => [
                            'text' => 'Explore Programs',
                            'link' => '/academics'
                        ],
                    ],
                ],
                'sort_order' => 10,
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
