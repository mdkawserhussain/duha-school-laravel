<!-- Hero Section - AISD Style with Background Video -->
@php
    // Get announcements for dynamic padding calculation
    $announcements = collect([]);
    try {
        if (!app()->bound('exception') &&
            !str_contains(request()->path() ?? '', 'errors') &&
            !str_contains(request()->path() ?? '', '_dusk') &&
            !str_contains(request()->path() ?? '', 'telescope')) {
            $announcements = \App\Helpers\AnnouncementHelper::getSafe();
        }
    } catch (\Throwable $e) {
        $announcements = collect([]);
    }

    $heroSlide = $heroSlides->first();
    $heroData = $heroSlide && $heroSlide->is_active ? ($heroSlide->data ?? []) : [];
    $badge = $heroData['badge'] ?? 'Since 2010 • Chattogram';
    $title = $heroSlide?->title ?? 'Nurturing Excellence in Islamic Education';
    $subtitle = $heroSlide?->subtitle ?? '';
    $headline = trim(($title . ' ' . $subtitle)) ?: 'Nurturing Excellence in Islamic Education';
    $description = $heroSlide?->description ?? 'A Cambridge and Islamic integrated curriculum inspiring young minds to lead with knowledge, character, and compassion.';
    $primaryButtonText = $heroSlide?->button_text ?? 'Apply Now';
    $primaryButtonLink = $heroSlide?->button_link ?? '#admissions';
    $secondaryButtonText = $heroData['secondary_button_text'] ?? 'Virtual Tour';
    $secondaryButtonLink = $heroData['secondary_button_link'] ?? '#virtual-tour';
    $videoUrl = $heroData['video_url'] ?? 'https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4';
    $videoPoster = $heroSlide && $heroSlide->hasMedia('video_poster')
        ? $heroSlide->getMediaUrl('video_poster', 'large')
        : asset('images/hero-poster.jpg');
    $features = $heroData['features'] ?? [
        [
            'icon' => 'M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z',
            'title' => 'Cambridge & Hifz Streams',
            'description' => 'Balanced academics with authentic Islamic scholarship.'
        ],
        [
            'icon' => 'M4 3a2 2 0 100 4h12a2 2 0 100-4H4z M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z',
            'title' => 'Modern Islamic Campus',
            'description' => 'Secure, tech-enabled classrooms and labs.'
        ]
    ];
    $statsCards = $heroData['stats_cards'] ?? [
        [
            'label1' => 'Lower Campus',
            'label2' => 'Morning Shift',
            'title' => 'Early Years • Primary',
            'description' => 'Cambridge Primary with Qur\'an & Arabic immersion.'
        ],
        [
            'label1' => 'Upper Campus',
            'label2' => 'Day Shift',
            'title' => 'IGCSE & A-Level',
            'description' => 'STEM, Business & Islamic leadership enrichment.'
        ]
    ];
    $statsPills = $heroData['stats_pills'] ?? [
        ['value' => '1200+', 'label' => 'Students'],
        ['value' => '85', 'label' => 'Educators'],
        ['value' => '15+', 'label' => 'Years']
    ];
@endphp

@if($heroSlide && $heroSlide->is_active)
<section class="hero-section relative w-full flex items-center overflow-hidden bg-aisd-midnight" 
         style="position: relative; top: 0; left: 0; margin: 0 !important; padding: 0 !important; min-height: 100vh; height: 100vh; width: 100vw; max-width: 100vw; overflow-x: hidden;">
    <!-- Background Video Container - Handle both direct video URLs and YouTube URLs -->
    <div class="absolute inset-0 w-full h-full overflow-hidden" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; margin: 0; padding: 0;">
        @php
            // Check if it's a YouTube URL
            $isYouTube = preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $videoUrl, $matches);
            $youtubeId = $isYouTube && isset($matches[1]) ? $matches[1] : null;
        @endphp

        @if($youtubeId)
            <!-- YouTube Video Embed -->
            <iframe
                id="hero-bg-video"
                class="absolute inset-0 w-full h-full object-cover"
                style="position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover; border: none; margin: 0; padding: 0;"
                src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1"
                allow="autoplay; encrypted-media; fullscreen; picture-in-picture"
                allowfullscreen
                frameborder="0"
                loading="eager">
            </iframe>
        @else
            <!-- Direct Video File -->
            <video
                id="hero-bg-video"
                class="absolute inset-0 w-full h-full object-cover"
                style="position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover; margin: 0; padding: 0;"
                autoplay
                muted
                loop
                playsinline
                preload="auto"
                loading="eager"
                poster="{{ $videoPoster }}">
                @if($videoUrl)
                <source src="{{ $videoUrl }}" type="video/mp4">
                @endif
                Your browser does not support the video tag.
            </video>
        @endif
    </div>

    <!-- Dark overlay for text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-aisd-midnight/85 via-aisd-ocean/80 to-aisd-cobalt/85" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0;"></div>

    <!-- Decorative pattern overlay -->
    <div class="absolute inset-0 opacity-15" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;120&quot; height=&quot;120&quot; viewBox=&quot;0 0 120 120&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.25&quot;><path d=&quot;M60 0l60 60-60 60L0 60z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.5&quot; opacity=&quot;.3&quot;/></g></svg>');"></div>

    <!-- 5% White overlay for entire hero section -->
    <div class="absolute inset-0 bg-white/5 z-[5]" 
         style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; background-color: rgba(255, 255, 255, 0.05); z-index: 5;"></div>

    <!-- Content Container - Positioned to account for navbar overlay without creating gaps -->
    <div class="relative z-10 w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16 md:pb-20 lg:pb-24"
         style="margin: 0; padding-top: 0 !important; padding-left: 1rem; padding-right: 1rem; padding-bottom: 3rem;">
        <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-16 items-center">
            <!-- Text content - Left side -->
            <div class="text-white space-y-8">
                <!-- School crest badge -->
                @if($badge)
                <div class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/5 px-5 py-2 text-[0.65rem] uppercase tracking-[0.3em] text-white" style="background-color: rgba(255, 255, 255, 0.05);">
                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-white">{{ $badge }}</span>
                </div>
                @endif

                <!-- Main headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl xl:text-6xl font-bold leading-tight tracking-tight text-white">
                    {{ $headline }}
                </h1>

                <!-- Subtext -->
                <p class="text-base sm:text-lg text-white max-w-2xl leading-relaxed mt-4 sm:mt-6">
                    {{ $description }}
                </p>

                <!-- Dual CTAs -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                    @if($primaryButtonText && $primaryButtonLink)
                    <a href="{{ $primaryButtonLink }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white/30 px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base font-semibold text-white transition-all hover:border-white/50" style="background-color: rgba(255, 255, 255, 0.05);">
                        {{ $primaryButtonText }}
                        <svg class="ml-2 sm:ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @endif
                    @if($secondaryButtonText && $secondaryButtonLink)
                    <a href="{{ $secondaryButtonLink }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white/30 px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base font-semibold text-white transition-all hover:border-white/50" style="background-color: rgba(255, 255, 255, 0.05);">
                        {{ $secondaryButtonText }}
                        <svg class="ml-2 sm:ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </a>
                    @endif
                </div>

                <!-- Feature highlights -->
                @if(count($features) > 0)
                <div class="grid gap-6 text-sm sm:grid-cols-2">
                    @foreach($features as $feature)
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl p-2" style="background-color: rgba(255, 255, 255, 0.05);">
                            <svg class="h-5 w-5 text-white sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 20 20" width="20" height="20">
                                <path d="{{ $feature['icon'] ?? '' }}" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-white">{{ $feature['title'] ?? '' }}</h4>
                            <p class="text-white text-sm">{{ $feature['description'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Highlight stats cards - Right side (desktop) -->
            <div class="grid gap-6">
                @if(count($statsCards) > 0)
                    @foreach($statsCards as $card)
                    <div class="rounded-3xl border border-white/30 p-6 shadow-2xl" style="background-color: rgba(255, 255, 255, 0.05); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);">
                        <div class="flex items-center justify-between text-sm text-white">
                            <span>{{ $card['label1'] ?? '' }}</span>
                            <span>{{ $card['label2'] ?? '' }}</span>
                        </div>
                        <h3 class="mt-4 text-3xl font-bold text-white">{{ $card['title'] ?? '' }}</h3>
                        <p class="mt-3 text-white">{{ $card['description'] ?? '' }}</p>
                    </div>
                    @endforeach
                @endif
                @if(count($statsPills) > 0)
                <!-- Stats pills -->
                <div class="grid grid-cols-3 gap-4 text-center text-white">
                    @foreach($statsPills as $pill)
                    <div class="rounded-2xl p-4 border border-white/30" style="background-color: rgba(255, 255, 255, 0.05); box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.3);">
                        <div class="text-3xl font-bold text-white">{{ $pill['value'] ?? '' }}</div>
                        <div class="text-xs uppercase tracking-wide text-white mt-1">{{ $pill['label'] ?? '' }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scroll cue -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white z-10">
        <div class="flex flex-col items-center gap-2 text-xs tracking-[0.4em] uppercase">
            <span class="opacity-70">Scroll</span>
            <div class="h-12 w-8 rounded-full border border-white/40 flex items-start justify-center p-1">
                <span class="h-3 w-1 rounded-full bg-white animate-bounce"></span>
            </div>
        </div>
    </div>
</section>

<!-- Ensure video plays on load -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var video = document.getElementById('hero-bg-video');
        if (video) {
            // Check if it's an iframe (YouTube embed)
            if (video.tagName === 'IFRAME') {
                // YouTube embeds handle autoplay automatically with the URL parameters
            } else {
                // HTML5 video element
                video.muted = true;
                video.play().catch(function(error) {
                    // Silently handle autoplay prevention
                });
            }
        }
    });
</script>
@endif
