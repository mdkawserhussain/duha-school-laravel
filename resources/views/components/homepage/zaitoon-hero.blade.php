@php
    $heroSlides = $heroSlides ?? collect([]);
    // Get all active hero slides for carousel (FR-3.10)
    $allSlides = $heroSlides->where('is_active', true)->take(10)->values(); // Max 10 slides per PRD Q4
    $defaultSlide = $allSlides->first();
    
    // Default content if no slides
    $defaultTitle = 'Nurturing Brilliance, One Child at a Time';
    $defaultDescription = 'A Cambridge and Islamic integrated curriculum inspiring young minds to lead with knowledge, character, and compassion.';
    $defaultButtonText = 'Apply Now';
    $defaultButtonLink = route('admission.index', [], false);
@endphp

<section 
    class="relative w-full overflow-hidden bg-za-green-primary hero-section" 
    style="margin: 0 !important; padding: 0 !important; min-height: 90vh; position: relative; margin-top: 0 !important; padding-top: 0 !important;"
    x-data="{
        currentSlide: 0,
        totalSlides: {{ $allSlides->count() ?: 1 }},
        autoplayInterval: null,
        isPaused: false
    }"
    x-init="
        // Initialize autoplay (FR-3.8)
        if (totalSlides > 1) {
            autoplayInterval = setInterval(function() {
                if (!isPaused) {
                    currentSlide = (currentSlide + 1) % totalSlides;
                }
            }, 5000);
        }
        
        // Reset autoplay on slide change (FR-3.10)
        $watch('currentSlide', function() {
            if (totalSlides > 1 && !isPaused) {
                clearInterval(autoplayInterval);
                autoplayInterval = setInterval(function() {
                    if (!isPaused) {
                        currentSlide = (currentSlide + 1) % totalSlides;
                    }
                }, 5000);
            }
        });
        
        // Pause on hover (FR-3.9)
        $el.addEventListener('mouseenter', function() {
            isPaused = true;
        });
        $el.addEventListener('mouseleave', function() {
            isPaused = false;
        });
    "
>
    {{-- Green Background (FR-3.1) --}}
    <div class="absolute inset-0 bg-za-green-primary z-0" style="background-color: #1a5e4a;"></div>
    
    {{-- Carousel Slides Container --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24"
         style="padding-top: 10rem; min-height: 90vh; display: flex; align-items: center;">
        
        @if($allSlides->count() > 0)
            @foreach($allSlides as $index => $slide)
                @php
                    $title = $slide->title ?? $defaultTitle;
                    $subtitle = $slide->subtitle ?? '';
                    $headline = trim(($title . ' ' . $subtitle)) ?: $defaultTitle;
                    $description = $slide->description ?? $defaultDescription;
                    $primaryButtonText = $slide->button_text ?? $defaultButtonText;
                    $primaryButtonLink = $slide->button_link ?? $defaultButtonLink;
                    
                    // Get hero image with WebP support (FR-3.8) - FIXED: Using proper method with asset()
                    $heroImage = null;
                    if ($slide->hasMedia('images')) {
                        $heroImage = $slide->getMediaUrl('images', 'webp') ?: $slide->getMediaUrl('images');
                    } else {
                        $heroImage = asset('images/hero-poster.jpg');
                    }
                @endphp
                
                {{-- Slide Content (FR-3.4) --}}
                <div 
                    x-show="currentSlide === {{ $index }}"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center w-full"
                    {!! $index === 0 ? 'style="display: grid;"' : 'style="display: none;"' !!}
                >
                    {{-- Left Side: Text Content on Green Background (FR-3.4) --}}
                    <div class="text-white space-y-6 z-20">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight text-white">
                            {{ $headline }}
                        </h1>
                        @if($description)
                        <p class="text-lg sm:text-xl text-white/90 leading-relaxed max-w-xl">
                            {{ $description }}
                        </p>
                        @endif
                        @if($primaryButtonText)
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ $primaryButtonLink }}" 
                               class="inline-flex items-center justify-center bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold px-8 py-4 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                                {{ $primaryButtonText }}
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Right Side: Yellow Curved Shape with Image (FR-3.2) --}}
                    <div class="relative z-10 h-[500px] lg:h-[600px]">
                        {{-- Yellow Curved Background Shape (FR-3.2) --}}
                        <div class="absolute inset-0 bg-za-yellow-accent rounded-tl-[100px] rounded-br-[100px] transform rotate-3 opacity-90" 
                             style="clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); width: 100%; height: 100%; background-color: #fbbf24;"></div>
                        
                        {{-- Image Container (FR-3.4, FR-3.8) --}}
                        <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl h-full" style="transform: rotate(-2deg);">
                            @if($heroImage)
                            <picture>
                                @php
                                    $media = $slide->hasMedia('images') ? $slide->getFirstMedia('images') : null;
                                @endphp
                                @if($media && $media->hasGeneratedConversion('webp'))
                                    <source srcset="{{ $slide->getMediaUrl('images', 'webp') }}" type="image/webp">
                                @endif
                                <img 
                                    src="{{ $heroImage }}" 
                                    alt="{{ $headline }}"
                                    class="w-full h-full object-cover"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                >
                            </picture>
                            @else
                            <div class="w-full h-full bg-za-green-light flex items-center justify-center">
                                <span class="text-za-green-primary text-lg">Hero Image</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Fallback if no slides --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center w-full">
                <div class="text-white space-y-6 z-20">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight text-white">
                        {{ $defaultTitle }}
                    </h1>
                    <p class="text-lg sm:text-xl text-white/90 leading-relaxed max-w-xl">
                        {{ $defaultDescription }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ $defaultButtonLink }}" 
                           class="inline-flex items-center justify-center bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold px-8 py-4 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                            {{ $defaultButtonText }}
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative z-10 h-[500px] lg:h-[600px]">
                    <div class="absolute inset-0 bg-za-yellow-accent rounded-tl-[100px] rounded-br-[100px] transform rotate-3 opacity-90" 
                         style="clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); width: 100%; height: 100%; background-color: #fbbf24;"></div>
                    <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl h-full bg-za-green-light flex items-center justify-center" style="transform: rotate(-2deg);">
                        <span class="text-za-green-primary text-lg">Hero Image</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    {{-- Carousel Controls (FR-3.5) --}}
    @if($allSlides->count() > 1)
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex items-center gap-4">
        {{-- Previous Arrow (FR-3.5) --}}
        <button 
            @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
            class="w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50"
            aria-label="Previous slide"
            :aria-disabled="currentSlide === 0"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        {{-- Pagination Dots (FR-3.5) --}}
        <div class="flex gap-2" role="tablist" aria-label="Slide navigation">
            @foreach($allSlides as $index => $slide)
            <button 
                @click="currentSlide = {{ $index }}"
                class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/50"
                :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50'"
                :aria-selected="currentSlide === {{ $index }}"
                aria-label="Go to slide {{ $index + 1 }}"
                role="tab"
            >
            </button>
            @endforeach
        </div>
        
        {{-- Next Arrow (FR-3.5) --}}
        <button 
            @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
            class="w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50"
            aria-label="Next slide"
            :aria-disabled="currentSlide === totalSlides - 1"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    @endif
</section>