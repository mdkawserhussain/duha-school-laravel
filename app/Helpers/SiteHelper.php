<?php

namespace App\Helpers;

use App\Models\SiteSettings;

class SiteHelper
{
    /**
     * Get the site name from SiteSettings or fallback to config
     */
    public static function getSiteName(): string
    {
        $settings = SiteSettings::first();
        return $settings?->site_name ?? config('app.name', 'Duha International School');
    }

    /**
     * Get the site description from SiteSettings or fallback
     */
    public static function getSiteDescription(): string
    {
        $settings = SiteSettings::first();
        return $settings?->site_description ?? 'Excellence in Islamic Education - Nurturing minds and hearts for a better tomorrow through Cambridge and Islamic integrated curriculum.';
    }
}

