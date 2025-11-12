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
        Schema::create('home_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // e.g., 'hero', 'info_enrollment', 'info_events', 'info_notice', 'vision', 'video_1', 'video_2', 'why_choose', 'children_responsibility', 'values', 'advisors', 'board_management'
            $table->string('section_type'); // e.g., 'hero', 'info_block', 'content', 'video', 'list', 'advisors', 'board', 'events'
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable(); // HTML content
            $table->text('description')->nullable(); // Plain text description
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->json('data')->nullable(); // For structured data like values list, advisors, videos, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['section_type', 'is_active']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_sections');
    }
};
