<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in order: settings, roles, navigation, then content
        $this->call([
            SiteSettingsSeeder::class,
            RoleSeeder::class,
            NavigationSeeder::class, // Navigation items for menu structure
            AnnouncementSeeder::class,
            HomePageSectionSeeder::class,
            VisionMissionSectionSeeder::class, // Vision & Mission with Islamic content
            PagesSeeder::class, // Comprehensive page structure with navigation
            EventSeeder::class,
            NoticeSeeder::class,
            StaffSeeder::class,
            ZaitoonContentSeeder::class, // Zaitoon Academy-specific content (overrides defaults)
        ]);
    }
}
