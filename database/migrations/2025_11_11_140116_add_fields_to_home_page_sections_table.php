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
        Schema::table('home_page_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('home_page_sections', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('home_page_sections', 'description')) {
                $table->text('description')->nullable()->after('content');
            }
            if (!Schema::hasColumn('home_page_sections', 'button_text')) {
                $table->string('button_text')->nullable()->after('description');
            }
            if (!Schema::hasColumn('home_page_sections', 'button_link')) {
                $table->string('button_link')->nullable()->after('button_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_sections', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'description', 'button_text', 'button_link']);
        });
    }
};
