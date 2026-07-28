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
            if (!Schema::hasColumn('pages', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('slug')->constrained('pages')->onDelete('cascade');
            }
            if (!Schema::hasColumn('pages', 'page_category')) {
                $table->string('page_category')->nullable()->after('parent_id');
            }
            if (!Schema::hasColumn('pages', 'menu_title')) {
                $table->string('menu_title')->nullable()->after('page_category');
            }
            if (!Schema::hasColumn('pages', 'menu_order')) {
                $table->integer('menu_order')->default(0)->after('menu_title');
            }
            if (!Schema::hasColumn('pages', 'show_in_menu')) {
                $table->boolean('show_in_menu')->default(true)->after('menu_order');
            }
            if (!Schema::hasColumn('pages', 'menu_section')) {
                $table->enum('menu_section', ['main', 'footer', 'both'])->default('main')->after('show_in_menu');
            }
            if (!Schema::hasColumn('pages', 'external_url')) {
                $table->string('external_url')->nullable()->after('menu_section');
            }
            if (!Schema::hasColumn('pages', 'open_in_new_tab')) {
                $table->boolean('open_in_new_tab')->default(false)->after('external_url');
            }
            if (!Schema::hasColumn('pages', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('open_in_new_tab');
            }
            if (!Schema::hasColumn('pages', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('is_featured');
            }

            // Indexes - only add if columns exist and indexes don't exist
            try {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexesFound = $sm->listTableIndexes('pages');
                
                if (Schema::hasColumn('pages', 'parent_id') && !isset($indexesFound['pages_parent_id_index'])) {
                    $table->index('parent_id');
                }
                if (Schema::hasColumn('pages', 'page_category') && !isset($indexesFound['pages_page_category_index'])) {
                    $table->index('page_category');
                }
                if (Schema::hasColumn('pages', 'menu_order') && !isset($indexesFound['pages_menu_order_index'])) {
                    $table->index('menu_order');
                }
                if (Schema::hasColumn('pages', 'show_in_menu') && !isset($indexesFound['pages_show_in_menu_index'])) {
                    $table->index('show_in_menu');
                }
                if (Schema::hasColumn('pages', 'page_category') && Schema::hasColumn('pages', 'is_published') && !isset($indexesFound['pages_page_category_is_published_index'])) {
                    $table->index(['page_category', 'is_published']);
                }
                if (Schema::hasColumn('pages', 'parent_id') && Schema::hasColumn('pages', 'menu_order') && !isset($indexesFound['pages_parent_id_menu_order_index'])) {
                    $table->index(['parent_id', 'menu_order']);
                }
            } catch (\Exception $e) {
                // If index checking fails, skip adding indexes
                // They may already exist or the table structure may be different
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Only drop columns and indexes if they exist
            if (Schema::hasColumn('pages', 'parent_id')) {
                try {
                    $table->dropForeign(['parent_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist
                }
            }
            
            // Drop indexes only if they exist
            try {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexesFound = $sm->listTableIndexes('pages');
                
                if (isset($indexesFound['pages_parent_id_index'])) {
                    $table->dropIndex(['parent_id']);
                }
                if (isset($indexesFound['pages_page_category_index'])) {
                    $table->dropIndex(['page_category']);
                }
                if (isset($indexesFound['pages_menu_order_index'])) {
                    $table->dropIndex(['menu_order']);
                }
                if (isset($indexesFound['pages_show_in_menu_index'])) {
                    $table->dropIndex(['show_in_menu']);
                }
                if (isset($indexesFound['pages_page_category_is_published_index'])) {
                    $table->dropIndex(['page_category', 'is_published']);
                }
                if (isset($indexesFound['pages_parent_id_menu_order_index'])) {
                    $table->dropIndex(['parent_id', 'menu_order']);
                }
            } catch (\Exception $e) {
                // If index checking fails, skip dropping indexes
            }

            // Drop columns only if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('pages', 'parent_id')) {
                $columnsToDrop[] = 'parent_id';
            }
            if (Schema::hasColumn('pages', 'page_category')) {
                $columnsToDrop[] = 'page_category';
            }
            if (Schema::hasColumn('pages', 'menu_title')) {
                $columnsToDrop[] = 'menu_title';
            }
            if (Schema::hasColumn('pages', 'menu_order')) {
                $columnsToDrop[] = 'menu_order';
            }
            if (Schema::hasColumn('pages', 'show_in_menu')) {
                $columnsToDrop[] = 'show_in_menu';
            }
            if (Schema::hasColumn('pages', 'menu_section')) {
                $columnsToDrop[] = 'menu_section';
            }
            if (Schema::hasColumn('pages', 'external_url')) {
                $columnsToDrop[] = 'external_url';
            }
            if (Schema::hasColumn('pages', 'open_in_new_tab')) {
                $columnsToDrop[] = 'open_in_new_tab';
            }
            if (Schema::hasColumn('pages', 'is_featured')) {
                $columnsToDrop[] = 'is_featured';
            }
            if (Schema::hasColumn('pages', 'excerpt')) {
                $columnsToDrop[] = 'excerpt';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};