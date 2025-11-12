@extends('layouts.app')

@section('title', 'Welcome to Al-Maghrib International School')
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<main id="main-content" role="main">
    @php
        $heroSlides = $heroSlides ?? collect();
        $defaultHighlights = [
            'Academic: Cambridge Early Years Foundation Stage (Play, Nursery and Reception)',
            'Islamic Studies',
            'Cambridge Primary - Key Stage 1 & 2 (Class 1 to 6)',
            'Character Development Curriculum',
            'Hifz Curriculum',
        ];
    @endphp

    <!-- Modern Hero Slider Section -->
    @if($heroSlides->count() > 0)
    <section class="relative animated-bg text-white overflow-hidden min-h-[600px] md:min-h-[700px] flex items-center" aria-label="Hero slider">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-20 z-0">
            <div class="absolute top-20 left-10 w-32 h-32 float-animation">
                <svg viewBox="0 0 100 100" class="w-full h-full text-white" aria-hidden="true">
                    <rect x="20" y="30" width="60" height="50" rx="5" fill="currentColor"/>
                    <circle cx="35" cy="50" r="5" fill="#1e40af"/>
                    <circle cx="65" cy="50" r="5" fill="#1e40af"/>
                    <rect x="30" y="80" width="15" height="20" rx="2" fill="currentColor"/>
                    <rect x="55" y="80" width="15" height="20" rx="2" fill="currentColor"/>
                </svg>
            </div>
            <div class="absolute top-40 right-20 w-24 h-24 float-animation" style="animation-delay: 2s;">
                <svg viewBox="0 0 100 100" class="w-full h-full text-white" aria-hidden="true">
                    <rect x="25" y="35" width="50" height="45" rx="5" fill="currentColor"/>
                    <circle cx="40" cy="55" r="4" fill="#1e40af"/>
                    <circle cx="60" cy="55" r="4" fill="#1e40af"/>
                    <rect x="30" y="80" width="12" height="18" rx="2" fill="currentColor"/>
                    <rect x="58" y="80" width="12" height="18" rx="2" fill="currentColor"/>
                </svg>
            </div>
        </div>

        <!-- Cityscape Silhouette -->
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-900 to-transparent opacity-30 z-0" aria-hidden="true">
            <svg class="w-full h-full" viewBox="0 0 1200 200" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="0,200 50,150 100,170 150,120 200,140 250,100 300,130 350,90 400,110 450,80 500,100 550,70 600,90 650,60 700,80 750,50 800,70 850,40 900,60 950,30 1000,50 1050,20 1100,40 1150,10 1200,30 1200,200 0,200" fill="currentColor"/>
            </svg>
        </div>

        <!-- Slider Container -->
        <div id="heroSlider" class="hero-slider-container relative w-full h-full z-10">
            <div class="slider-wrapper relative overflow-hidden">
                <div class="slider-track flex transition-transform duration-700 ease-in-out" style="transform: translateX(0%)" role="region" aria-label="Hero slideshow">
                    @foreach($heroSlides as $index => $slide)
                    @php
                        $slideImage = null;
                        if ($slide->hasMedia('images')) {
                            $media = $slide->getFirstMedia('images');
                            // Use request()->getSchemeAndHttpHost() to get current host (works with localhost or 127.0.0.1)
                            $baseUrl = request()->getSchemeAndHttpHost();
                            $slideImage = $media ? $baseUrl . '/storage/' . $media->id . '/' . $media->file_name : null;
                        }
                    @endphp
                    <div class="slider-slide min-w-full flex items-center relative" data-slide-index="{{ $index }}" role="group" aria-roledescription="slide" aria-label="Slide {{ $index + 1 }} of {{ $heroSlides->count() }}">
                        @if($slideImage)
                        <!-- Background Image for this slide -->
                        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0" style="background-image: url('{{ $slideImage }}');"></div>
                        <!-- Dark overlay for text readability -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
                        @endif
                        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full z-10">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                                <!-- Main Hero Content -->
                                <div class="lg:col-span-2">
                                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight">
                                        {{ $slide->title ?? 'AL-MAGHRIB' }}<br>
                                        <span class="text-yellow-400 font-black tracking-wider" style="font-family: 'Arial Black', sans-serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                            {{ $slide->subtitle ?? 'INTERNATIONAL SCHOOL' }}
                                        </span>
                                    </h1>
                                    @if($slide->description)
                                    <p class="text-lg md:text-xl mb-6 text-blue-100">{{ $slide->description }}</p>
                                    @elseif($slide->content)
                                    <div class="text-lg md:text-xl mb-6 text-blue-100">{!! Str::limit(strip_tags($slide->content), 150) !!}</div>
                                    @endif
                                    @if($slide->button_text && $slide->button_link)
                                    <a href="{{ $slide->button_link }}" class="btn-modern-secondary inline-block mt-4" aria-label="{{ $slide->button_text }}">
                                        {{ $slide->button_text }}
                                    </a>
                                    @endif
                                </div>

                                <!-- Academic Highlights Sidebar -->
                                @php
                                    $academicHighlights = isset($slide->data['academic_highlights']) ? $slide->data['academic_highlights'] : $defaultHighlights;
                                @endphp
                                <div class="lg:col-span-1 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20 shadow-xl">
                                    <h3 class="text-xl font-bold mb-4 text-yellow-400">Academic Highlights</h3>
                                    <ul class="space-y-3" role="list">
                                        @foreach($academicHighlights as $highlight)
                                        <li class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 pulse-glow" aria-hidden="true">
                                                <span class="text-blue-900 font-bold text-sm">{{ strtoupper(substr($highlight, 0, 1)) }}</span>
                                            </div>
                                            <span class="text-sm text-white">{{ $highlight }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            @if($heroSlides->count() > 1)
            <button id="sliderPrev" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition duration-300 focus-visible-modern" aria-label="Previous slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button id="sliderNext" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition duration-300 focus-visible-modern" aria-label="Next slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Slider Indicators -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-2" role="tablist" aria-label="Slide indicators">
                @foreach($heroSlides as $index => $slide)
                <button class="slider-indicator w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-yellow-400 w-8' : 'bg-white bg-opacity-50 hover:bg-opacity-75' }}" 
                        data-slide-to="{{ $index }}" 
                        role="tab"
                        aria-label="Go to slide {{ $index + 1 }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @else
    <!-- Fallback Hero Section -->
    <section class="relative animated-bg text-white overflow-hidden min-h-[600px] flex items-center" aria-label="Hero section">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div class="lg:col-span-2">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight">
                        AL-MAGHRIB<br>
                        <span class="text-yellow-400 font-black tracking-wider">INTERNATIONAL SCHOOL</span>
                    </h1>
                </div>
                <div class="lg:col-span-1 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20">
                    <h3 class="text-xl font-bold mb-4 text-yellow-400">Academic Highlights</h3>
                    <ul class="space-y-3" role="list">
                        @foreach($defaultHighlights as $highlight)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-blue-900 font-bold text-sm">{{ strtoupper(substr($highlight, 0, 1)) }}</span>
                            </div>
                            <span class="text-sm">{{ $highlight }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Modern Information Cards Section -->
    @php
        $infoEnrollment = $homePageSections['info_enrollment'] ?? null;
        $infoEvents = $homePageSections['info_events'] ?? null;
        $infoNotice = $homePageSections['info_notice'] ?? null;
    @endphp
    <section class="section-modern bg-gradient-to-b from-white to-gray-50" aria-labelledby="info-cards-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Enrollment News Card -->
                <article class="modern-card p-8 text-center group" tabindex="0">
                    <div class="modern-card-icon bg-gradient-to-br from-green-500 to-green-600 text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="enrollment-heading">
                        {{ $infoEnrollment->title ?? 'Enrollment News' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $infoEnrollment->description ?? 'Admissions are open for all classes. Apply now for the upcoming academic year.' }}
                    </p>
                    @if($infoEnrollment && $infoEnrollment->button_link)
                    <a href="{{ $infoEnrollment->button_link }}" class="btn-modern inline-block" aria-describedby="enrollment-heading">
                        {{ $infoEnrollment->button_text ?? 'Apply Now' }}
                    </a>
                    @endif
                </article>

                <!-- Regular Events Card -->
                <article class="modern-card p-8 text-center group" tabindex="0">
                    <div class="modern-card-icon bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="events-heading">
                        {{ $infoEvents->title ?? 'Regular Events' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $infoEvents->description ?? 'Join us for various educational and cultural events throughout the year.' }}
                    </p>
                    @if($infoEvents && $infoEvents->button_link)
                    <a href="{{ $infoEvents->button_link }}" class="btn-modern inline-block" aria-describedby="events-heading">
                        {{ $infoEvents->button_text ?? 'View Events' }}
                    </a>
                    @endif
                </article>

                <!-- Notice Board Card -->
                <article class="modern-card p-8 text-center group" tabindex="0">
                    <div class="modern-card-icon bg-gradient-to-br from-purple-500 to-purple-600 text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="notice-heading">
                        {{ $infoNotice->title ?? 'Notice Board' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $infoNotice->description ?? 'Stay updated with the latest announcements and important notifications.' }}
                    </p>
                    @if($infoNotice && $infoNotice->button_link)
                    <a href="{{ $infoNotice->button_link }}" class="btn-modern inline-block" aria-describedby="notice-heading">
                        {{ $infoNotice->button_text ?? 'View Notices' }}
                    </a>
                    @endif
                </article>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    @if($upcomingEvents && $upcomingEvents->count() > 0)
    <section class="section-modern bg-white" aria-labelledby="upcoming-events-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="upcoming-events-heading" class="heading-modern text-center mb-12">Upcoming Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($upcomingEvents->take(3) as $event)
                <article class="modern-card overflow-hidden group" tabindex="0">
                    <a href="{{ route('events.show', $event) }}" class="block focus-visible-modern">
                        @if($event->hasMedia('cover_image'))
                            <img src="{{ $event->getFirstMediaUrl('cover_image', 'medium') }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110"
                                 loading="lazy">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ strip_tags($event->description) }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <time datetime="{{ $event->event_date->format('Y-m-d') }}">
                                    {{ $event->event_date->format('M d, Y') }}
                                </time>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Vision Section -->
    @php
        $visionPage = $visionPage ?? \App\Models\Page::where('slug', 'vision')->published()->first();
    @endphp
    @if($visionPage)
    <section class="section-modern bg-gradient-to-b from-gray-50 to-white" aria-labelledby="vision-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 id="vision-heading" class="heading-modern mb-6">{{ $visionPage->title }}</h2>
                    <div class="text-gray-700 leading-relaxed text-lg">
                        {!! $visionPage->content !!}
                    </div>
                </div>
                <div class="flex gap-4 flex-col">
                    @if($visionPage->hasMedia('featured_image'))
                        <img src="{{ $visionPage->getFirstMediaUrl('featured_image', 'medium') }}" 
                             alt="{{ $visionPage->title }}" 
                             class="rounded-xl shadow-2xl w-full h-64 object-cover"
                             loading="lazy">
                    @else
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl shadow-2xl w-full h-64"></div>
                    @endif
                    <button class="btn-modern w-full flex items-center justify-between" aria-label="Watch our vision video">
                        <span class="font-semibold">Watch Our Vision Video</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Competition Section -->
    @php
        $competitionSection = $homePageSections['video_2'] ?? null;
    @endphp
    <section class="section-modern animated-bg text-white" aria-labelledby="competition-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-xl overflow-hidden shadow-2xl">
                    @if($competitionSection && isset($competitionSection->data['youtube_url']))
                        <div class="aspect-video bg-gray-900 flex items-center justify-center">
                            <button class="play-button-large w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center hover:bg-opacity-100 transition focus-visible-modern" aria-label="Play competition video">
                                <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-r from-purple-600 to-blue-600"></div>
                    @endif
                </div>
                <div>
                    <h2 id="competition-heading" class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        {{ $competitionSection->title ?? 'Relieve the Spirit of Inter-School Quran Competition' }}
                    </h2>
                    @if($competitionSection && $competitionSection->subtitle)
                    <p class="text-xl text-blue-100 mb-6">{{ $competitionSection->subtitle }}</p>
                    @endif
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 border-2 border-white rounded-full flex items-center justify-center animate-bounce">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <span class="text-lg">Scroll to explore more</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Al-Maghrib Section -->
    @php
        $whyChoose = $homePageSections['why_choose'] ?? null;
    @endphp
    @if($whyChoose)
    <section class="section-modern bg-white" aria-labelledby="why-choose-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 id="why-choose-heading" class="heading-modern mb-6">{{ $whyChoose->title ?? 'Why Choose Al-Maghrib' }}</h2>
                    <div class="text-gray-700 leading-relaxed text-lg space-y-4">
                        {!! $whyChoose->content ?? $whyChoose->description !!}
                    </div>
                </div>
                <div class="relative rounded-xl overflow-hidden shadow-2xl">
                    @if($whyChoose->hasMedia('images'))
                        <img src="{{ $whyChoose->getFirstMediaUrl('images', 'large') }}" 
                             alt="{{ $whyChoose->title }}" 
                             class="w-full h-auto transition-transform duration-300 hover:scale-105"
                             loading="lazy">
                    @else
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 w-full h-96"></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Your Children, Our Responsibility Section -->
    @php
        $childrenResponsibility = $homePageSections['children_responsibility'] ?? null;
    @endphp
    @if($childrenResponsibility)
    <section class="section-modern animated-bg text-white" aria-labelledby="responsibility-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-xl overflow-hidden shadow-2xl order-2 lg:order-1">
                    @if($childrenResponsibility->hasMedia('images'))
                        <img src="{{ $childrenResponsibility->getFirstMediaUrl('images', 'large') }}" 
                             alt="{{ $childrenResponsibility->title }}" 
                             class="w-full h-auto transition-transform duration-300 hover:scale-105"
                             loading="lazy">
                    @else
                        <div class="bg-gradient-to-r from-blue-300 to-blue-400 w-full h-96"></div>
                    @endif
                </div>
                <div class="order-1 lg:order-2">
                    <h2 id="responsibility-heading" class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        {{ $childrenResponsibility->title ?? 'Your Children, Our Responsibility' }}
                    </h2>
                    <div class="leading-relaxed space-y-4 text-blue-50 text-lg">
                        {!! $childrenResponsibility->content ?? $childrenResponsibility->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Our Values Section -->
    @php
        $valuesSection = $homePageSections['values'] ?? null;
        $values = $valuesSection && isset($valuesSection->data['values']) ? $valuesSection->data['values'] : [];
    @endphp
    @if($valuesSection && count($values) > 0)
    <section class="section-modern bg-gradient-to-b from-white to-gray-50" aria-labelledby="values-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="values-heading" class="heading-modern mb-4">{{ $valuesSection->title ?? 'Our Values' }}</h2>
                @if($valuesSection->description)
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ $valuesSection->description }}</p>
                @endif
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($values as $value)
                <div class="value-card" tabindex="0">
                    <p class="text-gray-900 font-semibold">{{ $value }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Advisors Section -->
    @php
        $advisorsSection = $homePageSections['advisors'] ?? null;
        $advisors = $advisorsSection && isset($advisorsSection->data['advisors']) ? $advisorsSection->data['advisors'] : [];
    @endphp
    @if($advisorsSection && count($advisors) > 0)
    <section class="section-modern bg-white" aria-labelledby="advisors-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="advisors-heading" class="heading-modern text-center mb-4">{{ $advisorsSection->title ?? 'Here are Our Advisors' }}</h2>
            @if($advisorsSection->subtitle)
            <p class="text-center text-gray-600 mb-12 text-lg max-w-3xl mx-auto">{{ $advisorsSection->subtitle }}</p>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($advisors as $advisor)
                <article class="advisor-card-modern" tabindex="0">
                    <div class="advisor-image-modern overflow-hidden bg-gradient-to-br from-blue-300 to-blue-500">
                        @if(isset($advisor['photo_url']))
                            <img src="{{ $advisor['photo_url'] }}" 
                                 alt="{{ $advisor['name'] ?? 'Advisor photo' }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $advisor['name'] ?? '' }}</h3>
                    <p class="text-blue-600 font-semibold mb-3">{{ $advisor['title'] ?? '' }}</p>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $advisor['description'] ?? '' }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Board of Management Section -->
    @php
        $boardSection = $homePageSections['board_management'] ?? null;
        $boardMembers = $boardSection && isset($boardSection->data['members']) ? $boardSection->data['members'] : [];
        $featuredStaff = $featuredStaff ?? collect();
    @endphp
    <section class="section-modern bg-gradient-to-b from-gray-50 to-white" aria-labelledby="board-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="board-heading" class="heading-modern text-center mb-12">{{ $boardSection->title ?? 'Board of Management' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(count($boardMembers) > 0)
                    @foreach($boardMembers as $member)
                    <article class="advisor-card-modern" tabindex="0">
                        <div class="advisor-image-modern overflow-hidden bg-gradient-to-br from-blue-300 to-blue-500">
                            @if(isset($member['photo_url']))
                                <img src="{{ $member['photo_url'] }}" 
                                     alt="{{ $member['name'] ?? 'Board member photo' }}" 
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $member['name'] ?? '' }}</h3>
                        <p class="text-blue-600 font-semibold mb-2">{{ $member['title'] ?? '' }}</p>
                        <p class="text-gray-600 text-sm">{{ $member['organization'] ?? 'AL-MAGHRIB INTERNATIONAL SCHOOL' }}</p>
                    </article>
                    @endforeach
                @elseif($featuredStaff->count() > 0)
                    @foreach($featuredStaff->take(3) as $staff)
                    <article class="advisor-card-modern" tabindex="0">
                        <div class="advisor-image-modern overflow-hidden bg-gradient-to-br from-blue-300 to-blue-500">
                            @if($staff->hasMedia('photo'))
                                <img src="{{ $staff->getFirstMediaUrl('photo', 'medium') }}" 
                                     alt="{{ $staff->name }}" 
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $staff->name }}</h3>
                        <p class="text-blue-600 font-semibold mb-2">{{ $staff->position }}</p>
                        <p class="text-gray-600 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                    </article>
                    @endforeach
                @else
                    <!-- Default Board Members -->
                    @foreach([
                        ['name' => 'MD MOHIBULLAH HELAL', 'title' => 'CHAIRMAN & PRINCIPAL'],
                        ['name' => 'MD NEAZUL HOQUE', 'title' => 'CEO & ACADEMIC DIRECTOR'],
                        ['name' => 'MOHAMMAD EMDAD ULLAH', 'title' => 'VICE PRINCIPAL']
                    ] as $member)
                    <article class="advisor-card-modern" tabindex="0">
                        <div class="advisor-image-modern overflow-hidden bg-gradient-to-br from-blue-300 to-blue-500">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $member['name'] }}</h3>
                        <p class="text-blue-600 font-semibold mb-2">{{ $member['title'] }}</p>
                        <p class="text-gray-600 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                    </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</main>

@push('scripts')
    @if(isset($heroSlides) && $heroSlides->count() > 1)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('heroSlider');
            if (!slider) return;
            
            const track = slider.querySelector('.slider-track');
            const slides = slider.querySelectorAll('.slider-slide');
            const prevBtn = document.getElementById('sliderPrev');
            const nextBtn = document.getElementById('sliderNext');
            const indicators = slider.querySelectorAll('.slider-indicator');
            
            let currentSlide = 0;
            const totalSlides = slides.length;
            let autoPlayInterval = null;
            const autoPlayDelay = 5000;
            
            function updateSlider() {
                const translateX = -currentSlide * 100;
                track.style.transform = `translateX(${translateX}%)`;
                
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('bg-yellow-400', 'w-8');
                        indicator.classList.remove('bg-white', 'bg-opacity-50');
                        indicator.setAttribute('aria-selected', 'true');
                    } else {
                        indicator.classList.remove('bg-yellow-400', 'w-8');
                        indicator.classList.add('bg-white', 'bg-opacity-50');
                        indicator.setAttribute('aria-selected', 'false');
                    }
                });
            }
            
            function goToSlide(index) {
                if (index < 0) {
                    currentSlide = totalSlides - 1;
                } else if (index >= totalSlides) {
                    currentSlide = 0;
                } else {
                    currentSlide = index;
                }
                updateSlider();
                resetAutoPlay();
            }
            
            function nextSlide() {
                goToSlide(currentSlide + 1);
            }
            
            function prevSlide() {
                goToSlide(currentSlide - 1);
            }
            
            function startAutoPlay() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
            }
            
            function stopAutoPlay() {
                if (autoPlayInterval) {
                    clearInterval(autoPlayInterval);
                    autoPlayInterval = null;
                }
            }
            
            function resetAutoPlay() {
                stopAutoPlay();
                startAutoPlay();
            }
            
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => goToSlide(index));
            });
            
            slider.addEventListener('mouseenter', stopAutoPlay);
            slider.addEventListener('mouseleave', startAutoPlay);
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') prevSlide();
                else if (e.key === 'ArrowRight') nextSlide();
            });
            
            let touchStartX = 0;
            let touchEndX = 0;
            
            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            
            slider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) nextSlide();
                    else prevSlide();
                }
            }, { passive: true });
            
            updateSlider();
            startAutoPlay();
        });
    </script>
    @endif
@endpush
@endsection
