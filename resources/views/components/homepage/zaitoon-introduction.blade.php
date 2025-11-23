{{-- Zaitoon Academy Introduction Section: Islamic Scholars --}}
@php
    $homePageSections = $homePageSections ?? collect([]);
    $introSection = $homePageSections->get('introduction') ?? $homePageSections->get('about_intro');
    $title = $introSection?->title ?? 'To create a group of specialized Islamic scholars.';
    $description = $introSection?->description ?? 'Zaitoon Academy was established with the vision of providing quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.';
    $buttonText = $introSection?->button_text ?? 'Read More';
    // Link to /about-us/about per PRD FR-5.3.6
    $buttonLink = $introSection?->button_link ?? route('about.show', ['page' => 'about'], false);
    
    // Get images from section or use defaults (FR-5.2.7)
    $image1 = null;
    $image2 = null;
    if ($introSection && $introSection->hasMedia('images')) {
        // Get WebP URLs if available (FR-5.2.4) - FIXED: Using proper method with asset()
        $image1 = $introSection->getMediaUrl('images', 'webp') ?: $introSection->getMediaUrl('images', 'large');
        $secondMedia = $introSection->getMedia('images')->skip(1)->first();
        if ($secondMedia) {
            $image2 = $introSection->getMediaUrl('images', 'webp') ?: $introSection->getMediaUrl('images', 'large');
        }
    }
@endphp

<section class="py-16 lg:py-24" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 50%, #ffffff 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Left Side: Images --}}
            <div class="space-y-6 slide-left">
                @if($image1)
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <picture>
                        @php
                            $firstMedia = $introSection && $introSection->hasMedia('images') 
                                ? $introSection->getMedia('images')->first() 
                                : null;
                        @endphp
                        @if($firstMedia && $firstMedia->hasGeneratedConversion('webp'))
                            <source srcset="{{ $introSection->getMediaUrl('images', 'webp') }}" type="image/webp">
                        @endif
                        <img 
                            src="{{ $image1 }}" 
                            alt="Zaitoon Academy Building"
                            class="w-full h-auto object-cover"
                            loading="lazy"
                        >
                    </picture>
                </div>
                @else
                <div class="rounded-xl overflow-hidden shadow-lg bg-za-green-light h-64 flex items-center justify-center">
                    <span class="text-za-green-primary">Building Image</span>
                </div>
                @endif
                
                @if($image2)
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <picture>
                        @php
                            $secondMedia = $introSection && $introSection->hasMedia('images') 
                                ? $introSection->getMedia('images')->skip(1)->first() 
                                : null;
                        @endphp
                        @if($secondMedia && $secondMedia->hasGeneratedConversion('webp'))
                            <source srcset="{{ $introSection->getMediaUrl('images', 'webp') }}" type="image/webp">
                        @endif
                        <img 
                            src="{{ $image2 }}" 
                            alt="Zaitoon Academy Activities"
                            class="w-full h-auto object-cover"
                            loading="lazy"
                        >
                    </picture>
                </div>
                @else
                <div class="rounded-xl overflow-hidden shadow-lg bg-za-green-light h-48 flex items-center justify-center">
                    <span class="text-za-green-primary">Activity Image</span>
                </div>
                @endif
            </div>
            
            {{-- Right Side: Text Content --}}
            <div class="space-y-6 slide-right">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold leading-tight" style="color: #0d5a47;">
                    {{ $title }}
                </h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p class="text-base sm:text-lg">
                        {{ $description }}
                    </p>
                    @if($introSection && $introSection->content)
                    <p class="text-base sm:text-lg">
                        {{ \Illuminate\Support\Str::limit(strip_tags($introSection->content), 200) }}
                    </p>
                    @endif
                </div>
                <a href="{{ $buttonLink }}" 
                   class="inline-flex items-center justify-center text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 hover:shadow-lg"
                   style="background-color: #0d5a47;"
                   onmouseover="this.style.backgroundColor='#0a4536'"
                   onmouseout="this.style.backgroundColor='#0d5a47'">
                    {{ $buttonText }}
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>