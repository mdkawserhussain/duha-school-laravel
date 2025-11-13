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
        :hero-slides="$heroSlides ?? null"
    />

    <x-home.info-panels :panels="$featurePanels" />

    <x-home.stat-highlight :items="$statHighlights" />

    <!-- Upcoming Events Section -->
    @if($upcomingEvents && $upcomingEvents->count() > 0)
    <section class="section-modern bg-white section-fade-in divider-wave-top" aria-labelledby="upcoming-events-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <h2 id="upcoming-events-heading" class="heading-modern">Upcoming Events</h2>
                <a href="{{ route('events.index') }}" class="underline-draw text-blue-600 font-semibold hidden md:block">
                    View All Events
                </a>
            </div>
            
            <!-- Desktop Grid -->
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($upcomingEvents->take(3) as $event)
                <article class="card-flip-container h-full" tabindex="0">
                    <div class="card-flip modern-card overflow-hidden h-full">
                        <!-- Front of card -->
                        <div class="card-flip-front">
                            <a href="{{ route('events.show', $event) }}" class="block focus-visible-modern h-full flex flex-col">
                                @if($event->hasMedia('cover_image'))
                                    <img src="{{ $event->getFirstMediaUrl('cover_image', 'medium') }}"
                                         alt="{{ $event->title }}"
                                         class="w-full h-48 object-cover transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                                @endif
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>
                                    <div class="flex items-center text-sm text-gray-500 mt-auto">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <time datetime="{{ $event->event_date->format('Y-m-d') }}">
                                            {{ $event->event_date->format('M d, Y') }}
                                        </time>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- Back of card -->
                        <div class="card-flip-back bg-blue-600 text-white p-6 flex flex-col justify-center">
                            <h3 class="text-xl font-bold mb-4">{{ $event->title }}</h3>
                            <p class="text-blue-100 text-sm mb-4 line-clamp-4">{{ strip_tags($event->description) }}</p>
                            <a href="{{ route('events.show', $event) }}" class="text-white font-semibold underline-draw inline-block">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Mobile Carousel -->
            <div 
                x-data="eventsCarousel({{ $upcomingEvents->count() }})"
                x-init="init()"
                class="md:hidden relative"
            >
                <div class="overflow-hidden">
                    <div 
                        class="flex transition-transform duration-300 ease-in-out"
                        :style="`transform: translateX(-${currentIndex * 100}%)`"
                        @touchstart="handleTouchStart($event)"
                        @touchmove="handleTouchMove($event)"
                        @touchend="handleTouchEnd()"
                    >
                        @foreach($upcomingEvents->take(3) as $event)
                        <div class="min-w-full px-2">
                            <article class="modern-card overflow-hidden" tabindex="0">
                                <a href="{{ route('events.show', $event) }}" class="block focus-visible-modern">
                                    @if($event->hasMedia('cover_image'))
                                        <img src="{{ $event->getFirstMediaUrl('cover_image', 'medium') }}"
                                             alt="{{ $event->title }}"
                                             class="w-full h-48 object-cover transition-transform duration-300"
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
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Carousel Indicators -->
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($upcomingEvents->take(3) as $index => $event)
                    <button
                        @click="goToSlide({{ $index }})"
                        :class="currentIndex === {{ $index }} ? 'bg-blue-600 w-8' : 'bg-gray-300 w-2'"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        :aria-label="'Go to event {{ $index + 1 }}'"
                    ></button>
                    @endforeach
                </div>
            </div>

            <!-- Mobile View All Button -->
            <div class="md:hidden text-center mt-6">
                <a href="{{ route('events.index') }}" class="underline-draw text-blue-600 font-semibold">
                    View All Events
                </a>
            </div>
        </div>
    </section>
    @endif

    <script>
    function eventsCarousel(totalSlides) {
        return {
            currentIndex: 0,
            touchStartX: 0,
            touchEndX: 0,
            
            init() {
                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.previous();
                    if (e.key === 'ArrowRight') this.next();
                });
            },
            
            next() {
                this.currentIndex = (this.currentIndex + 1) % totalSlides;
            },
            
            previous() {
                this.currentIndex = (this.currentIndex - 1 + totalSlides) % totalSlides;
            },
            
            goToSlide(index) {
                this.currentIndex = index;
            },
            
            handleTouchStart(e) {
                this.touchStartX = e.touches[0].clientX;
            },
            
            handleTouchMove(e) {
                this.touchEndX = e.touches[0].clientX;
            },
            
            handleTouchEnd() {
                const swipeThreshold = 50;
                const diff = this.touchStartX - this.touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.previous();
                    }
                }
            }
        }
    }
    </script>

    <!-- Testimonials Section -->
    @php
        $testimonials = [
            [
                'name' => 'Ahmed Rahman',
                'role' => 'Parent of Grade 5 Student',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmed+Rahman&background=667eea&color=fff&size=128',
                'rating' => 5,
                'quote' => 'Al-Maghrib International School has provided an excellent balance of Islamic values and modern education. My child has flourished both academically and spiritually.',
            ],
            [
                'name' => 'Fatima Khan',
                'role' => 'Parent of Grade 8 Student',
                'avatar' => 'https://ui-avatars.com/api/?name=Fatima+Khan&background=764ba2&color=fff&size=128',
                'rating' => 5,
                'quote' => 'The teachers are dedicated and the curriculum is comprehensive. The Hifz program has been a blessing for our family.',
            ],
            [
                'name' => 'Mohammad Ali',
                'role' => 'Parent of Grade 10 Student',
                'avatar' => 'https://ui-avatars.com/api/?name=Mohammad+Ali&background=667eea&color=fff&size=128',
                'rating' => 5,
                'quote' => 'The Cambridge curriculum combined with Islamic teachings creates a unique learning environment. Highly recommended!',
            ],
            [
                'name' => 'Ayesha Begum',
                'role' => 'Parent of Grade 3 Student',
                'avatar' => 'https://ui-avatars.com/api/?name=Ayesha+Begum&background=764ba2&color=fff&size=128',
                'rating' => 5,
                'quote' => 'The STEAM labs and modern facilities have sparked my child\'s interest in science and technology. Wonderful school!',
            ],
        ];
    @endphp
    <section class="section-modern bg-gradient-to-b from-white to-gray-50 section-fade-in divider-slant-top" aria-labelledby="testimonials-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="testimonials-heading" class="heading-modern text-center mb-12">What Parents Say</h2>
            
            <div 
                x-data="testimonialsCarousel({{ count($testimonials) }})"
                x-init="init()"
                class="relative"
            >
                <div class="overflow-hidden">
                    <div 
                        class="flex transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${currentIndex * 100}%)`"
                    >
                        @foreach($testimonials as $index => $testimonial)
                        <div class="min-w-full px-4 md:px-8">
                            <div class="max-w-3xl mx-auto text-center">
                                <!-- Quote marks with animation -->
                                <div 
                                    x-show="currentIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 scale-75"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="mb-6"
                                >
                                    <svg class="w-16 h-16 mx-auto text-blue-200" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                </div>

                                <!-- Quote text -->
                                <blockquote 
                                    x-show="currentIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500 delay-100"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="text-lg md:text-xl text-gray-700 mb-8 leading-relaxed"
                                >
                                    "{{ $testimonial['quote'] }}"
                                </blockquote>

                                <!-- Star rating -->
                                <div 
                                    x-show="currentIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500 delay-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    class="star-rating justify-center mb-6"
                                >
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg 
                                            class="w-6 h-6 star star-filled" 
                                            fill="currentColor" 
                                            viewBox="0 0 20 20"
                                            aria-label="{{ $i }} star"
                                        >
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <!-- Avatar and name -->
                                <div 
                                    x-show="currentIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500 delay-300"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="flex flex-col items-center"
                                >
                                    <img 
                                        src="{{ $testimonial['avatar'] }}" 
                                        alt="{{ $testimonial['name'] }}"
                                        class="w-16 h-16 rounded-full mb-4 ring-4 ring-blue-100"
                                        loading="lazy"
                                    >
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $testimonial['name'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $testimonial['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Indicators -->
                <div class="flex justify-center gap-2 mt-8">
                    @foreach($testimonials as $index => $testimonial)
                    <button
                        @click="goToSlide({{ $index }})"
                        :class="currentIndex === {{ $index }} ? 'bg-blue-600 w-8' : 'bg-gray-300 w-2'"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        :aria-label="'Go to testimonial {{ $index + 1 }}'"
                    ></button>
                    @endforeach
                </div>

                <!-- Previous/Next Buttons -->
                <button
                    @click="previous()"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full p-3 text-gray-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300 hidden md:block"
                    aria-label="Previous testimonial"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    @click="next()"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full p-3 text-gray-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300 hidden md:block"
                    aria-label="Next testimonial"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <script>
    function testimonialsCarousel(totalSlides) {
        return {
            currentIndex: 0,
            autoplayInterval: null,
            autoplayDelay: 6000,
            
            init() {
                // Respect reduced motion preference
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }
                
                this.play();
                
                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.previous();
                    if (e.key === 'ArrowRight') this.next();
                });
            },
            
            next() {
                this.currentIndex = (this.currentIndex + 1) % totalSlides;
                this.resetAutoplay();
            },
            
            previous() {
                this.currentIndex = (this.currentIndex - 1 + totalSlides) % totalSlides;
                this.resetAutoplay();
            },
            
            goToSlide(index) {
                this.currentIndex = index;
                this.resetAutoplay();
            },
            
            play() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                this.autoplayInterval = setInterval(() => this.next(), this.autoplayDelay);
            },
            
            pause() {
                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval);
                    this.autoplayInterval = null;
                }
            },
            
            resetAutoplay() {
                this.pause();
                this.play();
            }
        }
    }
    </script>

    <!-- Vision Section -->
    @php
        $visionPage = $visionPage ?? \App\Models\Page::where('slug', 'vision')->published()->first();
    @endphp
    @if($visionPage)
    <section class="section-modern bg-gradient-to-b from-gray-50 to-white section-fade-in divider-wave-top" aria-labelledby="vision-heading">
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

    <!-- Call-to-Action Section -->
    <section class="section-modern bg-gradient-to-r from-blue-600 to-blue-700 text-white divider-slant relative overflow-hidden" aria-labelledby="cta-heading">
        <div class="absolute inset-0" style="clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 id="cta-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">Ready to Begin Your Journey?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Join Al-Maghrib International School and give your child the gift of balanced education that nurtures both mind and soul.
            </p>
            <div 
                x-data="{ loading: false, success: false }"
                class="flex flex-col sm:flex-row gap-4 justify-center items-center"
            >
                <a 
                    href="{{ route('admission.index') }}"
                    @click="loading = true; setTimeout(() => { loading = false; success = true; setTimeout(() => success = false, 3000); }, 1500)"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/50 min-w-[200px]"
                >
                    <span x-show="!loading && !success">Apply for Admission</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                    <span x-show="success && !loading" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Redirecting...
                    </span>
                </a>
                <a 
                    href="{{ route('contact.index') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-white/50"
                >
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <div 
        x-data="{ show: false }"
        x-init="
            window.addEventListener('scroll', () => {
                show = (window.pageYOffset || document.documentElement.scrollTop) > 300;
            });
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 z-50 bg-blue-600 text-white rounded-full p-4 shadow-lg hover:bg-blue-700 transition-all duration-300 cursor-pointer focus:outline-none focus:ring-4 focus:ring-blue-300"
        role="button"
        tabindex="0"
        aria-label="Back to top"
        @keydown.enter="window.scrollTo({ top: 0, behavior: 'smooth' })"
        @keydown.space.prevent="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </div>
</main>

@endsection
