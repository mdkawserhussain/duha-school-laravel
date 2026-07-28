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
        if (Schema::hasTable('media') && !Schema::hasColumn('media', 'conversions_disk')) {
            Schema::table('media', function (Blueprint $table) {
                $table->string('conversions_disk')->nullable()->after('disk');
            });
        }
        
        // Also add size column if it doesn't exist (should be unsignedBigInteger)
        if (Schema::hasTable('media') && !Schema::hasColumn('media', 'size')) {
            Schema::table('media', function (Blueprint $table) {
                $table->unsignedBigInteger('size')->nullable()->after('mime_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('media') && Schema::hasColumn('media', 'conversions_disk')) {
            Schema::table('media', function (Blueprint $table) {
                $table->dropColumn('conversions_disk');
            });
        }
        
        if (Schema::hasTable('media') && Schema::hasColumn('media', 'size')) {
            Schema::table('media', function (Blueprint $table) {
                $table->dropColumn('size');
            });
        }
    }
};
