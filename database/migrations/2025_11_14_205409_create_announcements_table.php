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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('message')->comment('The announcement message to display');
            $table->string('link')->nullable()->comment('Optional link URL for the announcement');
            $table->string('link_text')->nullable()->comment('Optional link text');
            $table->boolean('is_active')->default(true)->comment('Whether the announcement is visible');
            $table->integer('sort_order')->default(0)->comment('Order for rotation (lower numbers first)');
            $table->timestamp('starts_at')->nullable()->comment('When to start showing this announcement');
            $table->timestamp('expires_at')->nullable()->comment('When to stop showing this announcement');
            $table->timestamps();
            
            $table->index(['is_active', 'expires_at', 'starts_at']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
