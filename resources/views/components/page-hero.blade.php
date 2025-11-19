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

<section class="page-hero relative w-full flex items-center justify-center overflow-hidden bg-aisd-midnight" 
         style="position: relative; top: 0; left: 0; margin: 0 !important; padding: 0 !important; min-height: 60vh; height: 60vh; width: 100vw; max-width: 100vw; overflow-x: hidden;">
    
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full overflow-hidden" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100%; margin: 0 !important; padding: 0 !important;">
        <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
             style="background-image: url('{{ e($backgroundImage) }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
        </div>
    </div>

    @if($overlay)
    <!-- Dark gradient overlay for text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-aisd-midnight/85 via-aisd-ocean/80 to-aisd-cobalt/85" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; z-index: 5;"></div>

    <!-- Decorative pattern overlay -->
    <div class="absolute inset-0 opacity-15" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;120&quot; height=&quot;120&quot; viewBox=&quot;0 0 120 120&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.25&quot;><path d=&quot;M60 0l60 60-60 60L0 60z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.5&quot; opacity=&quot;.3&quot;/></g></svg>'); z-index: 6; pointer-events: none;"></div>

    <!-- 5% White overlay -->
    <div class="absolute inset-0 bg-white/5 z-[7]" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; background-color: rgba(255, 255, 255, 0.05); z-index: 7; pointer-events: none;"></div>
    @endif

    <!-- Content Container -->
    <div class="relative z-10 w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16 md:pb-20"
         style="margin: 0; padding-top: 0 !important; padding-left: 1rem; padding-right: 1rem; padding-bottom: 3rem; pointer-events: auto;">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Badge -->
            @if($badge)
            <div class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/5 px-5 py-2 text-[0.65rem] uppercase tracking-[0.3em] text-white mb-6 sm:mb-8" style="background-color: rgba(255, 255, 255, 0.05);">
                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-white">{{ $badge }}</span>
            </div>
            @endif

            <!-- Main Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight tracking-tight text-white mb-4 sm:mb-6" style="font-family: 'Playfair Display', serif;">
                {{ $title }}
            </h1>

            <!-- Subtitle -->
            @if($subtitle)
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white max-w-3xl mx-auto leading-relaxed" style="color: rgba(255, 255, 255, 0.95);">
                {{ $subtitle }}
            </p>
            @endif
        </div>
    </div>
</section>

