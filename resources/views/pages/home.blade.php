@extends('layouts.app')

@section('title', 'Welcome to Al-Maghrib International School')
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<main id="main-content" role="main">
    <x-home.hero
        :badge="$hero['badge'] ?? null"
        :heading="$hero['heading'] ?? null"
        :description="$hero['description'] ?? null"
        :primary-action="$hero['primaryAction'] ?? null"
        :secondary-action="$hero['secondaryAction'] ?? null"
        :stats="$hero['stats'] ?? []"
        :background="$hero['background'] ?? null"
    />

    <x-home.info-panels :panels="$featurePanels" />

    <x-home.stat-highlight :items="$statHighlights" />

    <!-- Upcoming Events Section -->
    @if($upcomingEvents && $upcomingEvents->count() > 0)
    <section class="section-modern bg-white section-fade-in" aria-labelledby="upcoming-events-heading">
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
    <section class="section-modern bg-gradient-to-b from-gray-50 to-white section-fade-in" aria-labelledby="vision-heading">
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
    <section class="section-modern animated-bg text-white section-fade-in" aria-labelledby="competition-heading">
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
    <section class="section-modern bg-white section-fade-in" aria-labelledby="why-choose-heading">
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
    <section class="section-modern animated-bg text-white section-fade-in" aria-labelledby="responsibility-heading">
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
    <section class="section-modern bg-gradient-to-b from-white to-gray-50 section-fade-in" aria-labelledby="values-heading">
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
    <section class="section-modern bg-white section-fade-in" aria-labelledby="advisors-heading">
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
    <section class="section-modern bg-gradient-to-b from-gray-50 to-white section-fade-in" aria-labelledby="board-heading">
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
