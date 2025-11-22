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
    
    // Media Upload (for Quill.js)
    Route::post('media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');
});

