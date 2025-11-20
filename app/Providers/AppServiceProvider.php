<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\HomePageContent;
use App\Models\HomePageSection;
use App\Models\NavigationItem;
use App\Models\Notice;
use App\Models\Page;
use App\Observers\EventObserver;
use App\Observers\HomePageContentObserver;
use App\Observers\HomePageSectionObserver;
use App\Observers\MediaObserver;
use App\Observers\NavigationItemObserver;
use App\Observers\NoticeObserver;
use App\Observers\PageObserver;
use App\Services\NavigationService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        // Register View Composers
        View::composer('components.navbar', \App\View\Composers\NavbarComposer::class);

        // Register observers to clear cache on homepage section updates
        HomePageSection::observe(HomePageSectionObserver::class);
        HomePageContent::observe(HomePageContentObserver::class);
        Event::observe(EventObserver::class);
        Notice::observe(NoticeObserver::class);
        Page::observe(PageObserver::class);
        
        // Register NavigationItemObserver with NavigationService dependency
        NavigationItem::observe(NavigationItemObserver::class);
        
        // Register MediaObserver to delete original images after WebP conversion
        Media::observe(MediaObserver::class);
    }
}
