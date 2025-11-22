{{-- Zaitoon Academy: Partners (FR-12) --}}
@php
    // Get partners from homepage sections (FR-12.4)
    $homePageSections = $homePageSections ?? collect([]);
    $partnerSection = $homePageSections->get('partners') ?? $homePageSections->get('our_partners');
    $partners = [];
    if ($partnerSection && isset($partnerSection->data)) {
        $partners = $partnerSection->data['partners'] ?? [];
    }
    
    // Default partners if none provided (FR-12.4.4)
    if (empty($partners)) {
        $partners = [
            ['name' => 'SADAGAH', 'logo' => null, 'website' => null],
            ['name' => 'ILANNOOR INSTITUTE', 'logo' => null, 'website' => null],
            ['name' => 'VISION', 'logo' => null, 'website' => null],
            ['name' => 'Partner 4', 'logo' => null, 'website' => null],
            ['name' => 'Partner 5', 'logo' => null, 'website' => null],
        ];
    }
@endphp

<section class="py-16 lg:py-24 bg-white"
         x-data="{ isPaused: false }"
         @mouseenter="isPaused = true"
         @mouseleave="isPaused = false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-12.1) --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-za-green-primary rounded-full mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-za-green-primary mb-4">
                Our Partners
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto">
                We are proud to be associated with leading organizations worldwide.
            </p>
        </div>
        
        {{-- Partners Carousel (FR-12.2, FR-12.3) --}}
        <div class="overflow-hidden">
            <div 
                class="flex gap-6 lg:gap-8 animate-scroll"
                :style="isPaused ? 'animation-play-state: paused;' : 'animation-play-state: running;'"
            >
                {{-- Duplicate partners for seamless loop --}}
                @foreach(array_merge($partners, $partners) as $index => $partner)
                @php
                    $hasWebsite = isset($partner['website']) && !empty($partner['website']);
                    $partnerUrl = $hasWebsite ? $partner['website'] : '#';
                @endphp
                @if($hasWebsite)
                <a href="{{ $partnerUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="flex-shrink-0 bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center min-h-[120px] w-48 border-2 border-gray-100 hover:border-za-green-primary"
                   aria-label="Visit {{ $partner['name'] ?? 'Partner' }} website">
                @else
                <div class="flex-shrink-0 bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center min-h-[120px] w-48 border-2 border-gray-100 hover:border-za-green-primary">
                @endif
                    @if(isset($partner['logo']) && $partner['logo'])
                    <picture>
                        <source srcset="{{ $partner['logo'] }}" type="image/webp">
                        <img 
                            src="{{ $partner['logo'] }}" 
                            alt="{{ $partner['name'] ?? 'Partner' }}"
                            class="max-w-full max-h-16 object-contain"
                            loading="lazy"
                        >
                    </picture>
                    @else
                    <div class="text-center w-full">
                        <div class="w-16 h-16 bg-za-green-light rounded-lg flex items-center justify-center mx-auto mb-2">
                            <span class="text-za-green-primary text-2xl font-bold">
                                {{ substr($partner['name'] ?? 'P', 0, 1) }}
                            </span>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">{{ $partner['name'] ?? 'Partner' }}</p>
                    </div>
                    @endif
                @if($hasWebsite)
                </a>
                @else
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    .animate-scroll {
        animation: scroll 30s linear infinite;
        display: flex;
    }
    
    .animate-scroll:hover {
        animation-play-state: paused;
    }
</style>
@endpush

