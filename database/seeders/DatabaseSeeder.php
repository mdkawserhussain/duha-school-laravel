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
        // Seed in order: settings, roles, then content
        $this->call([
            SiteSettingsSeeder::class,
            RoleSeeder::class,
            AnnouncementSeeder::class,
            HomePageSectionSeeder::class,
            VisionMissionSectionSeeder::class, // Added Vision & Mission seeder
            PageSeeder::class,
            EventSeeder::class,
            NoticeSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
