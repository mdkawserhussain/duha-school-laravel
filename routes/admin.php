<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::prefix('admin')->middleware(['auth', 'role:admin|editor'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Events
    Route::resource('events', Admin\EventController::class);
    
    // Notices
    Route::resource('notices', Admin\NoticeController::class);
    
    // Pages
    Route::resource('pages', Admin\PageController::class);
    
    // Staff
    Route::resource('staff', Admin\StaffController::class);
    
    // Homepage Sections
    Route::resource('homepage-sections', Admin\HomePageSectionController::class);
    Route::post('homepage-sections/{section}/reorder', [Admin\HomePageSectionController::class, 'reorder'])->name('homepage-sections.reorder');
    
    // Homepage Contents
    Route::resource('homepage-contents', Admin\HomePageContentController::class);
    
    // Site Settings
    Route::get('settings', [Admin\SiteSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [Admin\SiteSettingsController::class, 'update'])->name('settings.update');
    
    // Applications
    Route::get('admission-applications', [Admin\AdmissionApplicationController::class, 'index'])->name('admission-applications.index');
    Route::get('admission-applications/{application}', [Admin\AdmissionApplicationController::class, 'show'])->name('admission-applications.show');
    Route::patch('admission-applications/{application}', [Admin\AdmissionApplicationController::class, 'update'])->name('admission-applications.update');
    
    Route::get('career-applications', [Admin\CareerApplicationController::class, 'index'])->name('career-applications.index');
    Route::get('career-applications/{application}', [Admin\CareerApplicationController::class, 'show'])->name('career-applications.show');
    Route::patch('career-applications/{application}', [Admin\CareerApplicationController::class, 'update'])->name('career-applications.update');
    
    // Navigation Items
    Route::resource('navigation-items', Admin\NavigationItemController::class);
    
    // Announcements
    Route::resource('announcements', Admin\AnnouncementController::class);
    
    // Hero Slider
    Route::get('hero-slider', [Admin\HeroSliderController::class, 'index'])->name('hero-slider.index');
    Route::get('hero-slider/create', function() {
        return view('admin.hero-slider.create');
    })->name('hero-slider.create');
    Route::post('hero-slider', [Admin\HeroSliderController::class, 'store'])->name('hero-slider.store');
    Route::get('hero-slider/{slide}/edit', [Admin\HeroSliderController::class, 'edit'])->name('hero-slider.edit');
    Route::put('hero-slider/{slide}', [Admin\HeroSliderController::class, 'update'])->name('hero-slider.update');
    Route::delete('hero-slider/{slide}', [Admin\HeroSliderController::class, 'destroy'])->name('hero-slider.destroy');
    Route::post('hero-slider/reorder', [Admin\HeroSliderController::class, 'reorder'])->name('hero-slider.reorder');
    Route::post('hero-slider/{slide}/toggle-active', [Admin\HeroSliderController::class, 'toggleActive'])->name('hero-slider.toggle-active');
    Route::post('hero-slider/{slide}/duplicate', [Admin\HeroSliderController::class, 'duplicate'])->name('hero-slider.duplicate');
    
    // Homepage Section Managers
    Route::get('homepage/news-ticker', [Admin\Homepage\NewsTickerController::class, 'index'])->name('homepage.news-ticker.index');
    Route::put('homepage/news-ticker', [Admin\Homepage\NewsTickerController::class, 'update'])->name('homepage.news-ticker.update');
    
    Route::get('homepage/introduction', [Admin\Homepage\IntroductionController::class, 'index'])->name('homepage.introduction.index');
    Route::put('homepage/introduction', [Admin\Homepage\IntroductionController::class, 'update'])->name('homepage.introduction.update');
    Route::post('homepage/introduction/images/{imageId}/delete', [Admin\Homepage\IntroductionController::class, 'deleteImage'])
        ->where('imageId', '[0-9]+')
        ->name('homepage.introduction.delete-image');
    
    Route::get('homepage/notices-chairman', [Admin\Homepage\NoticesChairmanController::class, 'index'])->name('homepage.notices-chairman.index');
    Route::put('homepage/notices-chairman', [Admin\Homepage\NoticesChairmanController::class, 'update'])->name('homepage.notices-chairman.update');
    
    Route::get('homepage/services', [Admin\Homepage\ServicesController::class, 'index'])->name('homepage.services.index');
    Route::put('homepage/services', [Admin\Homepage\ServicesController::class, 'update'])->name('homepage.services.update');
    
    Route::get('homepage/events', [Admin\Homepage\EventsController::class, 'index'])->name('homepage.events.index');
    Route::put('homepage/events', [Admin\Homepage\EventsController::class, 'update'])->name('homepage.events.update');
    
    Route::get('homepage/videos', [Admin\Homepage\VideosController::class, 'index'])->name('homepage.videos.index');
    Route::put('homepage/videos', [Admin\Homepage\VideosController::class, 'update'])->name('homepage.videos.update');
    
    Route::get('homepage/news', [Admin\Homepage\NewsController::class, 'index'])->name('homepage.news.index');
    Route::put('homepage/news', [Admin\Homepage\NewsController::class, 'update'])->name('homepage.news.update');
    
    Route::get('homepage/testimonials', [Admin\Homepage\TestimonialsController::class, 'index'])->name('homepage.testimonials.index');
    Route::put('homepage/testimonials', [Admin\Homepage\TestimonialsController::class, 'update'])->name('homepage.testimonials.update');
    
    Route::get('homepage/partners', [Admin\Homepage\PartnersController::class, 'index'])->name('homepage.partners.index');
    Route::put('homepage/partners', [Admin\Homepage\PartnersController::class, 'update'])->name('homepage.partners.update');
    
    // Cache Management
    Route::post('cache/clear-homepage', [Admin\AdminCacheController::class, 'clearHomepageCache'])->name('cache.clear-homepage');
    
    // Media Upload (for Quill.js)
    Route::post('media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');
});

