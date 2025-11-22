{{-- Zaitoon Academy: Campus Activities & Events (FR-8) --}}
@php
    // Pull events from Event model (FR-8.6)
    $upcomingEvents = $upcomingEvents ?? collect([]);
    $featuredEvents = $featuredEvents ?? collect([]);
    $events = $upcomingEvents;
    if ($events->isEmpty() && $featuredEvents->isNotEmpty()) {
        $events = $featuredEvents;
    }
    // Get more events for carousel (need at least 4 for desktop view)
    $allEvents = $events->take(12); // Get more for carousel scrolling
    $totalEvents = $allEvents->count();
@endphp

<section class="py-16 lg:py-24 bg-white" 
         x-data="{
             currentIndex: 0,
             totalItems: {{ $totalEvents }},
             itemsPerView: 4,
             autoplayInterval: null,
             isPaused: false
         }"
         x-init="
             // Calculate items per view based on screen size
             function updateItemsPerView() {
                 if (window.innerWidth >= 1024) {
                     itemsPerView = 4;
                 } else if (window.innerWidth >= 640) {
                     itemsPerView = 2;
                 } else {
                     itemsPerView = 1;
                 }
             }
             updateItemsPerView();
             window.addEventListener('resize', updateItemsPerView);
             
             // Optional autoplay (FR-8.5)
             if (totalItems > itemsPerView) {
                 autoplayInterval = setInterval(function() {
                     if (!isPaused) {
                         currentIndex = (currentIndex + 1) % (totalItems - itemsPerView + 1);
                     }
                 }, 5000);
             }
             
             $el.addEventListener('mouseenter', function() {
                 isPaused = true;
             });
             $el.addEventListener('mouseleave', function() {
                 isPaused = false;
             });
         ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-8.1, FR-8.2) --}}
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-za-yellow-accent rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-za-green-dark" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-za-green-primary">
                    Campus Activities & Events
                </h2>
            </div>
            <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">
                Stay updated with our latest campus activities and events
            </p>
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
                    <div class="w-full sm:w-1/2 lg:w-1/4 flex-shrink-0 px-3">
                        <a href="{{ route('events.show', $event->slug ?? $event->id, false) }}" 
                           class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 block h-full">
                            @if($event->hasMedia('images'))
                            <div class="relative h-48 overflow-hidden">
                                @php
                                    // FIXED: Using proper method with asset()
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
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                </picture>
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg">
                                    <p class="text-xs font-semibold text-za-green-primary">
                                        {{ $event->start_date ? $event->start_date->format('d M Y') : 'Date' }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="h-48 bg-za-green-light flex items-center justify-center">
                                <span class="text-za-green-primary">Event Image</span>
                            </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-za-green-primary transition-colors line-clamp-2">
                                    {{ $event->title }}
                                </h3>
                                @if($event->description)
                                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}
                                </p>
                                @endif
                                <span class="inline-flex items-center text-za-green-primary text-sm font-medium">
                                    Read More
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
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
        
        {{-- View All Events Button (FR-8.7) --}}
        <div class="text-center mt-8">
            <a href="{{ route('events.index', [], false) }}" 
               class="inline-flex items-center justify-center bg-za-green-primary hover:bg-za-green-dark text-white font-semibold px-8 py-3 rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                View All Events
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl">
            <p class="text-gray-500">No events available at the moment.</p>
        </div>
        @endif
    </div>
</section>

