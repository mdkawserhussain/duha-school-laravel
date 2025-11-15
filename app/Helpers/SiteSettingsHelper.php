<?php

namespace App\Helpers;

use App\Models\SiteSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SiteSettingsHelper
{
    /**
     * Get all settings.
     */
    public static function all(): SiteSettings
    {
        try {
            return SiteSettings::getSettings();
        } catch (\Exception $e) {
            Log::error('Error loading site settings: ' . $e->getMessage());
            // Return a new instance with defaults
            return new SiteSettings([
                'website_name' => 'Duha International School',
                'default_currency' => 'USD',
                'default_language' => 'en',
                'timezone' => 'UTC',
                'primary_color' => '#0F4C81',
                'secondary_color' => '#1E3A8A',
                'accent_color' => '#F4C430',
            ]);
        }
    }

    /**
     * Get specific setting.
     */
    public static function get(string $key, $default = null)
    {
        try {
            $settings = static::all();
            return $settings->$key ?? $default;
        } catch (\Exception $e) {
            Log::error("Error getting site setting '{$key}': " . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set a specific setting.
     */
    public static function set(string $key, $value): bool
    {
        try {
            $settings = static::all();
            $settings->$key = $value;
            $settings->save();
            return true;
        } catch (\Exception $e) {
            Log::error("Error setting site setting '{$key}': " . $e->getMessage());
            return false;
        }
    }

    // Convenience methods for common settings

    /**
     * Get website name.
     */
    public static function websiteName(): string
    {
        return static::get('website_name', 'Duha International School');
    }

    /**
     * Get website tagline.
     */
    public static function websiteTagline(): ?string
    {
        return static::get('website_tagline');
    }

    /**
     * Get website description.
     */
    public static function websiteDescription(): ?string
    {
        return static::get('website_description');
    }

    /**
     * Get logo URL.
     * Returns the uploaded logo URL or falls back to placeholder.
     * Uses relative paths with asset() for better compatibility.
     */
    public static function logoUrl(): ?string
    {
        try {
            $settings = static::all();
            
            // Use the logo_url accessor which now uses relative paths with asset()
            if ($settings && $settings->logo_url) {
                return $settings->logo_url;
            }
            
            // Fallback to static method which also uses relative paths
            return SiteSettings::getLogoUrl();
        } catch (\Exception $e) {
            Log::error('Error getting logo URL: ' . $e->getMessage());
            return SiteSettings::getLogoUrl();
        }
    }

    /**
     * Get favicon URL.
     */
    public static function faviconUrl(): ?string
    {
        try {
            $settings = static::all();
            return $settings->favicon_url ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get primary email.
     */
    public static function primaryEmail(): ?string
    {
        return static::get('primary_email');
    }

    /**
     * Get secondary email.
     */
    public static function secondaryEmail(): ?string
    {
        return static::get('secondary_email');
    }

    /**
     * Get primary phone.
     */
    public static function primaryPhone(): ?string
    {
        return static::get('primary_phone');
    }

    /**
     * Get secondary phone.
     */
    public static function secondaryPhone(): ?string
    {
        return static::get('secondary_phone');
    }

    /**
     * Get physical address.
     */
    public static function physicalAddress(): ?string
    {
        return static::get('physical_address');
    }

    /**
     * Get business hours.
     */
    public static function businessHours(): ?string
    {
        return static::get('business_hours');
    }

    /**
     * Get social media links.
     */
    public static function socialLinks(): array
    {
        return static::get('social_media_links', []);
    }

    /**
     * Get default currency.
     */
    public static function defaultCurrency(): string
    {
        return static::get('default_currency', 'USD');
    }

    /**
     * Get default language.
     */
    public static function defaultLanguage(): string
    {
        return static::get('default_language', 'en');
    }

    /**
     * Get supported languages.
     */
    public static function supportedLanguages(): array
    {
        return static::get('supported_languages', ['en']);
    }

    /**
     * Get timezone.
     */
    public static function timezone(): string
    {
        return static::get('timezone', 'UTC');
    }

    /**
     * Get meta title.
     */
    public static function metaTitle(): ?string
    {
        return static::get('meta_title');
    }

    /**
     * Get meta description.
     */
    public static function metaDescription(): ?string
    {
        return static::get('meta_description');
    }

    /**
     * Get meta keywords.
     */
    public static function metaKeywords(): ?string
    {
        return static::get('meta_keywords');
    }

    /**
     * Get OG title.
     */
    public static function ogTitle(): ?string
    {
        return static::get('og_title');
    }

    /**
     * Get OG description.
     */
    public static function ogDescription(): ?string
    {
        return static::get('og_description');
    }

    /**
     * Get OG image URL.
     */
    public static function ogImageUrl(): ?string
    {
        try {
            $settings = static::all();
            return $settings->og_image_url ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get canonical URL.
     */
    public static function canonicalUrl(): ?string
    {
        return static::get('canonical_url');
    }

    /**
     * Check if maintenance mode is enabled.
     */
    public static function isMaintenanceMode(): bool
    {
        try {
            $settings = static::all();
            if (!$settings->maintenance_mode) {
                return false;
            }

            // Check scheduled maintenance
            $now = now();
            if ($settings->maintenance_scheduled_at && $settings->maintenance_scheduled_until) {
                return $now->between(
                    $settings->maintenance_scheduled_at,
                    $settings->maintenance_scheduled_until
                );
            }

            return $settings->maintenance_mode;
        } catch (\Exception $e) {
            Log::error('Error checking maintenance mode: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get maintenance message.
     */
    public static function maintenanceMessage(): ?string
    {
        return static::get('maintenance_message', 'We are currently performing scheduled maintenance. Please check back soon.');
    }

    /**
     * Get footer text.
     */
    public static function footerText(): ?string
    {
        return static::get('footer_text');
    }

    /**
     * Get copyright notice.
     */
    public static function copyrightNotice(): ?string
    {
        return static::get('copyright_notice');
    }

    /**
     * Get primary color.
     */
    public static function primaryColor(): string
    {
        return static::get('primary_color', '#0F4C81');
    }

    /**
     * Get secondary color.
     */
    public static function secondaryColor(): string
    {
        return static::get('secondary_color', '#1E3A8A');
    }

    /**
     * Get accent color.
     */
    public static function accentColor(): string
    {
        return static::get('accent_color', '#F4C430');
    }

    /**
     * Get Google Analytics ID.
     */
    public static function googleAnalyticsId(): ?string
    {
        return static::get('google_analytics_id');
    }

    /**
     * Get custom CSS.
     */
    public static function customCss(): ?string
    {
        return static::get('custom_css');
    }

    /**
     * Get custom JavaScript.
     */
    public static function customJs(): ?string
    {
        return static::get('custom_js');
    }

    /**
     * Get active advisors sorted by sort_order.
     * Retrieves advisors from HomePageSection (section_key='advisors')
     */
    public static function advisors(): array
    {
        try {
            // Get advisors from HomePageSection instead of SiteSettings
            $section = \App\Models\HomePageSection::where('section_key', 'advisors')
                ->where('is_active', true)
                ->first();
            
            if (!$section || empty($section->data['advisors'])) {
                Log::info('No advisors found in HomePageSection');
                return [];
            }
            
            $advisors = $section->data['advisors'];
            
            // Process each advisor
            foreach ($advisors as &$advisor) {
                // Map 'photo_url' to 'profile_image_url' for consistency
                if (isset($advisor['photo_url']) && !empty($advisor['photo_url'])) {
                    $advisor['profile_image_url'] = $advisor['photo_url'];
                } elseif (isset($advisor['profile_image'])) {
                    // If it's already a full URL, use it as is
                    if (filter_var($advisor['profile_image'], FILTER_VALIDATE_URL)) {
                        $advisor['profile_image_url'] = $advisor['profile_image'];
                    } else {
                        // For local files, generate the URL directly
                        $advisor['profile_image_url'] = url('storage/' . ltrim($advisor['profile_image'], '/'));
                    }
                } else {
                    // Use placeholder if no image
                    $advisor['profile_image_url'] = asset('images/placeholder.svg');
                }
                
                // Ensure required fields have defaults
                $advisor['name'] = $advisor['name'] ?? 'Unknown';
                $advisor['title'] = $advisor['title'] ?? '';
                $advisor['description'] = $advisor['description'] ?? '';
                $advisor['linkedin_url'] = $advisor['linkedin_url'] ?? '';
                $advisor['email'] = $advisor['email'] ?? '';
                $advisor['accent_color'] = $advisor['accent_color'] ?? '#F4C430';
            }
            
            Log::info('Advisors loaded successfully', ['count' => count($advisors)]);
            return $advisors;
            
        } catch (\Exception $e) {
            Log::error('Error loading advisors from HomePageSection: ' . $e->getMessage());
            return [];
        }
    }
}

