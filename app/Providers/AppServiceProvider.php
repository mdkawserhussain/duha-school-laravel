<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\HomePageContent;
use App\Models\HomePageSection;
use App\Observers\EventObserver;
use App\Observers\HomePageContentObserver;
use App\Observers\HomePageSectionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers to clear cache on homepage section updates
        HomePageSection::observe(HomePageSectionObserver::class);
        HomePageContent::observe(HomePageContentObserver::class);
        Event::observe(EventObserver::class);
    }
}
