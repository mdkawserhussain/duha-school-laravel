<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create if it doesn't exist
        if (SiteSettings::count() === 0) {
            SiteSettings::create([
                'site_name' => 'Duha International School',
                'site_description' => 'A leading international school providing quality Islamic and Cambridge curriculum education in Chittagong, Bangladesh.',
                'contact_email' => 'info@duhainternationalschool.com',
                'contact_phone' => '+880-1766-500001, +880-1835-318137',
                'address' => 'House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh',
            ]);
        }
    }
}

