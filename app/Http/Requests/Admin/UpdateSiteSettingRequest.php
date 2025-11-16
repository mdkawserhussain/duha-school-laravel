<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('manage_site_settings') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Website Information
            'website_name' => ['required', 'string', 'max:255'],
            'website_tagline' => ['nullable', 'string', 'max:255'],
            'website_description' => ['nullable', 'string', 'max:1000'],
            
            // Logo and Favicon
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,ico', 'max:1024'],
            'og_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            
            // Contact Information
            'primary_email' => ['nullable', 'email', 'max:255'],
            'secondary_email' => ['nullable', 'email', 'max:255'],
            'primary_phone' => ['nullable', 'string', 'max:20'],
            'secondary_phone' => ['nullable', 'string', 'max:20'],
            'physical_address' => ['nullable', 'string', 'max:500'],
            'business_hours' => ['nullable', 'string', 'max:500'],
            
            // Social Media Links
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.facebook' => ['nullable', 'url', 'max:255'],
            'social_media_links.twitter' => ['nullable', 'url', 'max:255'],
            'social_media_links.instagram' => ['nullable', 'url', 'max:255'],
            'social_media_links.youtube' => ['nullable', 'url', 'max:255'],
            'social_media_links.linkedin' => ['nullable', 'url', 'max:255'],
            
            // Localization
            'default_currency' => ['required', 'string', Rule::in(['USD', 'EUR', 'GBP', 'BDT', 'SAR', 'AED'])],
            'default_language' => ['required', 'string', 'max:10'],
            'supported_languages' => ['nullable', 'array'],
            'timezone' => ['required', 'string', 'max:50'],
            
            // SEO Settings
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            
            // Maintenance Mode
            'maintenance_mode' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:1000'],
            'maintenance_scheduled_at' => ['nullable', 'date'],
            'maintenance_scheduled_until' => ['nullable', 'date', 'after:maintenance_scheduled_at'],
            
            // Additional Settings
            'footer_text' => ['nullable', 'string', 'max:1000'],
            'copyright_notice' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'custom_css' => ['nullable', 'string'],
            'custom_js' => ['nullable', 'string'],
            'email_notification_preferences' => ['nullable', 'array'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Handle maintenance_mode checkbox (if not sent, set to false)
        if (!$this->has('maintenance_mode')) {
            $this->merge(['maintenance_mode' => false]);
        }
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'website_name.required' => 'Website name is required.',
            'primary_color.regex' => 'Primary color must be a valid hex color code.',
            'secondary_color.regex' => 'Secondary color must be a valid hex color code.',
            'accent_color.regex' => 'Accent color must be a valid hex color code.',
            'maintenance_scheduled_until.after' => 'Maintenance end time must be after start time.',
        ];
    }
}
