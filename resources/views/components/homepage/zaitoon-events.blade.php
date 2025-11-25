{{-- Zaitoon Academy: Campus Activities & Events (FR-8) --}}
@php
    // Get settings from HomePageSection
    $homePageSections = $homePageSections ?? collect([]);
    $eventsSection = $homePageSections->get('events');
    $sectionData = $eventsSection?->data ?? [];
    
    // Get settings with defaults
    $titleOverride = $sectionData['title_override'] ?? null;
    $itemsCount = (int) ($sectionData['items_count'] ?? 12);
    $layoutStyle = $sectionData['layout_style'] ?? 'carousel';
    $buttonText = $eventsSection?->button_text ?? 'View All Events';
    $buttonLink = $eventsSection?->button_link ?? route('events.index', [], false);
    $sectionTitle = $titleOverride ?? $eventsSection?->title ?? 'Campus Activities & Events';
    
    // Check if section is active
    if ($eventsSection && !$eventsSection->is_active) {
        return; // Don't render if section is inactive
    }
    
    // Pull events from Event model (FR-8.6)
    $upcomingEvents = $upcomingEvents ?? collect([]);
    $featuredEvents = $featuredEvents ?? collect([]);
    $events = $upcomingEvents;
    if ($events->isEmpty() && $featuredEvents->isNotEmpty()) {
        $events = $featuredEvents;
    }
    // Get events for carousel based on database setting
    $allEvents = $events->take($itemsCount);
    $totalEvents = $allEvents->count();
@endphp

<section class="py-16 lg:py-24" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);" 
         x-data="{
             currentIndex: 0,
             totalItems: {{ $totalEvents }},
             itemsPerView: 4,
             autoplayInterval: null,
             isPaused: false,
             init() {
                 this.updateItemsPerView();
                 window.addEventListener('resize', () => this.updateItemsPerView());
                 if (this.totalItems > this.itemsPerView) {
                     this.startAutoplay();
                 }
                 this.$el.addEventListener('mouseenter', () => { this.isPaused = true; });
                 this.$el.addEventListener('mouseleave', () => { this.isPaused = false; });
             },
             updateItemsPerView() {
                 if (window.innerWidth >= 1024) {
                     this.itemsPerView = 4;
                 } else if (window.innerWidth >= 640) {
                     this.itemsPerView = 2;
                 } else {
                     this.itemsPerView = 1;
                 }
             },
             startAutoplay() {
                 this.autoplayInterval = setInterval(() => {
                     if (!this.isPaused) {
                         this.currentIndex = (this.currentIndex + 1) % (this.totalItems - this.itemsPerView + 1);
                     }
                 }, 5000);
             }
         }"
         ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12 fade-in">
            <div class="flex items-center justify-center gap-2 mb-3">
                <svg class="w-8 h-8" style="color: #fbbf24;" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <h2 class="text-3xl sm:text-4xl font-bold" style="color: #008236;">
                    {{ $sectionTitle }}
                </h2>
            </div>
            @if($eventsSection && $eventsSection->description)
            <p class="text-sm sm:text-base text-gray-600 max-w-3xl mx-auto">
                {{ $eventsSection->description }}
            </p>
            @else
            <p class="text-sm sm:text-base text-gray-600 max-w-3xl mx-auto">
                Explore the latest events, cultural programs, and activities happening at our campus. Stay engaged and celebrate every moment of learning and fun!
            </p>
            @endif
        </div>
        
        @if($allEvents->isNotEmpty())
        {{-- Carousel Container (FR-8.3) --}}
        <div class="relative">
            {{-- Previous Arrow (FR-8.5) --}}
            <button 
                @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : (totalItems - itemsPerView)"
                x-show="totalItems > itemsPerView"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-za-green-primary hover:text-white flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                aria-label="Previous events"
                :disabled="currentIndex === 0"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            {{-- Events Carousel (FR-8.4) --}}
            <div class="overflow-hidden">
                <div 
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'"
                >
                    @foreach($allEvents as $event)
                    <div class="w-full sm:w-1/2 lg:w-1/4 flex-shrink-0 px-3 zoom-in">
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 h-full flex flex-col">
                            @if($event->hasMedia('images'))
                            <div class="relative h-48 overflow-hidden">
                                @php
                                    $webpUrl = $event->getMediaUrl('images', 'webp');
                                    $imageUrl = $event->getMediaUrl('images', 'medium');
                                @endphp
                                <picture>
                                    @if($webpUrl)
                                        <source srcset="{{ $event->getMediaUrl('images', 'webp') }}" type="image/webp">
                                    @endif
                                    <img 
                                        src="{{ $imageUrl }}" 
                                        alt="{{ $event->title }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                </picture>
                            </div>
                            @else
                            <div class="h-48 bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400">Event Image</span>
                            </div>
                            @endif
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $event->title }}
                                </h3>
                                <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $event->start_at ? $event->start_at->format('d M Y') : ($event->event_date ? $event->event_date->format('d M Y') : 'Date TBA') }}</span>
                                    </div>
                                    <a href="{{ route('events.show', $event->slug ?? $event->id, false) }}" 
                                       class="text-xs font-medium hover:underline"
                                       style="color: #008236;">
                                        Read More →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Next Arrow (FR-8.5) --}}
            <button 
                @click="currentIndex = currentIndex < (totalItems - itemsPerView) ? currentIndex + 1 : 0"
                x-show="totalItems > itemsPerView"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-za-green-primary hover:text-white flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                aria-label="Next events"
                :disabled="currentIndex >= (totalItems - itemsPerView)"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        
        {{-- Pagination Dots (FR-8.5) --}}
        @if($totalEvents > 4)
        <div class="flex justify-center gap-2 mt-8" role="tablist" aria-label="Event carousel navigation">
            @for($i = 0; $i < max(1, ceil($totalEvents / 4)); $i++)
            <button 
                @click="currentIndex = {{ $i * 4 }}"
                class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                :class="Math.floor(currentIndex / 4) === {{ $i }} ? 'bg-za-green-primary' : 'bg-gray-300'"
                :aria-selected="Math.floor(currentIndex / 4) === {{ $i }}"
                aria-label="Go to page {{ $i + 1 }}"
                role="tab"
            >
            </button>
            @endfor
        </div>
        @endif
        
        {{-- View All Events Button --}}
        @if($buttonText && $buttonLink)
        <div class="text-center mt-10">
            <a href="{{ $buttonLink }}" 
               class="inline-flex items-center justify-center text-white font-semibold px-8 py-3 rounded-full transition-all duration-200 hover:shadow-lg"
               style="background-color: #008236;"
               onmouseover="this.style.backgroundColor='#0a4536'"
               onmouseout="this.style.backgroundColor='#008236'">
                {{ $buttonText }}
            </a>
        </div>
        @endif
        @else
        <div class="text-center py-12 bg-white rounded-xl">
            <p class="text-gray-500">No events available at the moment.</p>
        </div>
        @endif
    </div>
</section>

