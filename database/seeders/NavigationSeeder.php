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

        foreach ($mainNav as $item) {
            NavigationItem::create(array_merge($item, [
                'is_active' => true,
                'is_external' => false,
                'target_blank' => false,
            ]));
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