<?php

namespace App\Helpers;

/**
 * Legacy helper class - use SiteSettingsHelper instead
 * This class is kept for backward compatibility
 * 
 * @deprecated Use SiteSettingsHelper::websiteName() instead
 */
class SiteHelper
{
    /**
     * Get the site name from SiteSettings or fallback to config
     * 
     * @deprecated Use SiteSettingsHelper::websiteName() instead
     */
    public static function getSiteName(): string
    {
        return \App\Helpers\SiteSettingsHelper::websiteName();
    }

    /**
     * Get the site description from SiteSettings or fallback
     * 
     * @deprecated Use SiteSettingsHelper::websiteDescription() instead
     */
    public static function getSiteDescription(): string
    {
        return \App\Helpers\SiteSettingsHelper::websiteDescription() ?? 'Excellence in Islamic Education - Nurturing minds and hearts for a better tomorrow through Cambridge and Islamic integrated curriculum.';
    }
}

