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
                'slug' => null,
                'icon' => 'heroicon-o-home',
                'sort_order' => 1,
                'section' => 'main',
            ],
            [
                'title' => 'About',
                'route_name' => null,
                'slug' => 'about',
                'icon' => 'heroicon-o-information-circle',
                'sort_order' => 2,
                'section' => 'main',
            ],
            [
                'title' => 'Admission',
                'route_name' => null,
                'slug' => 'admission',
                'icon' => 'heroicon-o-clipboard-document-check',
                'sort_order' => 3,
                'section' => 'main',
            ],
            [
                'title' => 'Academic',
                'route_name' => null,
                'slug' => 'academic',
                'icon' => 'heroicon-o-academic-cap',
                'sort_order' => 4,
                'section' => 'main',
            ],
            [
                'title' => 'Faculty',
                'route_name' => null,
                'slug' => 'faculty',
                'icon' => 'heroicon-o-users',
                'sort_order' => 5,
                'section' => 'main',
            ],
            [
                'title' => 'Facilities',
                'route_name' => null,
                'slug' => 'facilities',
                'icon' => 'heroicon-o-building-office',
                'sort_order' => 6,
                'section' => 'main',
            ],
            [
                'title' => 'Tahfeez',
                'route_name' => null,
                'slug' => 'tahfeez',
                'icon' => 'heroicon-o-book-open',
                'sort_order' => 7,
                'section' => 'main',
            ],
            [
                'title' => 'Contact',
                'route_name' => 'contact.index',
                'slug' => 'contact',
                'icon' => 'heroicon-o-envelope',
                'sort_order' => 8,
                'section' => 'main',
            ],
            [
                'title' => 'Login',
                'route_name' => null,
                'slug' => null,
                'url' => 'https://duhais.com/login',
                'icon' => 'heroicon-o-lock-closed',
                'sort_order' => 9,
                'section' => 'main',
                'is_external' => true,
            ],
        ];

        // Store created parent items for child relationships
        $parentItems = [];

        foreach ($mainNav as $item) {
            $defaults = [
                'is_active' => true,
                'is_external' => $item['is_external'] ?? false,
                'target_blank' => false,
            ];
            $parentItem = NavigationItem::create(array_merge($item, $defaults));
            $parentItems[$item['title']] = $parentItem;
        }

        // Create child navigation items for dropdown menus
        // About Children
        if (isset($parentItems['About'])) {
            $aboutChildren = [
                ['title' => 'About Duha', 'route_name' => null, 'slug' => 'about', 'sort_order' => 1],
                ['title' => 'Chairman Message', 'route_name' => null, 'slug' => 'chairman-message', 'sort_order' => 2],
                ['title' => 'Principal Message', 'route_name' => null, 'slug' => 'principal-message', 'sort_order' => 3],
                ['title' => 'Governing Body', 'route_name' => null, 'slug' => 'governing-body', 'sort_order' => 4],
                ['title' => 'Academic Committee', 'route_name' => null, 'slug' => 'academic-committee', 'sort_order' => 5],
                ['title' => 'Campus Facilities', 'route_name' => null, 'slug' => 'campus-facilities', 'sort_order' => 6],
                ['title' => 'School Uniform', 'route_name' => null, 'slug' => 'school-uniform', 'sort_order' => 7],
                ['title' => 'FAQ', 'route_name' => null, 'slug' => 'faq', 'sort_order' => 8],
            ];
            
            foreach ($aboutChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['About']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Academic Children
        if (isset($parentItems['Academic'])) {
            $academicChildren = [
                ['title' => 'Academic Program', 'route_name' => null, 'slug' => 'academic-program', 'sort_order' => 1],
                ['title' => 'Academic Calendar', 'route_name' => null, 'slug' => 'academic-calendar', 'sort_order' => 2],
                ['title' => 'Subjects We Teach', 'route_name' => null, 'slug' => 'subjects', 'sort_order' => 3],
                ['title' => 'Tahfeez Program', 'route_name' => null, 'slug' => 'tahfeez-program', 'sort_order' => 4],
                ['title' => 'Tahili Program', 'route_name' => null, 'slug' => 'tahili-program', 'sort_order' => 5],
                ['title' => 'Future Progression', 'route_name' => null, 'slug' => 'future-progression', 'sort_order' => 6],
                ['title' => 'Duha Curriculum', 'route_name' => null, 'slug' => 'curriculum', 'sort_order' => 7],
                ['title' => 'Exam System', 'route_name' => null, 'slug' => 'exam-system', 'sort_order' => 8],
                ['title' => 'ZA Policies', 'route_name' => null, 'slug' => 'policies', 'sort_order' => 9],
                ['title' => 'Class Routine', 'route_name' => null, 'slug' => 'class-routine', 'sort_order' => 10],
                ['title' => 'Sports & Recreation', 'route_name' => null, 'slug' => 'sports', 'sort_order' => 11],
                ['title' => 'Events & Activities', 'route_name' => null, 'slug' => 'events-activities', 'sort_order' => 12],
            ];
            
            foreach ($academicChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Academic']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Faculty Children
        if (isset($parentItems['Faculty'])) {
            $facultyChildren = [
                ['title' => 'Male Faculty', 'route_name' => null, 'slug' => 'male-faculty', 'sort_order' => 1],
                ['title' => 'Female Faculty', 'route_name' => null, 'slug' => 'female-faculty', 'sort_order' => 2],
            ];
            
            foreach ($facultyChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Faculty']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Admission Children
        if (isset($parentItems['Admission'])) {
            $admissionChildren = [
                ['title' => 'Admission Procedure', 'route_name' => null, 'slug' => 'admission-process', 'sort_order' => 1],
                ['title' => 'Why Us?', 'route_name' => null, 'slug' => 'why-us', 'sort_order' => 2],
                ['title' => 'Enroll Online', 'route_name' => null, 'slug' => 'choose-apply', 'sort_order' => 3],
                ['title' => 'Fees', 'route_name' => null, 'slug' => 'fees', 'sort_order' => 4],
                ['title' => 'Student Year Group and Age Range', 'route_name' => null, 'slug' => 'year-group', 'sort_order' => 5],
            ];
            
            foreach ($admissionChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Admission']->id,
                    'sort_order' => $child['sort_order'],
                    'section' => 'main',
                    'is_active' => true,
                    'is_external' => false,
                    'target_blank' => false,
                ]);
            }
        }

        // Facilities Children
        if (isset($parentItems['Facilities'])) {
            $facilitiesChildren = [
                ['title' => 'Residential Facilities', 'route_name' => null, 'slug' => 'residential-facilities', 'sort_order' => 1],
                ['title' => 'Support for learning and spiritual development', 'route_name' => null, 'slug' => 'support-learning', 'sort_order' => 2],
                ['title' => 'Parent Teacher Association', 'route_name' => null, 'slug' => 'parent-association', 'sort_order' => 3],
            ];
            
            foreach ($facilitiesChildren as $child) {
                NavigationItem::create([
                    'title' => $child['title'],
                    'route_name' => $child['route_name'],
                    'slug' => $child['slug'],
                    'parent_id' => $parentItems['Facilities']->id,
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

        // Clear navigation cache after seeding
        $navigationService = app(\App\Services\NavigationService::class);
        $navigationService->clearNavigationCache('main');
        $navigationService->clearNavigationCache('footer');
    }
}