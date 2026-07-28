<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('pages', 'hero_badge')) {
                $table->string('hero_badge')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('pages', 'hero_subtitle')) {
                $table->string('hero_subtitle')->nullable()->after('hero_badge');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('pages', 'hero_badge')) {
                $table->dropColumn('hero_badge');
            }
            if (Schema::hasColumn('pages', 'hero_subtitle')) {
                $table->dropColumn('hero_subtitle');
            }
        });
    }
};
