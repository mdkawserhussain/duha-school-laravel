{{-- Zaitoon Academy: Recent Notices & Chairman's Message (Two Columns) --}}
@php
    // Get settings from HomePageSection
    $noticesChairmanSection = $homePageSections['notices_chairman'] ?? null;
    $sectionData = $noticesChairmanSection?->data ?? [];
    
    // Get settings with defaults
    $showNotices = filter_var($sectionData['show_notices'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $noticesCount = (int) ($sectionData['notices_count'] ?? 5);
    $showChairman = filter_var($sectionData['show_chairman'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $chairmanExcerptLimit = (int) ($sectionData['chairman_excerpt_limit'] ?? 150);
    
    // Get recent notices
    $recentNotices = $recentNotices ?? collect([]);
    $importantNotices = $importantNotices ?? collect([]);
    $notices = $recentNotices;
    if ($notices->isEmpty() && $importantNotices->isNotEmpty()) {
        $notices = $importantNotices;
    }
    $notices = $notices->take($noticesCount);
    
    // Get Chairman's message from staff or page
    $featuredStaff = $featuredStaff ?? collect([]);
    $chairman = null;
    if ($featuredStaff->isNotEmpty()) {
        $chairman = $featuredStaff->firstWhere('position', 'like', '%Chairman%') 
                 ?? $featuredStaff->firstWhere('position', 'like', '%Principal%')
                 ?? $featuredStaff->first();
    }
    
    $chairmanMessage = $chairman?->bio ?? 'Zaitoon Academy is committed to providing excellence in both Islamic and modern education. Our curriculum is designed to nurture well-rounded individuals who excel academically while maintaining strong Islamic values.';
    $chairmanName = $chairman?->name ?? 'Chairman';
    // Get chairman image with WebP support (FR-6.3.2) - FIXED: Using proper method with asset()
    $chairmanImage = null;
    $chairmanMedia = null;
    if ($chairman && $chairman->hasMedia('photo')) {
        $chairmanMedia = $chairman->getFirstMedia('photo');
        $chairmanImage = $chairman->getMediaUrl('photo', 'webp') ?: $chairman->getMediaUrl('photo', 'medium');
    }
@endphp

@if($showNotices || $showChairman)
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 {{ ($showNotices && $showChairman) ? 'lg:grid-cols-2' : '' }} gap-8 lg:gap-12">
            {{-- Left Column: Recent Notices --}}
            @if($showNotices)
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-za-green-primary">Recent Notices</h2>
                </div>
                
                <div class="space-y-4 mb-6">
                    @forelse($notices as $notice)
                    <div class="border-l-4 border-za-green-primary pl-4 py-2 hover:bg-gray-50 transition-colors rounded-r">
                        <a href="{{ route('notices.show', $notice->slug ?? $notice->id, false) }}" class="block">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 hover:text-za-green-primary transition-colors">
                                {{ $notice->title ?? 'Notice Title' }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $notice->published_at ? $notice->published_at->format('d M Y') : 'Date' }}
                            </p>
                        </a>
                    </div>
                    @empty
                    <div class="text-gray-500 text-center py-8">
                        <p>No notices available at the moment.</p>
                    </div>
                    @endforelse
                </div>
                
                <a href="{{ route('notices.index', [], false) }}" 
                   class="inline-flex items-center justify-center w-full sm:w-auto bg-za-green-primary hover:bg-za-green-dark text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 hover:scale-105">
                    View All Notices
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @endif
            
            {{-- Right Column: Chairman's Message --}}
            @if($showChairman)
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-lg">
                <div class="flex items-start gap-6 mb-6">
                    @if($chairmanImage && $chairmanMedia)
                    <div class="flex-shrink-0">
                        <picture>
                            @if($chairmanMedia->hasGeneratedConversion('webp'))
                                <source srcset="{{ $chairman->getMediaUrl('photo', 'webp') }}" type="image/webp">
                            @endif
                            <img 
                                src="{{ $chairmanImage }}" 
                                alt="{{ $chairmanName }}"
                                class="w-24 h-24 rounded-full object-cover border-4 border-za-green-light"
                                loading="lazy"
                            >
                        </picture>
                    </div>
                    @else
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-za-green-light border-4 border-za-green-light flex items-center justify-center">
                        <span class="text-za-green-primary text-2xl font-bold">{{ substr($chairmanName, 0, 1) }}</span>
                    </div>
                    @endif
                    <div class="flex-1">
                        <h2 class="text-2xl sm:text-3xl font-bold text-za-green-primary mb-2">Chairman's Message</h2>
                        <p class="text-gray-600 font-medium">{{ $chairmanName }}</p>
                    </div>
                </div>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ \Illuminate\Support\Str::limit($chairmanMessage, $chairmanExcerptLimit) }}
                </p>
                
                <a href="{{ route('about.show', ['page' => 'about']) }}" 
                   class="inline-flex items-center justify-center bg-za-green-primary hover:bg-za-green-dark text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 hover:scale-105">
                    Read More
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

