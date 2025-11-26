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
    
    // Check if section is active (commented out for testing)
    // if ($eventsSection && !$eventsSection->is_active) {
    //     return; // Don't render if section is inactive
    // }
    
    // Pull events from Event model (FR-8.6)
    $upcomingEvents = $upcomingEvents ?? collect([]);
    $featuredEvents = $featuredEvents ?? collect([]);
    $events = $upcomingEvents;
    if ($events->isEmpty() && $featuredEvents->isNotEmpty()) {
        $events = $featuredEvents;
    }
    
    // FORCE DUMMY DATA FOR TESTING - Always use dummy events to test carousel
    if (true) { // Change to: if ($events->isEmpty()) { when done testing
        // Get hero slide images from storage
        $heroImages = [
            asset('storage/hero_slide_1_1763981315182.png'),
            asset('storage/hero_slide_2_1763981346399.png'),
            asset('storage/hero_slide_3_1763981370818.png'),
            asset('storage/hero_slide_4_1763981401621.png'),
            asset('storage/hero_slide_5_1763981431354.png'),
            asset('storage/hero_slide_6_1763981461720.png'),
            asset('storage/hero_slide_7_1763981485308.png'),
        ];
        
        $dummyEvents = collect([
            (object)[
                'id' => 1,
                'title' => 'Annual Sports Day 2025',
                'slug' => 'annual-sports-day-2025',
                'start_at' => now()->addDays(10),
                'event_date' => now()->addDays(10),
                'image' => $heroImages[0],
            ],
            (object)[
                'id' => 2,
                'title' => 'Science Fair & Exhibition',
                'slug' => 'science-fair-exhibition',
                'start_at' => now()->addDays(15),
                'event_date' => now()->addDays(15),
                'image' => $heroImages[1],
            ],
            (object)[
                'id' => 3,
                'title' => 'Islamic Studies Competition',
                'slug' => 'islamic-studies-competition',
                'start_at' => now()->addDays(20),
                'event_date' => now()->addDays(20),
                'image' => $heroImages[2],
            ],
            (object)[
                'id' => 4,
                'title' => 'Parent-Teacher Conference',
                'slug' => 'parent-teacher-conference',
                'start_at' => now()->addDays(25),
                'event_date' => now()->addDays(25),
                'image' => $heroImages[3],
            ],
            (object)[
                'id' => 5,
                'title' => 'Cultural Night Celebration',
                'slug' => 'cultural-night-celebration',
                'start_at' => now()->addDays(30),
                'event_date' => now()->addDays(30),
                'image' => $heroImages[4],
            ],
            (object)[
                'id' => 6,
                'title' => 'Quran Recitation Contest',
                'slug' => 'quran-recitation-contest',
                'start_at' => now()->addDays(35),
                'event_date' => now()->addDays(35),
                'image' => $heroImages[5],
            ],
            (object)[
                'id' => 7,
                'title' => 'Art & Craft Workshop',
                'slug' => 'art-craft-workshop',
                'start_at' => now()->addDays(40),
                'event_date' => now()->addDays(40),
                'image' => $heroImages[6],
            ],
            (object)[
                'id' => 8,
                'title' => 'Mathematics Olympiad',
                'slug' => 'mathematics-olympiad',
                'start_at' => now()->addDays(45),
                'event_date' => now()->addDays(45),
                'image' => $heroImages[0], // Reuse first image
            ],
        ]);
        $events = $dummyEvents;
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
             maxIndex: 0,
             init() {
                 this.updateItemsPerView();
                 this.calculateMaxIndex();
                 window.addEventListener('resize', () => {
                     this.updateItemsPerView();
                     this.calculateMaxIndex();
                 });
                 this.startAutoplay();
                 this.$el.addEventListener('mouseenter', () => { 
                     this.isPaused = true;
                     clearInterval(this.autoplayInterval);
                 });
                 this.$el.addEventListener('mouseleave', () => { 
                     this.isPaused = false;
                     this.startAutoplay();
                 });
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
             calculateMaxIndex() {
                 this.maxIndex = Math.max(0, this.totalItems - this.itemsPerView);
             },
             startAutoplay() {
                 clearInterval(this.autoplayInterval);
                 if (this.totalItems > this.itemsPerView) {
                     this.autoplayInterval = setInterval(() => {
                         if (!this.isPaused) {
                             if (this.currentIndex >= this.maxIndex) {
                                 this.currentIndex = 0;
                             } else {
                                 this.currentIndex++;
                             }
                         }
                     }, 3000);
                 }
             },
             goToSlide(index) {
                 this.currentIndex = index;
                 this.isPaused = true;
                 clearInterval(this.autoplayInterval);
                 setTimeout(() => {
                     this.isPaused = false;
                     this.startAutoplay();
                 }, 5000);
             }
         }"
         ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-16 fade-in">
            <div class="inline-flex items-center justify-center gap-2 mb-4 px-4 py-2 bg-green-50 rounded-full">
                <svg class="w-5 h-5" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span class="text-sm font-semibold" style="color: #008236;">UPCOMING EVENTS</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold mb-4" style="color: #008236;">
                {{ $sectionTitle }}
            </h2>
            @if($eventsSection && $eventsSection->description)
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ $eventsSection->description }}
            </p>
            @else
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Discover exciting campus activities, cultural programs, and memorable moments that make our school community vibrant and engaging.
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
            <div class="overflow-hidden py-4">
                <div 
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'"
                >
                    @foreach($allEvents as $event)
                    <div class="w-full sm:w-1/2 lg:w-1/4 flex-shrink-0 px-3 mb-4">
                        <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col transform hover:-translate-y-2">
                            @if((method_exists($event, 'hasMedia') && $event->hasMedia('images')) || (isset($event->image) && $event->image))
                            <div class="relative h-56 overflow-hidden">
                                @if(isset($event->image) && $event->image)
                                    {{-- Direct image URL (for dummy data) --}}
                                    <img 
                                        src="{{ $event->image }}" 
                                        alt="{{ $event->title }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                        loading="lazy"
                                    >
                                @else
                                    {{-- Media library image --}}
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
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                            loading="lazy"
                                        >
                                    </picture>
                                @endif
                                {{-- Overlay gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            @else
                            <div class="h-56 bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #008236 1px, transparent 1px); background-size: 20px 20px;"></div>
                                <svg class="w-16 h-16 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="p-5 pb-8 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-green-700 transition-colors duration-300 min-h-[3.5rem]">
                                    {{ $event->title }}
                                </h3>
                                <div class="mt-auto pt-4 border-t-2 border-gray-300">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 text-sm text-gray-700">
                                            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-semibold">{{ $event->start_at ? $event->start_at->format('M d, Y') : ($event->event_date ? $event->event_date->format('M d, Y') : 'TBA') }}</span>
                                        </div>
                                        <a href="{{ route('events.show', $event->slug ?? $event->id, false) }}" 
                                           class="inline-flex items-center gap-1 text-sm font-bold text-green-700 hover:text-green-900 group-hover:gap-2 transition-all duration-300 flex-shrink-0">
                                            <span>View</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
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
        
        {{-- Pagination Dots - Active Indicator --}}
        <div class="flex justify-center gap-3 mt-8" role="tablist" aria-label="Event carousel navigation">
            <template x-for="i in (totalItems > itemsPerView ? (maxIndex + 1) : 1)" :key="i">
                <button 
                    @click="goToSlide(i - 1)"
                    class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 hover:scale-110"
                    :style="currentIndex === (i - 1) ? 'background-color: #008236; transform: scale(1.3);' : 'background-color: #d1d5db;'"
                    :aria-selected="currentIndex === (i - 1)"
                    :aria-label="'Go to slide ' + i"
                    role="tab"
                >
                </button>
            </template>
        </div>
        
        {{-- View All Events Button --}}
        @if($buttonText && $buttonLink)
        <div class="text-center mt-12">
            <a href="{{ $buttonLink }}" 
               class="inline-flex items-center justify-center gap-2 text-white font-bold px-10 py-4 rounded-full transition-all duration-300 hover:shadow-2xl hover:scale-105 group"
               style="background: linear-gradient(135deg, #008236 0%, #0a4536 100%);">
                <span>{{ $buttonText }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
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

