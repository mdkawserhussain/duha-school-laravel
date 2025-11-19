<?php

namespace App\Observers;

use App\Models\NavigationItem;
use App\Services\NavigationService;
use Illuminate\Support\Facades\Cache;

class NavigationItemObserver
{
    protected NavigationService $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    /**
     * Handle the NavigationItem "created" event.
     */
    public function created(NavigationItem $navigationItem): void
    {
        $this->clearNavigationCaches($navigationItem);
    }

    /**
     * Handle the NavigationItem "updated" event.
     */
    public function updated(NavigationItem $navigationItem): void
    {
        $this->clearNavigationCaches($navigationItem);
    }

    /**
     * Handle the NavigationItem "deleted" event.
     */
    public function deleted(NavigationItem $navigationItem): void
    {
        $this->clearNavigationCaches($navigationItem);
    }

    /**
     * Handle the NavigationItem "restored" event.
     */
    public function restored(NavigationItem $navigationItem): void
    {
        $this->clearNavigationCaches($navigationItem);
    }

    /**
     * Handle the NavigationItem "force deleted" event.
     */
    public function forceDeleted(NavigationItem $navigationItem): void
    {
        $this->clearNavigationCaches($navigationItem);
    }

    /**
     * Clear navigation-related caches.
     */
    protected function clearNavigationCaches(NavigationItem $navigationItem): void
    {
        $this->navigationService->clearNavigationCache();
        
        // Also clear specific section cache
        if ($navigationItem->section) {
            $this->navigationService->clearNavigationCache($navigationItem->section);
        }

        // Clear both main and footer if section is 'both'
        if ($navigationItem->section === 'both') {
            $this->navigationService->clearNavigationCache('main');
            $this->navigationService->clearNavigationCache('footer');
        }
    }
}