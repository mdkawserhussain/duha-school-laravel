<?php

namespace App\Observers;

use App\Models\HomePageContent;
use Illuminate\Support\Facades\Cache;

class HomePageContentObserver
{
    /**
     * Clear homepage cache when homepage content is modified.
     */
    protected function clearHomepageCache(): void
    {
        // Clear the main homepage cache
        Cache::forget('homepage_v2_data');
        
        // Also clear any related caches if tags are supported
        try {
            Cache::tags(['homepage', 'homepage_content'])->flush();
        } catch (\Exception $e) {
            // Tags not supported by cache driver, that's okay
            // The main cache key is already cleared above
        }
    }

    /**
     * Handle the HomePageContent "created" event.
     */
    public function created(HomePageContent $homePageContent): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageContent "updated" event.
     */
    public function updated(HomePageContent $homePageContent): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageContent "deleted" event.
     */
    public function deleted(HomePageContent $homePageContent): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageContent "restored" event.
     */
    public function restored(HomePageContent $homePageContent): void
    {
        $this->clearHomepageCache();
    }

    /**
     * Handle the HomePageContent "force deleted" event.
     */
    public function forceDeleted(HomePageContent $homePageContent): void
    {
        $this->clearHomepageCache();
    }
}
