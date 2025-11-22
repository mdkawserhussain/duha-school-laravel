<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use App\Models\HomePageSection;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ZaitoonContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder populates Zaitoon Academy-specific content.
     */
    public function run(): void
    {
        $this->command->info('Seeding Zaitoon Academy content...');

        // 1. Update Site Settings
        $this->updateSiteSettings();

        // 2. Update Hero Slides
        $this->updateHeroSlides();

        // 3. Update Introduction Section
        $this->updateIntroductionSection();

        // 4. Update Testimonials Section
        $this->updateTestimonialsSection();

        // 5. Update Partners Section
        $this->updatePartnersSection();

        // 6. Update Videos Section
        $this->updateVideosSection();

        // 7. Update Chairman/Staff
        $this->updateChairman();

        $this->command->info('Zaitoon Academy content seeded successfully!');
    }

    protected function updateSiteSettings(): void
    {
        $this->command->info('Updating site settings...');

        $settings = SiteSettings::first();
        if ($settings) {
            $settings->update([
                'website_name' => 'Zaitoon Academy',
                'website_tagline' => 'Nurturing Brilliance, One Child at a Time',
                'website_description' => 'Zaitoon Academy was established with the vision of providing quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.',
                'site_name' => 'Zaitoon Academy',
                'site_description' => 'Zaitoon Academy was established with the vision of providing quality Islamic and modern education.',
                
                // Contact Information (from reference image)
                'primary_email' => 'info@zaitoonacademy.com',
                'secondary_email' => 'zaitoonacademy1@gmail.com',
                'primary_phone' => '+880 1748306492',
                'secondary_phone' => '+880 1708933187',
                'physical_address' => 'Jalalabad H/S, Jalalabad Housing Society, Sector-1, Road-1, House-10, Khulshi, Chattogram, Bangladesh',
                'business_hours' => "Sunday - Thursday\n8:00 AM - 2:00 PM\n\nFriday & Saturday\nClosed",
                
                // Social Media Links
                'social_media_links' => [
                    'facebook' => 'https://www.facebook.com/zaitoonacademy',
                    'twitter' => null,
                    'instagram' => 'https://www.instagram.com/zaitoonacademy',
                    'youtube' => 'https://www.youtube.com/@zaitoonacademy',
                    'linkedin' => 'https://www.linkedin.com/company/zaitoonacademy',
                ],
                
                // SEO Settings
                'meta_title' => 'Zaitoon Academy - Nurturing Brilliance, One Child at a Time',
                'meta_description' => 'Zaitoon Academy provides quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.',
                'meta_keywords' => 'Zaitoon Academy, Islamic Education, Modern Education, Chattogram, Bangladesh, Islamic School',
                'og_title' => 'Zaitoon Academy - Nurturing Brilliance, One Child at a Time',
                'og_description' => 'Zaitoon Academy provides quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.',
                
                // Brand Colors (Zaitoon Green and Yellow)
                'primary_color' => '#1a5e4a', // za-green-primary
                'secondary_color' => '#0f3d30', // za-green-dark
                'accent_color' => '#fbbf24', // za-yellow-accent
                
                // Copyright
                'copyright_notice' => '© {year} Zaitoon Academy. All Rights Reserved.',
            ]);
        } else {
            SiteSettings::create([
                'website_name' => 'Zaitoon Academy',
                'website_tagline' => 'Nurturing Brilliance, One Child at a Time',
                'website_description' => 'Zaitoon Academy was established with the vision of providing quality Islamic and modern education.',
                'primary_email' => 'info@zaitoonacademy.com',
                'primary_phone' => '+880 1748306492',
                'physical_address' => 'Jalalabad H/S, Jalalabad Housing Society, Sector-1, Road-1, House-10, Khulshi, Chattogram, Bangladesh',
                'primary_color' => '#1a5e4a',
                'secondary_color' => '#0f3d30',
                'accent_color' => '#fbbf24',
            ]);
        }
    }

    protected function updateHeroSlides(): void
    {
        $this->command->info('Updating hero slides...');

        $heroSlides = [
            [
                'section_key' => 'hero',
                'title' => 'Nurturing Brilliance,',
                'subtitle' => 'One Child at a Time',
                'description' => 'Zaitoon Academy provides quality Islamic and modern education that nurtures future leaders with strong moral character and academic excellence.',
                'button_text' => 'Learn More',
                'button_link' => '/about-us',
                'data' => [
                    'badge' => 'Welcome',
                ],
                'sort_order' => 1,
            ],
            [
                'section_key' => 'hero_2',
                'title' => 'Eat healthy',
                'subtitle' => 'Stay healthy',
                'description' => 'Promoting healthy living and nutrition awareness among our students through educational programs and activities.',
                'button_text' => 'View Activities',
                'button_link' => '/events',
                'data' => [
                    'badge' => 'Health & Wellness',
                ],
                'sort_order' => 2,
            ],
            [
                'section_key' => 'hero_3',
                'title' => 'Admission',
                'subtitle' => 'Open Now',
                'description' => 'Enroll your child in a world-class education that combines Islamic values with modern academic excellence.',
                'button_text' => 'Apply Online',
                'button_link' => '/admission',
                'data' => [
                    'badge' => 'Admissions',
                ],
                'sort_order' => 3,
            ],
        ];

        foreach ($heroSlides as $slide) {
            HomePageSection::updateOrCreate(
                ['section_key' => $slide['section_key']],
                array_merge($slide, [
                    'section_type' => 'hero',
                    'content' => null,
                    'is_active' => true,
                ])
            );
        }
    }

    protected function updateIntroductionSection(): void
    {
        $this->command->info('Updating introduction section...');

        HomePageSection::updateOrCreate(
            ['section_key' => 'introduction'],
            [
                'section_type' => 'content',
                'title' => 'To create a group of specialized Islamic scholars.',
                'description' => 'Zaitoon Academy was established with the vision of providing quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.',
                'content' => '<p>Zaitoon Academy was conceived with a clear vision: to create a group of specialized Islamic scholars who are well-versed in both traditional Islamic knowledge and modern academic disciplines. Our founders recognized the need for an educational institution that bridges the gap between Islamic scholarship and contemporary learning.</p><p>The academy commenced its operations with a commitment to excellence in both Islamic and modern education. We believe that true education must encompass both spiritual and intellectual development, preparing students to excel in this world while maintaining strong connections to their faith and values.</p>',
                'button_text' => 'Read More',
                'button_link' => '/about-us',
                'data' => [],
                'sort_order' => 10,
                'is_active' => true,
            ]
        );
    }

    protected function updateTestimonialsSection(): void
    {
        $this->command->info('Updating testimonials section...');

        $testimonials = [
            [
                'quote' => 'Zaitoon Academy has provided excellent education for my child. The combination of Islamic and modern curriculum is outstanding. My child has shown remarkable improvement in both academic performance and character development.',
                'author' => 'Md. Shamimul Islam',
                'role' => 'Parent',
                'avatar' => null,
            ],
            [
                'quote' => 'As a parent, I am impressed by the dedication of the teachers and the holistic approach to education. The school truly nurtures both academic excellence and Islamic values.',
                'author' => 'Fatima Begum',
                'role' => 'Parent',
                'avatar' => null,
            ],
            [
                'quote' => 'Zaitoon Academy has created a perfect balance between Islamic education and modern learning. My children are thriving academically while maintaining strong Islamic principles.',
                'author' => 'Ahmed Hassan',
                'role' => 'Parent',
                'avatar' => null,
            ],
        ];

        HomePageSection::updateOrCreate(
            ['section_key' => 'testimonials'],
            [
                'section_type' => 'testimonials',
                'title' => 'What Parents Say About Zaitoon Academy',
                'description' => 'Hear from parents about their experience with Zaitoon Academy',
                'data' => [
                    'testimonials' => $testimonials,
                ],
                'sort_order' => 20,
                'is_active' => true,
            ]
        );
    }

    protected function updatePartnersSection(): void
    {
        $this->command->info('Updating partners section...');

        $partners = [
            [
                'name' => 'SADAGAH',
                'logo' => null,
                'link' => '#',
            ],
            [
                'name' => 'ILANNOOR INSTITUTE',
                'logo' => null,
                'link' => '#',
            ],
            [
                'name' => 'VISION',
                'logo' => null,
                'link' => '#',
            ],
        ];

        HomePageSection::updateOrCreate(
            ['section_key' => 'partners'],
            [
                'section_type' => 'partners',
                'title' => 'Our Partners',
                'description' => 'We are proud to be associated with leading organizations worldwide.',
                'data' => [
                    'partners' => $partners,
                ],
                'sort_order' => 21,
                'is_active' => true,
            ]
        );
    }

    protected function updateVideosSection(): void
    {
        $this->command->info('Updating videos section...');

        $recentVideos = [
            [
                'title' => 'Upgrade Your Islamic Vocabularies | NUSAIFA AMATULLAH ASMATH & Sayra Binte Glas | Class Two',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder - replace with actual YouTube ID
                'thumbnail' => null,
            ],
            [
                'title' => 'Arabic Speech by Afra Binte Aman on My Hobby',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder
                'thumbnail' => null,
            ],
            [
                'title' => 'Hadith Memorization Exam | Azhar Md. Muhtadi Amin | Student of Tafheez Section',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder
                'thumbnail' => null,
            ],
        ];

        HomePageSection::updateOrCreate(
            ['section_key' => 'videos'],
            [
                'section_type' => 'videos',
                'title' => 'Recent Videos',
                'description' => 'Watch our latest videos showcasing student achievements and activities',
                'data' => [
                    'main_video' => [
                        'title' => 'Upgrade Your Islamic Vocabularies',
                        'youtube_id' => 'dQw4w9WgXcQ', // Placeholder
                        'thumbnail' => null,
                    ],
                    'recent_videos' => $recentVideos,
                ],
                'sort_order' => 19,
                'is_active' => true,
            ]
        );
    }

    protected function updateChairman(): void
    {
        $this->command->info('Updating chairman information...');

        // Update or create chairman staff member
        Staff::updateOrCreate(
            [
                'position' => 'Chairman',
            ],
            [
                'name' => 'Chairman',
                'position' => 'Chairman',
                'bio' => 'Zaitoon Academy is committed to providing excellence in both Islamic and modern education. Our curriculum is designed to nurture well-rounded individuals who excel academically while maintaining strong Islamic values. We believe in creating a learning environment where students can grow intellectually, spiritually, and morally, preparing them to be future leaders who contribute positively to society.',
                'email' => 'chairman@zaitoonacademy.com',
                'phone' => '+880 1748306492',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Also create a Principal if needed
        Staff::updateOrCreate(
            [
                'position' => 'Principal',
            ],
            [
                'name' => 'Principal',
                'position' => 'Principal',
                'bio' => 'Leading Zaitoon Academy with dedication and commitment to educational excellence.',
                'email' => 'principal@zaitoonacademy.com',
                'phone' => '+880 1748306492',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}

