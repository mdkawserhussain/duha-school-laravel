<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create default announcement if none exist
        if (Announcement::count() === 0) {
            Announcement::create([
                'message' => 'Admission ongoing on Duha International School. Visit our campus to know more.',
                'link' => null,
                'link_text' => null,
                'is_active' => true,
                'sort_order' => 0,
                'starts_at' => null,
                'expires_at' => null,
            ]);
        }
    }
}
