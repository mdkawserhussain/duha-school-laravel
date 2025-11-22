<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsletterController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Zaitoon Academy Component Demo
Route::get('/zaitoon-demo', function () {
    return view('pages.zaitoon-demo');
})->name('zaitoon.demo');

// Language
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event:slug}/ics', [EventController::class, 'exportIcs'])->name('events.ics');
Route::get('/feed/events.atom', [EventController::class, 'feed'])->name('events.feed');

// Notices
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice:slug}', [NoticeController::class, 'show'])->name('notices.show');

// Admission
Route::get('/admission', [AdmissionController::class, 'index'])->name('admission.index');
Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store')->middleware('throttle:5,1');

// Careers
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::post('/careers', [CareerController::class, 'store'])->name('careers.store')->middleware('throttle:5,1');

// Contact
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'send'])->name('contact.send')->middleware('throttle:10,1');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe')
    ->middleware('throttle:3,1');


// Dynamic Pages - Category-based routes
Route::get('/about-us', [PageController::class, 'category'])->name('about.index');
Route::get('/about-us/{page}', [PageController::class, 'category'])->name('about.show');
Route::get('/academics', [PageController::class, 'category'])->name('academics.index');
Route::get('/academics/{page}', [PageController::class, 'category'])->name('academics.show');
Route::get('/facilities', [PageController::class, 'category'])->name('facilities.index');
Route::get('/facilities/{page}', [PageController::class, 'category'])->name('facilities.show');
Route::get('/activities-programs', [PageController::class, 'category'])->name('activities.index');
Route::get('/activities-programs/{page}', [PageController::class, 'category'])->name('activities.show');
Route::get('/admissions', [PageController::class, 'category'])->name('admissions.index');
Route::get('/admissions/{page}', [PageController::class, 'category'])->name('admissions.show');
Route::get('/parent-engagement', [PageController::class, 'category'])->name('parent-engagement.index');
Route::get('/parent-engagement/{page}', [PageController::class, 'category'])->name('parent-engagement.show');

// Legacy routes for backward compatibility
Route::get('/about/{page}', [PageController::class, 'show'])->name('about.legacy');
Route::get('/academic/{page}', [PageController::class, 'show'])->name('academic.legacy');
Route::get('/campus', [PageController::class, 'show'])->name('campus.show');
Route::get('/privacy-policy', [PageController::class, 'show'])->name('privacy.show');
Route::get('/terms-of-service', [PageController::class, 'show'])->name('terms.show');

// Generic page route for Filament preview (fallback)
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');

// Staff Directory
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');

// Media Gallery
Route::get('/media/gallery', [PageController::class, 'gallery'])->name('media.gallery');

// Sitemap
Route::get('/sitemap.xml', function () {
    $sitemapPath = public_path('sitemap.xml');
    if (file_exists($sitemapPath)) {
        return response()->file($sitemapPath);
    }
    abort(404, 'Sitemap not found. Run: php artisan sitemap:generate');
})->name('sitemap');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/admin');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes (Breeze)
require __DIR__.'/auth.php';
