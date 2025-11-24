@php
    // Create 10 placeholder slides with images
    $placeholderImages = [
        asset('storage/hero_slide_1_1763981315182.png'),
        asset('storage/hero_slide_2_1763981346399.png'),
        asset('storage/hero_slide_3_1763981370818.png'),
        asset('storage/hero_slide_4_1763981401621.png'),
        asset('storage/hero_slide_5_1763981431354.png'),
        asset('storage/hero_slide_6_1763981461720.png'),
        asset('storage/hero_slide_7_1763981485308.png'),
        null, // Gradient placeholder
        null, // Gradient placeholder
        null, // Gradient placeholder
    ];
    
    $placeholderSlides = collect(range(1, 10))->map(function($num) use ($placeholderImages) {
        return (object)[
            'id' => $num,
            'title' => 'Islamic School Excellence ' . $num,
            'image' => $placeholderImages[$num - 1] ?? null,
        ];
    });
    
    // FORCE USE OF PLACEHOLDERS (comment out to use database slides)
    $allSlides = $placeholderSlides;
    
    // Uncomment below to use database slides instead:
    // $heroSlides = $heroSlides ?? collect([]);
    // $allSlides = $heroSlides->where('is_active', true)->take(10)->values();
    // if ($allSlides->isEmpty()) {
    //     $allSlides = $placeholderSlides;
    // }
@endphp

<style>
    /* Responsive Hero Heights */
    .hero-slider {
        height: calc(100vh - 40px);
        min-height: 500px;
    }
    
    @media (min-width: 640px) {
        .hero-slider {
            min-height: 600px;
        }
    }
    
    @media (min-width: 1024px) {
        .hero-slider {
            min-height: 700px;
        }
    }
</style>

<section 
    class="hero-slider relative w-full overflow-hidden" 
    style="margin: 0 !important; padding: 0 !important; position: relative; margin-top: 0 !important; padding-top: 0 !important;"
    x-data="{
        currentSlide: 0,
        totalSlides: {{ $allSlides->count() }},
        autoplayInterval: null,
        isPaused: false,
        init() {
            if (this.totalSlides > 1) {
                this.startAutoplay();
            }
            this.$el.addEventListener('mouseenter', () => { this.isPaused = true; });
            this.$el.addEventListener('mouseleave', () => { this.isPaused = false; });
            this.$watch('currentSlide', () => {
                if (this.totalSlides > 1 && !this.isPaused) {
                    clearInterval(this.autoplayInterval);
                    this.startAutoplay();
                }
            });
        },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                if (!this.isPaused) {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                }
            }, 5000);
        }
    }"
>
    {{-- Full-Screen Image Slides --}}
    @foreach($allSlides as $index => $slide)
        @php
            $title = $slide->title ?? 'Slide ' . ($index + 1);
            
            // Get hero image - check placeholder first, then model media
            $heroImage = null;
            
            // Check if slide has a direct image property (placeholder slides)
            if (isset($slide->image) && $slide->image) {
                $heroImage = $slide->image;
            }
            // Otherwise check if it's an Eloquent model with media
            elseif ($slide instanceof \Illuminate\Database\Eloquent\Model && method_exists($slide, 'hasMedia') && $slide->hasMedia('images')) {
                $heroImage = $slide->getMediaUrl('images', 'webp') ?: $slide->getMediaUrl('images');
            }
            
            // Gradient colors for placeholders (green theme variations)
            $gradients = [
                'linear-gradient(135deg, #008236 0%, #7AB91E 100%)',
                'linear-gradient(135deg, #165e4a 0%, #88C443 100%)',
                'linear-gradient(135deg, #006a2b 0%, #9ED45C 100%)',
                'linear-gradient(135deg, #1a6b55 0%, #C8D96F 100%)',
                'linear-gradient(135deg, #008236 0%, #A8D86E 100%)',
                'linear-gradient(135deg, #0f6350 0%, #B5DC7A 100%)',
                'linear-gradient(135deg, #12574a 0%, #7AB91E 100%)',
                'linear-gradient(135deg, #008236 0%, #95CA55 100%)',
                'linear-gradient(135deg, #1a6b55 0%, #6FB018 100%)',
                'linear-gradient(135deg, #165e4a 0%, #C8D96F 100%)',
            ];
            $gradient = $gradients[$index % count($gradients)];
        @endphp
        
        {{-- Full-Screen Image Slide --}}
        <div 
            x-show="currentSlide === {{ $index }}"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full"
            {!! $index === 0 ? 'style="display: block;"' : 'style="display: none;"' !!}
        >
            @if($heroImage)
            {{-- Full-Screen Image --}}
            <img 
                src="{{ $heroImage }}" 
                alt="{{ $title }}"
                class="w-full h-full object-cover object-center"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
            >
            {{-- Optional Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            @else
            {{-- Gradient Placeholder with Islamic School Theme --}}
            <div class="w-full h-full flex items-center justify-center relative" style="background: {{ $gradient }};">
                {{-- Decorative Islamic Pattern Overlay --}}
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
                
                {{-- Slide Number/Title --}}
                <div class="text-center z-10 px-4">
                    <div class="text-white/20 text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-bold mb-2 sm:mb-4">{{ $index + 1 }}</div>
                    <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold">{{ $title }}</h2>
                    <p class="text-white/80 text-base sm:text-lg md:text-xl mt-2">Islamic Education Excellence</p>
                </div>
            </div>
            @endif
        </div>
    @endforeach
    
    {{-- Pagination Dots Only (Green Theme) --}}
    @if($allSlides->count() > 1)
    <div class="absolute bottom-4 sm:bottom-8 md:bottom-12 left-1/2 transform -translate-x-1/2 z-30">
        <div class="flex gap-2 sm:gap-3" role="tablist" aria-label="Slide navigation">
            @foreach($allSlides as $index => $slide)
            <button 
                @click="currentSlide = {{ $index }}"
                class="rounded-full transition-all duration-300 focus:outline-none hover:scale-110"
                :class="currentSlide === {{ $index }} 
                    ? 'w-3 h-3 sm:w-3 sm:h-3 border-2 bg-transparent' 
                    : 'w-3 h-3 sm:w-3 sm:h-3 opacity-50'"
                style="border-color: #7AB91E;"
                :style="currentSlide === {{ $index }} ? 'background-color: transparent; border-color: #7AB91E;' : 'background-color: #7AB91E;'"
                aria-label="Go to slide {{ $index + 1 }}"
                role="tab"
            >
            </button>
            @endforeach
        </div>
    </div>
    @endif
</section>