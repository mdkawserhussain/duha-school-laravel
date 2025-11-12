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
        // Media library table for Spatie Media Library
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection')->default('default');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('path')->nullable();
            $table->string('disk')->default('public');
            $table->string('file_hash', 64)->nullable();
            $table->string('collection_name');
            $table->string('manipulations');
            $table->string('custom_properties');
            $table->string('generated_conversions');
            $table->string('responsive_images');
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
