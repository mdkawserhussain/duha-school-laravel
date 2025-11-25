{{-- Zaitoon Academy: Partners (FR-12) --}}
@php
    // Get partners from homepage sections (FR-12.4)
    $homePageSections = $homePageSections ?? collect([]);
    $partnerSection = $homePageSections->get('partners') ?? $homePageSections->get('our_partners');
    
    // Check if section is active
    if ($partnerSection && !$partnerSection->is_active) {
        return; // Don't render if section is inactive
    }
    
    $partners = [];
    if ($partnerSection && isset($partnerSection->data)) {
        $partners = $partnerSection->data['partners'] ?? [];
    }
    
    // Get section title and description from database
    $sectionTitle = $partnerSection?->title ?? 'Our Partners';
    $sectionDescription = $partnerSection?->description ?? 'We are proud to be associated with leading organizations worldwide.';
    
    // Default partners if none provided (FR-12.4.4)
    if (empty($partners)) {
        $partners = [
            ['name' => 'VISION', 'logo' => null, 'website' => null],
            ['name' => 'ILANNOOR', 'logo' => null, 'website' => null],
            ['name' => 'PARTNER 3', 'logo' => null, 'website' => null],
            ['name' => 'SADAQAH TV', 'logo' => null, 'website' => null],
            ['name' => 'SADAQAH', 'logo' => null, 'website' => null],
            ['name' => 'PARTNER 6', 'logo' => null, 'website' => null],
        ];
    }
@endphp

<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-12.1) --}}
        <div class="text-center mb-16 fade-in">
            <h2 class="text-3xl sm:text-4xl font-serif font-bold mb-3" style="color: #008236;">
                🤝 {{ $sectionTitle }}
            </h2>
            <p class="text-base text-gray-600 max-w-2xl mx-auto">
                {{ $sectionDescription }}
            </p>
        </div>
        
        {{-- Partners Grid (FR-12.2, FR-12.3) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 lg:gap-12 items-center">
            @foreach($partners as $partner)
            @php
                $hasWebsite = isset($partner['website']) && !empty($partner['website']);
                $partnerUrl = $hasWebsite ? $partner['website'] : '#';
            @endphp
            @if($hasWebsite)
            <a href="{{ $partnerUrl }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="flex items-center justify-center p-4 transition-all duration-300 hover:scale-110 grayscale hover:grayscale-0"
               aria-label="Visit {{ $partner['name'] ?? 'Partner' }} website">
            @else
            <div class="flex items-center justify-center p-4 transition-all duration-300 hover:scale-110">
            @endif
                @if(isset($partner['logo']) && $partner['logo'])
                <picture>
                    <source srcset="{{ $partner['logo'] }}" type="image/webp">
                    <img 
                        src="{{ $partner['logo'] }}" 
                        alt="{{ $partner['name'] ?? 'Partner' }}"
                        class="max-w-full h-16 object-contain opacity-60 hover:opacity-100 transition-opacity duration-300"
                        loading="lazy"
                    >
                </picture>
                @else
                <div class="w-full h-16 bg-white rounded-lg flex items-center justify-center px-3 border border-gray-200">
                    <span class="text-xs font-bold text-gray-400 text-center leading-tight">
                        {{ $partner['name'] ?? 'Partner' }}
                    </span>
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
</section>

