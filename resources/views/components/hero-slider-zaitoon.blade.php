{{-- Zaitoon Academy Hero Slider Component --}}
@props([
    'slides' => [],
    'autoplay' => true,
    'interval' => 5000,
    'showIndicators' => true,
    'showArrows' => true,
    'height' => 'min-h-[500px] lg:min-h-[600px]'
])

@php
    // Ensure slides is an array
    $slides = is_array($slides) ? $slides : $slides->toArray();
    
    // Default slide if none provided
    if (empty($slides)) {
        $slides = [[
            'image' => asset('images/hero-default.jpg'),
            'title' => 'Welcome to Zaitoon Academy',
            'subtitle' => 'Excellence in Islamic Education',
            'description' => 'Nurturing future leaders with strong moral character and academic excellence.',
            'ctaPrimary' => ['text' => 'Apply Now', 'url' => route('admission.index')],
            'ctaSecondary' => ['text' => 'Learn More', 'url' => route('about.index')],
        ]];
    }
    
    $slideCount = count($slides);
@endphp

<section
    x-data="{
        currentSlide: 0,
        totalSlides: {{ $slideCount }},
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        interval: {{ $interval }},
        autoplayInterval: null,
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        
        goToSlide(index) {
            this.currentSlide = index;
        },
        
        startAutoplay() {
            if (this.autoplay) {
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, this.interval);
            }
        },
        
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },
        
        resetAutoplay() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-full {{ $height }} overflow-hidden bg-gray-900"
    role="region"
    aria-label="Hero carousel"
>
    {{-- Slides --}}
    <div class="relative h-full">
        @foreach($slides as $index => $slide)
            <div
                x-show="currentSlide === {{ $index }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0"
                style="display: none;"
            >
                {{-- Background Image --}}
                <div class="absolute inset-0">
                    <img
                        src="{{ $slide['image'] ?? asset('images/hero-default.jpg') }}"
                        alt="{{ $slide['title'] ?? 'Hero slide' }}"
                        class="w-full h-full object-cover"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    >
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-za-green-dark/90 via-za-green-dark/70 to-transparent"></div>
                </div>

                {{-- Content --}}
                <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                    <div class="max-w-3xl space-y-6">
                        {{-- Subtitle --}}
                        @if(!empty($slide['subtitle']))
                        <div
                            x-show="currentSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <span class="inline-block px-4 py-2 bg-za-yellow-accent/20 text-za-yellow-accent font-semibold text-sm uppercase tracking-wide rounded-full border border-za-yellow-accent/30">
                                {{ $slide['subtitle'] }}
                            </span>
                        </div>
                        @endif

                        {{-- Title --}}
                        @if(!empty($slide['title']))
                        <h2
                            x-show="currentSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold text-white leading-tight"
                        >
                            {{ $slide['title'] }}
                        </h2>
                        @endif

                        {{-- Description --}}
                        @if(!empty($slide['description']))
                        <p
                            x-show="currentSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-400"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-lg md:text-xl text-gray-200 leading-relaxed"
                        >
                            {{ $slide['description'] }}
                        </p>
                        @endif

                        {{-- CTAs --}}
                        @if(!empty($slide['ctaPrimary']) || !empty($slide['ctaSecondary']))
                        <div
                            x-show="currentSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-500"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="flex flex-wrap gap-4"
                        >
                            @if(!empty($slide['ctaPrimary']))
                            <a
                                href="{{ $slide['ctaPrimary']['url'] ?? '#' }}"
                                class="inline-flex items-center px-8 py-4 bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-bold rounded-full transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-za-yellow"
                            >
                                {{ $slide['ctaPrimary']['text'] ?? 'Learn More' }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                            @endif

                            @if(!empty($slide['ctaSecondary']))
                            <a
                                href="{{ $slide['ctaSecondary']['url'] ?? '#' }}"
                                class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-za-green-dark transition-all duration-200 hover:scale-105"
                            >
                                {{ $slide['ctaSecondary']['text'] ?? 'Explore' }}
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Navigation Arrows --}}
    @if($showArrows && $slideCount > 1)
    <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 pointer-events-none">
        <button
            @click="prevSlide(); resetAutoplay()"
            class="pointer-events-auto p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white"
            aria-label="Previous slide"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button
            @click="nextSlide(); resetAutoplay()"
            class="pointer-events-auto p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white"
            aria-label="Next slide"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
    @endif

    {{-- Pagination Dots --}}
    @if($showIndicators && $slideCount > 1)
    <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-3">
        @foreach($slides as $index => $slide)
        <button
            @click="goToSlide({{ $index }}); resetAutoplay()"
            class="transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white rounded-full"
            :class="currentSlide === {{ $index }} ? 'w-12 h-3 bg-za-yellow-accent' : 'w-3 h-3 bg-white/50 hover:bg-white/75'"
            aria-label="Go to slide {{ $index + 1 }}"
        ></button>
        @endforeach
    </div>
    @endif

    {{-- Slide Counter --}}
    <div class="absolute top-4 right-4 px-4 py-2 bg-black/30 backdrop-blur-sm text-white text-sm font-semibold rounded-full">
        <span x-text="(currentSlide + 1)"></span> / {{ $slideCount }}
    </div>
</section>

{{-- Add custom CSS for smooth transitions --}}
@push('styles')
<style>
    /* Ensure smooth slide transitions */
    [x-cloak] { display: none !important; }
    
    /* Optimize image loading */
    .hero-slider img {
        will-change: transform;
    }
    
    /* Pause animation on hover */
    .hero-slider:hover .animate-pause {
        animation-play-state: paused;
    }
</style>
@endpush
