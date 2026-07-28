<?php

namespace App\Observers;

use App\Models\HomePageSection;
use Illuminate\Support\Facades\Cache;

class HomePageSectionObserver
{
    /**
     * Clear homepage cache when any homepage section is modified.
     */
    protected function clearHomepageCache(): void
    {
        // Clear the main homepage cache
        Cache::forget('homepage_v2_data');
        
        // Also clear any related caches if tags are supported
        try {
            Cache::tags(['homepage', 'homepage_sections'])->flush();
        } catch (\Exception $e) {
            // Tags not supported by cache driver, that's okay
            // The main cache key is already cleared above
        }
    }

    /**
     * Handle the HomePageSection "created" event.
     */
    public function created(HomePageSection $homePageSection): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageSection "updated" event.
     */
    public function updated(HomePageSection $homePageSection): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageSection "deleted" event.
     */
    public function deleted(HomePageSection $homePageSection): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageSection "restored" event.
     */
    public function restored(HomePageSection $homePageSection): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageSection "force deleted" event.
     */
    public function forceDeleted(HomePageSection $homePageSection): void
    {
        $this->clearHomepageCache();
    }
}
