<!-- Page Hero Section - Matches Homepage Quality -->
@props([
    'title' => '',
    'subtitle' => '',
    'badge' => null,
    'heroImage' => null,
    'fallbackImage' => 'images/page-hero-default.jpg',
    'overlay' => true,
])

@php
    // Get hero image from page model or use fallback
    $backgroundImage = $heroImage;
    
    // If no hero image provided, use fallback
    if (!$backgroundImage) {
        $backgroundImage = asset($fallbackImage);
    }
    
    // Ensure we have a valid URL
    if ($backgroundImage && !filter_var($backgroundImage, FILTER_VALIDATE_URL) && !str_starts_with($backgroundImage, '/')) {
        if (str_starts_with($backgroundImage, 'storage/')) {
            $backgroundImage = asset($backgroundImage);
        } else {
            $backgroundImage = asset('storage/' . ltrim($backgroundImage, '/'));
        }
    }
    
    // Get primary color for overlay
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    if (!str_starts_with($primaryColor, '#')) {
        $primaryColor = '#' . ltrim($primaryColor, '#');
    }
@endphp

<section class="page-hero relative w-full flex items-center justify-center overflow-hidden bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9]" 
         style="position: relative; top: 0; left: 0; margin: 0 !important; padding: 0 !important; min-height: 60vh; height: 60vh; width: 100vw; max-width: 100vw; overflow-x: hidden;">
    
    <!-- Background Image (optional, only if provided) -->
    @if($backgroundImage && $backgroundImage !== asset('images/page-hero-default.jpg'))
    <div class="absolute inset-0 w-full h-full overflow-hidden" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100%; margin: 0 !important; padding: 0 !important;">
        <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
             style="background-image: url('{{ e($backgroundImage) }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
        </div>
        @if($overlay)
        <!-- Light overlay for text readability when image is present -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#E8F5E9]/80 via-white/70 to-[#E8F5E9]/80" 
             style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; z-index: 5;"></div>
        @endif
    </div>
    @endif

    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
    <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#008236]/5 to-transparent rounded-tr-full"></div>

    <!-- Content Container -->
    <div class="relative z-10 w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16 md:pb-20"
         style="margin: 0; padding-top: 0 !important; padding-left: 1rem; padding-right: 1rem; padding-bottom: 3rem; pointer-events: auto;">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Badge -->
            @if($badge)
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" 
                 class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-6 text-xs font-semibold uppercase tracking-wider bg-white/80 border border-[#008236]/20 text-[#008236] backdrop-blur-sm opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                <span class="w-2 h-2 rounded-full bg-[#008236]"></span>
                {{ $badge }}
            </div>
            @endif

            <!-- Main Title -->
            <h1 x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-[#008236] mb-4 sm:mb-6 opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                :class="{ 'opacity-100 translate-y-0': show }"
                style="font-family: 'Playfair Display', serif;">
                {{ $title }}
            </h1>

            <!-- Subtitle -->
            @if($subtitle)
            <p x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
               class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
               :class="{ 'opacity-100 translate-y-0': show }">
                {{ $subtitle }}
            </p>
            @endif
        </div>
    </div>
</section>

