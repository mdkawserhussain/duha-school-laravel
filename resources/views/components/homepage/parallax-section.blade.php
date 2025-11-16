<!-- Parallax Impact Strip - AISD Style -->
@php
    // Get the section data
    $section = $homePageSections['parallax_experience'] ?? null;
    $sectionData = $section && $section->is_active ? $section->data : [];
    
    // Get background image from CMS or use default
    $backgroundImage = null;
    
    // Handle use_default_image - can be boolean false, string 'false', or null
    $useDefaultImageRaw = $sectionData['use_default_image'] ?? false;
    $useDefaultImage = filter_var($useDefaultImageRaw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    if ($useDefaultImage === null) {
        $useDefaultImage = false; // Default to false if not set
    }
    
    // Priority: 1. Media collection 'background_image', 2. Data array, 3. Default
    // Only skip if explicitly set to use default image
    if (!$useDefaultImage && $section) {
        // Ensure media relationship is loaded
        if (!$section->relationLoaded('media')) {
            $section->load('media');
        }
        
        // Try to get from dedicated background_image media collection (preferred)
        // Use WebP conversion with fallback
        try {
            if ($section->hasMedia('background_image')) {
                $backgroundImage = $section->getWebPMediaUrl('background_image', 'large');
            }
        } catch (\Exception $e) {
            \Log::error('Parallax section: Failed to get background_image media', [
                'section_id' => $section->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
        
        // If still no image, try data array
        if (!$backgroundImage && isset($sectionData['background_image'])) {
            $bgData = $sectionData['background_image'];
            
            if (filter_var($bgData, FILTER_VALIDATE_URL)) {
                $backgroundImage = $bgData;
            } elseif (is_string($bgData) && !empty($bgData)) {
                if (str_starts_with($bgData, 'storage/') || str_starts_with($bgData, '/storage/')) {
                    $backgroundImage = asset($bgData);
                } else {
                    $backgroundImage = asset('storage/' . ltrim($bgData, '/'));
                }
            }
        }
        
        // Fallback to images collection
        if (!$backgroundImage && $section->hasMedia('images')) {
            try {
                $backgroundImage = $section->getWebPMediaUrl('images', 'large');
            } catch (\Exception $e) {
                // Silently continue
            }
        }
    }
    
    // Use default image if no custom image is set OR if use_default_image is true
    if (!$backgroundImage || $useDefaultImage) {
        $backgroundImage = asset('images/parallax-students.svg');
    }
    
    // Ensure we have a valid URL (asset() already returns full URL, but check anyway)
    if ($backgroundImage && !filter_var($backgroundImage, FILTER_VALIDATE_URL) && !str_starts_with($backgroundImage, '/')) {
        // If it's a relative path without leading slash, add it
        if (str_starts_with($backgroundImage, 'storage/')) {
            $backgroundImage = asset($backgroundImage);
        } else {
            $backgroundImage = url($backgroundImage);
        }
    }
    
    // Extract content data
    // Note: title can be in either $section->title (column) or $sectionData['title'] (data array)
    $badge = $sectionData['badge'] ?? 'Experience';
    $title = $sectionData['title'] ?? $section->title ?? 'Where tradition meets innovation every school day.';
    $description = $sectionData['description'] ?? $section->description ?? 'Borrowing Duha\'s parallax rhythm, this slice of campus life highlights collaborative learning pods, Arabic storytelling corners, and maker labs.';
    $featurePills = $sectionData['feature_pills'] ?? [
        ['text' => 'Dedicated Musalla & Hifz Pods'],
        ['text' => 'Robotics & Design Thinking Lab'],
        ['text' => 'Outdoor Play Courts'],
    ];
    $cta = $sectionData['cta'] ?? ['text' => 'Explore Our Campus', 'link' => '#campus'];
@endphp

<section 
    class="parallax-section relative min-h-[600px] flex items-center justify-center overflow-hidden"
    style="background-image: url('{{ e($backgroundImage) }}'); background-color: #1e3a8a; background-size: cover; background-position: center center; background-repeat: no-repeat; background-attachment: fixed;"
>
    <!-- Dark Overlay - Ensures white text is always visible regardless of background image -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/60 to-black/70 z-10"></div>
    
    <!-- Color Gradient Overlay - Adds brand colors while maintaining text visibility -->
    <div class="absolute inset-0 bg-gradient-to-r from-aisd-midnight/40 via-aisd-cobalt/30 to-aisd-midnight/40" style="z-index: 11;"></div>

    <!-- Decorative Pattern Overlay -->
    <div class="absolute inset-0 opacity-15 z-20" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;120&quot; height=&quot;120&quot; viewBox=&quot;0 0 120 120&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.25&quot;><path d=&quot;M60 0l60 60-60 60L0 60z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.5&quot; opacity=&quot;.3&quot;/></g></svg>');"></div>

    <!-- Content -->
    @if($section && $section->is_active)
    <div class="container relative z-30 mx-auto px-6 py-32 text-white lg:px-12">
        <div class="max-w-3xl space-y-6">
            <!-- Section Badge -->
            <p class="text-xs uppercase tracking-[0.5em] text-white font-semibold drop-shadow-lg">{{ $badge }}</p>

            <!-- Main Heading -->
            <h2 class="text-4xl font-bold md:text-5xl lg:text-6xl leading-tight text-white drop-shadow-lg">
                {{ $title }}
            </h2>

            <!-- Description -->
            <p class="text-lg text-white leading-relaxed drop-shadow-md">
                {{ $description }}
            </p>

            <!-- Feature Pills -->
            @if(count($featurePills) > 0)
            <div class="flex flex-wrap gap-4 text-sm">
                @foreach($featurePills as $pill)
                <span class="rounded-full bg-white/20 backdrop-blur-sm border border-white/30 px-4 py-2 text-white font-medium drop-shadow-md">
                    {{ $pill['text'] ?? '' }}
                </span>
                @endforeach
            </div>
            @endif

            <!-- CTA Button -->
            @if(isset($cta['text']) && isset($cta['link']))
            <div class="pt-4">
                <a href="{{ $cta['link'] }}" class="inline-flex items-center rounded-xl bg-aisd-gold px-8 py-4 text-base font-semibold text-aisd-midnight transition-all hover:bg-aisd-gold/90 hover:shadow-lg hover:shadow-aisd-gold/50">
                    {{ $cta['text'] }}
                    <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
</section>
