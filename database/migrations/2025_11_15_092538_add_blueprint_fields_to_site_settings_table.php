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
        Schema::table('site_settings', function (Blueprint $table) {
            // Add website_name (will keep site_name for backward compatibility initially)
            if (!Schema::hasColumn('site_settings', 'website_name')) {
                $table->string('website_name')->nullable()->after('id');
            }
            
            // Add website tagline and description
            if (!Schema::hasColumn('site_settings', 'website_tagline')) {
                $table->string('website_tagline')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'website_description')) {
                $table->text('website_description')->nullable();
            }
            
            // Logo and Favicon paths (for Spatie Media Library compatibility)
            if (!Schema::hasColumn('site_settings', 'logo_path')) {
                $table->string('logo_path')->nullable()->after('website_description');
            }
            if (!Schema::hasColumn('site_settings', 'favicon_path')) {
                $table->string('favicon_path')->nullable()->after('logo_path');
            }
            
            // Contact Information - add new fields (keep old ones for compatibility)
            if (!Schema::hasColumn('site_settings', 'primary_email')) {
                $table->string('primary_email')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'secondary_email')) {
                $table->string('secondary_email')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'primary_phone')) {
                $table->string('primary_phone')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'secondary_phone')) {
                $table->string('secondary_phone')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'physical_address')) {
                $table->text('physical_address')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'business_hours')) {
                $table->text('business_hours')->nullable()->after('physical_address');
            }
            
            // Social Media Links (JSON)
            if (!Schema::hasColumn('site_settings', 'social_media_links')) {
                $table->json('social_media_links')->nullable()->after('business_hours');
            }
            
            // Localization
            if (!Schema::hasColumn('site_settings', 'default_currency')) {
                $table->string('default_currency', 3)->default('USD');
            }
            if (!Schema::hasColumn('site_settings', 'default_language')) {
                $table->string('default_language', 10)->default('en');
            }
            if (!Schema::hasColumn('site_settings', 'supported_languages')) {
                $table->json('supported_languages')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'timezone')) {
                $table->string('timezone')->default('UTC');
            }
            
            // SEO Settings
            if (!Schema::hasColumn('site_settings', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'og_title')) {
                $table->string('og_title')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'og_description')) {
                $table->text('og_description')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'og_image')) {
                $table->string('og_image')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'canonical_url')) {
                $table->text('canonical_url')->nullable();
            }
            
            // Maintenance Mode
            if (!Schema::hasColumn('site_settings', 'maintenance_mode')) {
                $table->boolean('maintenance_mode')->default(false);
            }
            if (!Schema::hasColumn('site_settings', 'maintenance_message')) {
                $table->text('maintenance_message')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'maintenance_scheduled_at')) {
                $table->timestamp('maintenance_scheduled_at')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'maintenance_scheduled_until')) {
                $table->timestamp('maintenance_scheduled_until')->nullable();
            }
            
            // Additional Settings
            if (!Schema::hasColumn('site_settings', 'footer_text')) {
                $table->text('footer_text')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'copyright_notice')) {
                $table->string('copyright_notice')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'primary_color')) {
                $table->string('primary_color')->default('#0F4C81');
            }
            if (!Schema::hasColumn('site_settings', 'secondary_color')) {
                $table->string('secondary_color')->default('#1E3A8A');
            }
            if (!Schema::hasColumn('site_settings', 'accent_color')) {
                $table->string('accent_color')->default('#F4C430');
            }
            if (!Schema::hasColumn('site_settings', 'google_analytics_id')) {
                $table->string('google_analytics_id')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'custom_css')) {
                $table->text('custom_css')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'custom_js')) {
                $table->text('custom_js')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'email_notification_preferences')) {
                $table->json('email_notification_preferences')->nullable();
            }
        });
        
        // Add index for maintenance_mode if column exists
        if (Schema::hasColumn('site_settings', 'maintenance_mode')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->index('maintenance_mode');
            });
        }
        
        // Migrate existing data to new fields (keep old fields for backward compatibility)
        try {
            DB::statement('UPDATE site_settings SET website_name = COALESCE(website_name, site_name) WHERE site_name IS NOT NULL');
            DB::statement('UPDATE site_settings SET website_description = COALESCE(website_description, site_description) WHERE site_description IS NOT NULL');
            DB::statement('UPDATE site_settings SET primary_email = COALESCE(primary_email, contact_email) WHERE contact_email IS NOT NULL');
            DB::statement('UPDATE site_settings SET primary_phone = COALESCE(primary_phone, contact_phone) WHERE contact_phone IS NOT NULL');
            DB::statement('UPDATE site_settings SET physical_address = COALESCE(physical_address, address) WHERE address IS NOT NULL');
        } catch (\Exception $e) {
            // Silently fail if columns don't exist yet
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn([
                'website_tagline',
                'logo_path',
                'favicon_path',
                'secondary_email',
                'secondary_phone',
                'business_hours',
                'social_media_links',
                'default_currency',
                'default_language',
                'supported_languages',
                'timezone',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'og_title',
                'og_description',
                'og_image',
                'canonical_url',
                'maintenance_mode',
                'maintenance_message',
                'maintenance_scheduled_at',
                'maintenance_scheduled_until',
                'footer_text',
                'copyright_notice',
                'primary_color',
                'secondary_color',
                'accent_color',
                'google_analytics_id',
                'custom_css',
                'custom_js',
                'email_notification_preferences',
            ]);
        });
    }
};
