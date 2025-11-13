@extends('layouts.app')

@section('title', 'Media Gallery - Al-Maghrib International School')
@section('meta-description', 'Browse our media gallery showcasing school events, activities, and campus life at Al-Maghrib International School')

@push('styles')
    <!-- Lightbox2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css" />
@endpush

@push('scripts')
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lightbox !== 'undefined') {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'albumLabel': 'Image %1 of %2'
                });
            }
        });
    </script>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Media Gallery</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore our collection of photos and videos showcasing school events, student activities, and campus life
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Gallery Categories -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('media.gallery') }}"
                       class="px-4 py-2 rounded-full text-sm font-medium bg-blue-600 text-white transition duration-300">
                        All
                    </a>
                    <a href="{{ route('media.gallery', ['category' => 'events']) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-300">
                        Events
                    </a>
                    <a href="{{ route('media.gallery', ['category' => 'sports']) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-300">
                        Sports
                    </a>
                    <a href="{{ route('media.gallery', ['category' => 'academics']) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-300">
                        Academics
                    </a>
                    <a href="{{ route('media.gallery', ['category' => 'campus']) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-300">
                        Campus
                    </a>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" id="gallery-grid">
                <!-- Placeholder Gallery Items -->
                @for($i = 1; $i <= 12; $i++)
                <a href="{{ asset('images/gallery/placeholder-' . $i . '.jpg') }}" 
                   data-lightbox="gallery" 
                   data-title="Gallery Item {{ $i }} - Category • Date"
                   class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 block">
                    <div class="aspect-w-4 aspect-h-3 bg-gray-200 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/gallery/placeholder-' . $i . '.jpg') }}" 
                             alt="Gallery Item {{ $i }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden h-full w-full items-center justify-center">
                            <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center pointer-events-none">
                        <div class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 px-4 py-2 rounded-lg font-medium transition duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                        <p class="text-white text-sm font-medium">Gallery Item {{ $i }}</p>
                        <p class="text-gray-300 text-xs">Category • Date</p>
                    </div>
                </a>
                @endfor
            </div>

            <!-- Load More -->
            <div class="text-center">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Load More Images
                </button>
            </div>
        </div>
    </section>

    <!-- Video Gallery Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Video Gallery</h2>
                <p class="text-lg text-gray-600">Watch our featured videos and school highlights</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Video 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l.707.707A1 1 0 0012.414 11H15m-3 7.5A9.5 9.5 0 1121.5 12 9.5 9.5 0 0112 2.5z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">School Opening Ceremony 2024</h3>
                        <p class="text-gray-600 mb-4">Highlights from our annual school opening ceremony and welcome event.</p>
                        <button class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                            ▶️ Watch Video
                        </button>
                    </div>
                </div>

                <!-- Video 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l.707.707A1 1 0 0012.414 11H15m-3 7.5A9.5 9.5 0 1121.5 12 9.5 9.5 0 0112 2.5z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Sports Day Highlights</h3>
                        <p class="text-gray-600 mb-4">Exciting moments from our annual sports day celebrations.</p>
                        <button class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                            ▶️ Watch Video
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection