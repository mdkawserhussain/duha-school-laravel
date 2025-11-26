{{-- Zaitoon Academy: Recent News (FR-10) --}}
@php
    // Get settings from HomePageSection
    $homePageSections = $homePageSections ?? collect([]);
    $newsSection = $homePageSections->get('news');
    $sectionData = $newsSection?->data ?? [];
    
    // Get settings with defaults
    $titleOverride = $sectionData['title_override'] ?? null;
    $itemsCount = (int) ($sectionData['items_count'] ?? 12);
    $layoutStyle = $sectionData['layout_style'] ?? 'carousel';
    $buttonText = $newsSection?->button_text ?? 'View All News';
    $buttonLink = $newsSection?->button_link ?? route('notices.index', [], false);
    $sectionTitle = $titleOverride ?? $newsSection?->title ?? 'Recent News';
    
    // Check if section is active
    if ($newsSection && !$newsSection->is_active) {
        return; // Don't render if section is inactive
    }
    
    // Get recent news/notices (FR-10.4)
    $recentNotices = $recentNotices ?? collect([]);
    $importantNotices = $importantNotices ?? collect([]);
    $news = $recentNotices;
    if ($news->isEmpty() && $importantNotices->isNotEmpty()) {
        $news = $importantNotices;
    }
    
    // FORCE DUMMY DATA FOR TESTING - Add dummy news with hero images
    if (true) { // Change to: if ($news->isEmpty()) { when done testing
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
        
        $dummyNews = collect([
            (object)[
                'id' => 1,
                'title' => 'New Academic Year Begins',
                'slug' => 'new-academic-year-begins',
                'content' => 'We are excited to announce the beginning of a new academic year with enhanced facilities and programs.',
                'published_at' => now()->subDays(2),
                'image' => $heroImages[0],
            ],
            (object)[
                'id' => 2,
                'title' => 'Excellence in Education Award',
                'slug' => 'excellence-in-education-award',
                'content' => 'Our school has been recognized for outstanding achievement in providing quality education.',
                'published_at' => now()->subDays(5),
                'image' => $heroImages[1],
            ],
            (object)[
                'id' => 3,
                'title' => 'Student Achievement Highlights',
                'slug' => 'student-achievement-highlights',
                'content' => 'Celebrating our students remarkable achievements in academics and extracurricular activities.',
                'published_at' => now()->subDays(7),
                'image' => $heroImages[2],
            ],
            (object)[
                'id' => 4,
                'title' => 'New Library Facilities Opened',
                'slug' => 'new-library-facilities-opened',
                'content' => 'State-of-the-art library facilities now available for all students with extensive resources.',
                'published_at' => now()->subDays(10),
                'image' => $heroImages[3],
            ],
            (object)[
                'id' => 5,
                'title' => 'Community Service Initiative',
                'slug' => 'community-service-initiative',
                'content' => 'Students participate in meaningful community service projects making a positive impact.',
                'published_at' => now()->subDays(12),
                'image' => $heroImages[4],
            ],
            (object)[
                'id' => 6,
                'title' => 'Technology Integration Program',
                'slug' => 'technology-integration-program',
                'content' => 'Introducing advanced technology in classrooms to enhance learning experiences.',
                'published_at' => now()->subDays(15),
                'image' => $heroImages[5],
            ],
        ]);
        $news = $dummyNews;
    }
    
    // Get news items for carousel based on database setting
    $allNews = $news->take($itemsCount);
    $totalNews = $allNews->count();
@endphp

<section class="py-16 lg:py-24 bg-gray-50"
         x-data="{
             currentIndex: 0,
             totalItems: {{ $totalNews }},
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
                 if (window.innerWidth >= 1280) {
                     this.itemsPerView = 4;
                 } else if (window.innerWidth >= 1024) {
                     this.itemsPerView = 3;
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
        {{-- Section Header (FR-10.1) --}}
        <div class="text-center mb-16 fade-in">
            <div class="inline-flex items-center justify-center gap-2 mb-4 px-4 py-2 bg-green-50 rounded-full">
                <svg class="w-5 h-5" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                    <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                </svg>
                <span class="text-sm font-semibold" style="color: #008236;">LATEST NEWS</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold mb-4" style="color: #008236;">
                {{ $sectionTitle }}
            </h2>
            @if($newsSection && $newsSection->description)
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ $newsSection->description }}
            </p>
            @else
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Stay informed with the latest announcements, updates, and important news from our school community.
            </p>
            @endif
        </div>
        
        @if($allNews->isNotEmpty())
        {{-- Carousel Container (FR-10.2) --}}
        <div class="relative">
            {{-- Previous Arrow (FR-10.3) --}}
            <button 
                @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : (totalItems - itemsPerView)"
                x-show="totalItems > itemsPerView"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                aria-label="Previous news"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            {{-- News Carousel (FR-10.2) --}}
            <div class="overflow-hidden py-4">
                <div 
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'"
                >
                    @foreach($allNews as $item)
                    <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 shrink-0 px-3 mb-4">
                        <a href="{{ route('notices.show', $item->slug ?? $item->id, false) }}" 
                           class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 block h-full flex flex-col transform hover:-translate-y-2">
                            @if((method_exists($item, 'hasMedia') && $item->hasMedia('images')) || (isset($item->image) && $item->image))
                            <div class="relative h-56 overflow-hidden">
                                @if(isset($item->image) && $item->image)
                                    {{-- Direct image URL (for dummy data) --}}
                                    <img 
                                        src="{{ $item->image }}" 
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                        loading="lazy"
                                    >
                                @else
                                    {{-- Media library image --}}
                                    @php
                                        $webpUrl = $item->getMediaUrl('images', 'webp');
                                        $imageUrl = $item->getMediaUrl('images', 'medium');
                                    @endphp
                                    <picture>
                                        @if($webpUrl)
                                            <source srcset="{{ $item->getMediaUrl('images', 'webp') }}" type="image/webp">
                                        @endif
                                        <img 
                                            src="{{ $imageUrl }}" 
                                            alt="{{ $item->title }}"
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
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                    <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="p-5 pb-8 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-700 transition-colors duration-300 min-h-[3.5rem]">
                                    {{ $item->title }}
                                </h3>
                                @if($item->content)
                                <p class="text-sm text-gray-600 line-clamp-2 mb-4 flex-grow">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                                </p>
                                @endif
                                <div class="mt-auto pt-4 border-t-2 border-gray-300">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 text-sm text-gray-700">
                                            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-semibold">{{ $item->published_at ? $item->published_at->format('M d, Y') : 'Date' }}</span>
                                        </div>
                                        <span class="inline-flex items-center gap-1 text-sm font-bold text-green-700 hover:text-green-900 group-hover:gap-2 transition-all duration-300 flex-shrink-0">
                                            <span>View</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Next Arrow (FR-10.3) --}}
            <button 
                @click="currentIndex = currentIndex < (totalItems - itemsPerView) ? currentIndex + 1 : 0"
                x-show="totalItems > itemsPerView"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                aria-label="Next news"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        
        {{-- Pagination Dots - Active Indicator --}}
        <div class="flex justify-center gap-3 mt-8" role="tablist" aria-label="News carousel navigation">
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
        
        {{-- View All News Button (FR-10.5) --}}
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
            <p class="text-gray-500">No news available at the moment.</p>
        </div>
        @endif
    </div>
</section>

