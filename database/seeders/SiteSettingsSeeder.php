<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create if it doesn't exist
        if (SiteSettings::count() === 0) {
            SiteSettings::create([
                // Website Information
                'website_name' => 'Duha International School',
                'website_tagline' => 'Excellence in Islamic Education',
                'website_description' => 'A leading international school providing quality Islamic and Cambridge curriculum education in Chittagong, Bangladesh.',
                'site_name' => 'Duha International School', // Backward compatibility
                'site_description' => 'A leading international school providing quality Islamic and Cambridge curriculum education in Chittagong, Bangladesh.', // Backward compatibility
                
                // Contact Information
                'primary_email' => 'info@duhainternationalschool.com',
                'secondary_email' => null,
                'primary_phone' => '+880-1766-500001',
                'secondary_phone' => '+880-1835-318137',
                'physical_address' => 'House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh',
                'business_hours' => "Sun-Thu: 9AM - 5PM\nFri & Sat: Closed",
                'contact_email' => 'info@duhainternationalschool.com', // Backward compatibility
                'contact_phone' => '+880-1766-500001, +880-1835-318137', // Backward compatibility
                'address' => 'House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh', // Backward compatibility
                
                // Social Media Links
                'social_media_links' => [
                    'facebook' => null,
                    'twitter' => null,
                    'instagram' => null,
                    'youtube' => null,
                    'linkedin' => null,
                ],
                
                // Localization
                'default_currency' => 'USD',
                'default_language' => 'en',
                'supported_languages' => ['en', 'bn'],
                'timezone' => 'Asia/Dhaka',
                
                // SEO Settings
                'meta_title' => 'Duha International School - Excellence in Islamic Education',
                'meta_description' => 'A leading international school providing quality Islamic and Cambridge curriculum education in Chittagong, Bangladesh.',
                'meta_keywords' => 'Duha International School, Islamic Education, Cambridge Curriculum, International School, Chittagong, Bangladesh',
                'og_title' => 'Duha International School - Excellence in Islamic Education',
                'og_description' => 'A leading international school providing quality Islamic and Cambridge curriculum education in Chittagong, Bangladesh.',
                'canonical_url' => null,
                
                // Maintenance Mode
                'maintenance_mode' => false,
                'maintenance_message' => 'We are currently performing scheduled maintenance. Please check back soon.',
                'maintenance_scheduled_at' => null,
                'maintenance_scheduled_until' => null,
                
                // Additional Settings
                'footer_text' => null,
                'copyright_notice' => '© {year} Duha International School. All rights reserved.',
                'primary_color' => '#008236',
                'secondary_color' => '#1E3A8A',
                'accent_color' => '#F4C430',
                'google_analytics_id' => null,
                'custom_css' => null,
                'custom_js' => null,
                'email_notification_preferences' => null,
            ]);
        }
    }
}

