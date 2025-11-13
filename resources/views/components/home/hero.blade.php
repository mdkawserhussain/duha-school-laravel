@props([
    'badge' => null,
    'heading' => 'Inspire Lifelong Learning',
    'description' => 'A carefully balanced Cambridge and Islamic curriculum delivered by passionate educators across modern campuses.',
    'primaryAction' => null,
    'secondaryAction' => null,
    'stats' => [],
    'heroSlides' => null,
])

@php
    $slides = $heroSlides && $heroSlides->count() > 0 ? $heroSlides : collect([(object)[
        'title' => $heading,
        'subtitle' => null,
        'description' => $description,
        'data' => ['badge' => $badge],
        'button_text' => $primaryAction['label'] ?? null,
        'button_link' => $primaryAction['url'] ?? null,
    ]]);
@endphp

<section 
    x-data="heroSlider({{ $slides->count() }})"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"
    class="relative h-screen overflow-hidden"
    role="banner"
    aria-label="Hero slider"
>
    <!-- Slider Container -->
    <div class="relative h-full w-full">
        @foreach($slides as $index => $slide)
            @php
                $slideHeading = trim(collect([$slide->title, $slide->subtitle])->filter()->join(' ')) ?: $heading;
                $slideDescription = $slide->description ?: $description;
                $slideBadge = data_get($slide, 'data.badge') ?: $badge;
                $slidePrimaryAction = [
                    'label' => $slide->button_text ?: ($primaryAction['label'] ?? 'Apply Now'),
                    'url' => $slide->button_link ?: ($primaryAction['url'] ?? route('admission.index')),
                ];
                $slideImageUrl = $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images');
            @endphp
            
            <div 
                x-show="currentSlide === {{ $index }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0"
            >
                @if($slideImageUrl)
                    <img 
                        src="{{ $slideImageUrl }}" 
                        alt="{{ $slideHeading }}"
                        class="hero-image absolute inset-0 w-full h-full object-cover"
                        {{ $index === 0 ? 'loading="eager"' : 'loading="lazy"' }}
                    />
                @endif
                
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent z-10"></div>
                
                <!-- Content -->
                <div class="relative h-full flex items-center z-20">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 z-10">
                        <div class="max-w-4xl">
                            <!-- Badge with staggered animation -->
                            @if($slideBadge)
                                <div 
                                    x-show="currentSlide === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500 delay-100"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mb-6"
                                >
                                    <span class="badge-soft bg-white/20 text-xs font-semibold uppercase tracking-[0.3em] text-white inline-block">
                                        {{ $slideBadge }}
                                    </span>
                                </div>
                            @endif

                            <!-- Heading with staggered animation -->
                            <div 
                                x-show="currentSlide === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-200"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="mb-6"
                            >
                                <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight text-white">
                                    {!! \Illuminate\Support\Str::of($slideHeading)->replace('\n', '<br>') !!}
                                </h1>
                            </div>

                            <!-- Description with staggered animation -->
                            <div 
                                x-show="currentSlide === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="mb-8"
                            >
                                <p class="max-w-2xl text-base md:text-lg lg:text-xl text-white/90 leading-relaxed">
                                    {{ $slideDescription }}
                                </p>
                            </div>

                            <!-- CTA Buttons with staggered animation -->
                            <div 
                                x-show="currentSlide === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-400"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="flex flex-wrap gap-4"
                            >
                                @if($slidePrimaryAction['url'])
                                    <a 
                                        href="{{ $slidePrimaryAction['url'] }}" 
                                        class="btn-modern-primary animate-pulse-on-hover"
                                    >
                                        {{ $slidePrimaryAction['label'] }}
                                    </a>
                                @endif

                                @if($secondaryAction)
                                    <a 
                                        href="{{ $secondaryAction['url'] ?? '#' }}" 
                                        class="btn-modern bg-transparent border-2 border-white text-white hover:bg-white/10"
                                    >
                                        {{ $secondaryAction['label'] ?? 'Discover More' }}
                                    </a>
                                @endif
                            </div>

                            <!-- Stats with staggered animation -->
                            @if(!empty($stats) && $index === 0)
                                <div 
                                    x-show="currentSlide === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-500 delay-500"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-12"
                                >
                                    <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                        @foreach($stats as $stat)
                                            <div class="stat-pill bg-white/10 text-white backdrop-blur-sm">
                                                <dt class="text-sm uppercase tracking-wide text-white/70">{{ $stat['label'] ?? '' }}</dt>
                                                <dd class="text-2xl font-semibold">{{ $stat['value'] ?? '' }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Indicators -->
    @if($slides->count() > 1)
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-2">
            @foreach($slides as $index => $slide)
                <button
                    @click="goToSlide({{ $index }})"
                    :aria-selected="currentSlide === {{ $index }}"
                    :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 w-2'"
                    class="h-2 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                    :aria-label="'Go to slide {{ $index + 1 }}'"
                ></button>
            @endforeach
        </div>

        <!-- Previous/Next Buttons -->
        <button
            @click="previous()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-3 text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
            aria-label="Previous slide"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button
            @click="next()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-3 text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
            aria-label="Next slide"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    @endif
</section>

<script>
function heroSlider(totalSlides) {
    return {
        currentSlide: 0,
        autoplayInterval: null,
        autoplayDelay: 5000,
        
        init() {
            if (totalSlides <= 1) return;
            
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
            this.currentSlide = (this.currentSlide + 1) % totalSlides;
            this.resetAutoplay();
        },
        
        previous() {
            this.currentSlide = (this.currentSlide - 1 + totalSlides) % totalSlides;
            this.resetAutoplay();
        },
        
        goToSlide(index) {
            this.currentSlide = index;
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
