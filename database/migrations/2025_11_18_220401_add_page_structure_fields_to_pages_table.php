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
            $table->foreignId('parent_id')->nullable()->after('slug')->constrained('pages')->onDelete('cascade');
            $table->string('page_category')->nullable()->after('parent_id');
            $table->string('menu_title')->nullable()->after('page_category');
            $table->integer('menu_order')->default(0)->after('menu_title');
            $table->boolean('show_in_menu')->default(true)->after('menu_order');
            $table->enum('menu_section', ['main', 'footer', 'both'])->default('main')->after('show_in_menu');
            $table->string('external_url')->nullable()->after('menu_section');
            $table->boolean('open_in_new_tab')->default(false)->after('external_url');
            $table->boolean('is_featured')->default(false)->after('open_in_new_tab');
            $table->text('excerpt')->nullable()->after('is_featured');

            // Indexes
            $table->index('parent_id');
            $table->index('page_category');
            $table->index('menu_order');
            $table->index('show_in_menu');
            $table->index(['page_category', 'is_published']);
            $table->index(['parent_id', 'menu_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['page_category']);
            $table->dropIndex(['menu_order']);
            $table->dropIndex(['show_in_menu']);
            $table->dropIndex(['page_category', 'is_published']);
            $table->dropIndex(['parent_id', 'menu_order']);

            $table->dropColumn([
                'parent_id',
                'page_category',
                'menu_title',
                'menu_order',
                'show_in_menu',
                'menu_section',
                'external_url',
                'open_in_new_tab',
                'is_featured',
                'excerpt',
            ]);
        });
    }
};