<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing navigation items
        NavigationItem::truncate();

        // Main Navigation Items
        $mainNav = [
            [
                'title' => 'Home',
                'route_name' => 'home',
                'icon' => 'heroicon-o-home',
                'sort_order' => 1,
                'section' => 'main',
            ],
            [
                'title' => 'About Us',
                'route_name' => 'about.index',
                'icon' => 'heroicon-o-information-circle',
                'sort_order' => 2,
                'section' => 'main',
            ],
            [
                'title' => 'Academics',
                'route_name' => 'academics.index',
                'icon' => 'heroicon-o-academic-cap',
                'sort_order' => 3,
                'section' => 'main',
            ],
            [
                'title' => 'Facilities',
                'route_name' => 'facilities.index',
                'icon' => 'heroicon-o-building-office',
                'sort_order' => 4,
                'section' => 'main',
            ],
            [
                'title' => 'Activities & Programs',
                'route_name' => 'activities.index',
                'icon' => 'heroicon-o-sparkles',
                'sort_order' => 5,
                'section' => 'main',
            ],
            [
                'title' => 'Admissions',
                'route_name' => 'admissions.index',
                'icon' => 'heroicon-o-clipboard-document-check',
                'sort_order' => 6,
                'section' => 'main',
            ],
            [
                'title' => 'Parent Engagement',
                'route_name' => 'parent-engagement.index',
                'icon' => 'heroicon-o-users',
                'sort_order' => 7,
                'section' => 'main',
            ],
            [
                'title' => 'Events',
                'route_name' => 'events.index',
                'icon' => 'heroicon-o-calendar',
                'sort_order' => 8,
                'section' => 'main',
            ],
            [
                'title' => 'Notices',
                'route_name' => 'notices.index',
                'icon' => 'heroicon-o-megaphone',
                'sort_order' => 9,
                'section' => 'main',
            ],
            [
                'title' => 'Contact',
                'route_name' => 'contact.index',
                'icon' => 'heroicon-o-envelope',
                'sort_order' => 10,
                'section' => 'main',
            ],
        ];

        // Store created parent items for child relationships
        $parentItems = [];

        foreach ($mainNav as $item) {
            $parentItem = NavigationItem::create(array_merge($item, [
                'is_active' => true,
                'is_external' => false,
                'target_blank' => false,
            ]));
            $parentItems[$item['title']] = $parentItem;
        }

        // Create child navigation items for dropdown menus
        // About Us Children
        if (isset($parentItems['About Us'])) {
            $aboutUsChildren = [
                ['title' => 'Vision, Mission & Core Values', 'route_name' => null, 'slug' => 'vision-mission-core-values', 'sort_order' => 1],
                ['title' => 'Founder & Director\'s Message', 'route_name' => null, 'slug' => 'founder-director-message', 'sort_order' => 2],
                ['title' => 'Principal\'s Message', 'route_name' => null, 'slug' => 'principal-message', 'sort_order' => 3],
                ['title' => 'Key Features', 'route_name' => null, 'slug' => 'key-features', 'sort_order' => 4],
                ['title' => 'Our Team', 'route_name' => null, 'slug' => 'our-team', 'sort_order' => 5],
            ];
            
            foreach ($aboutUsChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['About Us']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Academics Children
        if (isset($parentItems['Academics'])) {
            $academicsChildren = [
                ['title' => 'Hifzul Quran Program', 'route_name' => null, 'slug' => 'hifzul-quran-program', 'sort_order' => 1],
                ['title' => 'Islamic Curriculum', 'route_name' => null, 'slug' => 'islamic-curriculum', 'sort_order' => 2],
                ['title' => 'National Curriculum (English Version)', 'route_name' => null, 'slug' => 'national-curriculum-english', 'sort_order' => 3],
                ['title' => 'Cambridge + Islamic Curriculum', 'route_name' => null, 'slug' => 'cambridge-islamic-curriculum', 'sort_order' => 4],
                ['title' => 'Academic Enrichment', 'route_name' => null, 'slug' => 'academic-enrichment', 'sort_order' => 5],
            ];
            
            foreach ($academicsChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Academics']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Activities & Programs Children
        if (isset($parentItems['Activities & Programs'])) {
            $activitiesChildren = [
                ['title' => 'Islamic Activities', 'route_name' => null, 'slug' => 'islamic-activities', 'sort_order' => 1],
                ['title' => 'Academic Enrichment', 'route_name' => null, 'slug' => 'academic-enrichment-activities', 'sort_order' => 2],
                ['title' => 'Arts, Culture & Nasheed', 'route_name' => null, 'slug' => 'arts-culture-nasheed', 'sort_order' => 3],
                ['title' => 'Sports & Physical Education', 'route_name' => null, 'slug' => 'sports-physical-education', 'sort_order' => 4],
                ['title' => 'Life Skills & Community Service', 'route_name' => null, 'slug' => 'life-skills-community-service', 'sort_order' => 5],
                ['title' => 'Technology & Innovation', 'route_name' => null, 'slug' => 'technology-innovation', 'sort_order' => 6],
                ['title' => 'Annual Cultural Program', 'route_name' => null, 'slug' => 'annual-cultural-program', 'sort_order' => 7],
            ];
            
            foreach ($activitiesChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Activities & Programs']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Admissions Children
        if (isset($parentItems['Admissions'])) {
            $admissionsChildren = [
                ['title' => 'Admission Procedure', 'route_name' => null, 'slug' => 'admission-procedure', 'sort_order' => 1],
                ['title' => 'Fee Structure – National Curriculum', 'route_name' => null, 'slug' => 'fee-structure-national', 'sort_order' => 2],
                ['title' => 'Fee Structure – Cambridge Curriculum', 'route_name' => null, 'slug' => 'fee-structure-cambridge', 'sort_order' => 3],
                ['title' => 'Class Timings', 'route_name' => null, 'slug' => 'class-timings', 'sort_order' => 4],
                ['title' => 'Grades & Subjects Overview', 'route_name' => null, 'slug' => 'grades-subjects', 'sort_order' => 5],
                ['title' => 'Transport Fees & Policy', 'route_name' => null, 'slug' => 'transport-fees-policy', 'sort_order' => 6],
                ['title' => 'Download Admission Form (PDF)', 'route_name' => null, 'slug' => 'download-admission-form', 'sort_order' => 7],
            ];
            
            foreach ($admissionsChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Admissions']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Footer Navigation Items
        $footerNav = [
            [
                'title' => 'Privacy Policy',
                'route_name' => 'privacy.show',
                'sort_order' => 1,
                'section' => 'footer',
            ],
            [
                'title' => 'Terms of Service',
                'route_name' => 'terms.show',
                'sort_order' => 2,
                'section' => 'footer',
            ],
            [
                'title' => 'Gallery',
                'route_name' => 'media.gallery',
                'sort_order' => 3,
                'section' => 'footer',
            ],
        ];

        foreach ($footerNav as $item) {
            NavigationItem::create(array_merge($item, [
                'is_active' => true,
                'is_external' => false,
                'target_blank' => false,
            ]));
        }
    }
}