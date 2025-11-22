<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteSettingsController extends BaseController
{
    public function edit()
    {
        $settings = SiteSettings::firstOrCreate([], [
            'website_name' => config('app.name'),
            'primary_color' => '#0F4C81',
            'secondary_color' => '#1E3A8A',
            'accent_color' => '#F4C430',
        ]);

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSettings::firstOrCreate([], [
            'website_name' => config('app.name'),
        ]);

        $data = $request->validate([
            'website_name' => ['required', 'string', 'max:255'],
            'website_tagline' => ['nullable', 'string', 'max:255'],
            'website_description' => ['nullable', 'string', 'max:1000'],
            'primary_email' => ['nullable', 'email', 'max:255'],
            'secondary_email' => ['nullable', 'email', 'max:255'],
            'primary_phone' => ['nullable', 'string', 'max:20'],
            'secondary_phone' => ['nullable', 'string', 'max:20'],
            'physical_address' => ['nullable', 'string', 'max:500'],
            'business_hours' => ['nullable', 'string', 'max:500'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.facebook' => ['nullable', 'url'],
            'social_media_links.twitter' => ['nullable', 'url'],
            'social_media_links.instagram' => ['nullable', 'url'],
            'social_media_links.youtube' => ['nullable', 'url'],
            'social_media_links.linkedin' => ['nullable', 'url'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'primary_color' => ['nullable', 'string', 'max:7'],
            'secondary_color' => ['nullable', 'string', 'max:7'],
            'accent_color' => ['nullable', 'string', 'max:7'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'custom_css' => ['nullable', 'string'],
            'custom_js' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string', 'max:1000'],
            'copyright_notice' => ['nullable', 'string', 'max:255'],
            'default_language' => ['nullable', 'string', 'max:10'],
            'default_currency' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'maintenance_mode' => ['boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
            'og_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $settings->update($data);

        // Handle logo
        if ($request->hasFile('logo')) {
            $settings->clearMediaCollection('logo');
            $settings->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        // Handle favicon
        if ($request->hasFile('favicon')) {
            $settings->clearMediaCollection('favicon');
            $settings->addMediaFromRequest('favicon')
                ->toMediaCollection('favicon');
        }

        // Handle OG image
        if ($request->hasFile('og_image')) {
            $settings->clearMediaCollection('og_image');
            $settings->addMediaFromRequest('og_image')
                ->toMediaCollection('og_image');
        }

        Cache::forget('site_settings');
        Cache::forget('homepage_v2_data');

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}
