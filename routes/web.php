<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/ics', [EventController::class, 'exportIcs'])->name('events.ics');
Route::get('/feed/events.atom', [EventController::class, 'feed'])->name('events.feed');

// Notices
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');

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
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe')->middleware('throttle:3,1');

// Dynamic Pages
Route::get('/about/{page}', [PageController::class, 'show'])->name('about.show');
Route::get('/academic/{page}', [PageController::class, 'show'])->name('academic.show');
Route::get('/campus', [PageController::class, 'show'])->name('campus.show');
Route::get('/privacy-policy', [PageController::class, 'show'])->name('privacy.show');
Route::get('/terms-of-service', [PageController::class, 'show'])->name('terms.show');

// Staff Directory
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');

// Media Gallery
Route::get('/media/gallery', [PageController::class, 'gallery'])->name('media.gallery');

// Sitemap
Route::get('/sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'));
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
