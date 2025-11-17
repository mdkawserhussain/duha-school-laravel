<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update site_settings table
        DB::table('site_settings')
            ->where('site_name', 'Al-Maghrib International School')
            ->update(['site_name' => 'Duha International School']);

        // Update announcements
        DB::table('announcements')
            ->where('message', 'like', '%Al-Maghrib International School%')
            ->update([
                'message' => DB::raw("REPLACE(message, 'Al-Maghrib International School', 'Duha International School')")
            ]);

        // Update pages content and meta_title
        DB::table('pages')
            ->where('content', 'like', '%Al-Maghrib International School%')
            ->orWhere('meta_title', 'like', '%Al-Maghrib International School%')
            ->update([
                'content' => DB::raw("REPLACE(content, 'Al-Maghrib International School', 'Duha International School')"),
                'meta_title' => DB::raw("REPLACE(meta_title, 'Al-Maghrib International School', 'Duha International School')")
            ]);

        // Update pages - also replace "Al-Maghrib" standalone
        DB::table('pages')
            ->where('content', 'like', '%Al-Maghrib%')
            ->update([
                'content' => DB::raw("REPLACE(REPLACE(content, 'Al-Maghrib International School', 'Duha International School'), 'Al-Maghrib', 'Duha')")
            ]);

        // Update notices
        DB::table('notices')
            ->where('content', 'like', '%Al-Maghrib International School%')
            ->update([
                'content' => DB::raw("REPLACE(content, 'Al-Maghrib International School', 'Duha International School')")
            ]);

        // Update staff bios
        DB::table('staff')
            ->where('bio', 'like', '%Al-Maghrib International School%')
            ->update([
                'bio' => DB::raw("REPLACE(bio, 'Al-Maghrib International School', 'Duha International School')")
            ]);

        // Update homepage_sections
        DB::table('home_page_sections')
            ->where('title', 'like', '%Al-Maghrib%')
            ->orWhere('content', 'like', '%Al-Maghrib International School%')
            ->orWhere('description', 'like', '%Al-Maghrib International School%')
            ->update([
                'title' => DB::raw("REPLACE(REPLACE(title, 'AL-MAGHRIB', 'DUHA'), 'Al-Maghrib', 'Duha')"),
                'content' => DB::raw("REPLACE(content, 'Al-Maghrib International School', 'Duha International School')"),
                'description' => DB::raw("REPLACE(description, 'Al-Maghrib International School', 'Duha International School')")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the updates
        DB::table('site_settings')
            ->where('site_name', 'Duha International School')
            ->update(['site_name' => 'Al-Maghrib International School']);

        DB::table('announcements')
            ->where('message', 'like', '%Duha International School%')
            ->update([
                'message' => DB::raw("REPLACE(message, 'Duha International School', 'Al-Maghrib International School')")
            ]);

        DB::table('pages')
            ->where('content', 'like', '%Duha International School%')
            ->orWhere('meta_title', 'like', '%Duha International School%')
            ->update([
                'content' => DB::raw("REPLACE(REPLACE(content, 'Duha International School', 'Al-Maghrib International School'), 'Duha', 'Al-Maghrib')"),
                'meta_title' => DB::raw("REPLACE(meta_title, 'Duha International School', 'Al-Maghrib International School')")
            ]);

        DB::table('notices')
            ->where('content', 'like', '%Duha International School%')
            ->update([
                'content' => DB::raw("REPLACE(content, 'Duha International School', 'Al-Maghrib International School')")
            ]);

        DB::table('staff')
            ->where('bio', 'like', '%Duha International School%')
            ->update([
                'bio' => DB::raw("REPLACE(bio, 'Duha International School', 'Al-Maghrib International School')")
            ]);

        DB::table('home_page_sections')
            ->where('title', 'like', '%DUHA%')
            ->orWhere('title', 'like', '%Duha%')
            ->orWhere('content', 'like', '%Duha International School%')
            ->orWhere('description', 'like', '%Duha International School%')
            ->update([
                'title' => DB::raw("REPLACE(REPLACE(title, 'DUHA', 'AL-MAGHRIB'), 'Duha', 'Al-Maghrib')"),
                'content' => DB::raw("REPLACE(content, 'Duha International School', 'Al-Maghrib International School')"),
                'description' => DB::raw("REPLACE(description, 'Duha International School', 'Al-Maghrib International School')")
            ]);
    }
};

