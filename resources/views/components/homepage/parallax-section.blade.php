<!-- Parallax Impact Strip - AISD Style -->
<section class="relative bg-fixed bg-center bg-cover min-h-[600px] flex items-center" style="background-image:url('{{ asset('images/parallax-students.svg') }}');">
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-aisd-midnight/90 via-aisd-cobalt/80 to-aisd-midnight/90"></div>
    
    <!-- Decorative Pattern Overlay -->
    <div class="absolute inset-0 opacity-20" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;120&quot; height=&quot;120&quot; viewBox=&quot;0 0 120 120&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.25&quot;><path d=&quot;M60 0l60 60-60 60L0 60z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.5&quot; opacity=&quot;.3&quot;/></g></svg>');"></div>
    
    <div class="container relative z-10 mx-auto px-6 py-32 text-white lg:px-12">
        @php
            $section = $homePageSections['parallax_experience'] ?? null;
            $sectionData = $section && $section->is_active ? $section->data : [];
            $badge = $sectionData['badge'] ?? 'Experience';
            $title = $sectionData['title'] ?? 'Where tradition meets innovation every school day.';
            $description = $sectionData['description'] ?? 'Borrowing AISD\'s parallax rhythm, this slice of campus life highlights collaborative learning pods, Arabic storytelling corners, and maker labs.';
            $featurePills = $sectionData['feature_pills'] ?? [
                ['text' => 'Dedicated Musalla & Hifz Pods'],
                ['text' => 'Robotics & Design Thinking Lab'],
                ['text' => 'Outdoor Play Courts'],
            ];
            $cta = $sectionData['cta'] ?? ['text' => 'Explore Our Campus', 'link' => '#campus'];
        @endphp

        @if($section && $section->is_active)
        <div class="max-w-3xl space-y-6">
            <!-- Section Badge -->
            <p class="text-xs uppercase tracking-[0.5em] text-white/70">{{ $badge }}</p>
            
            <!-- Main Heading -->
            <h2 class="text-4xl font-bold md:text-5xl lg:text-6xl leading-tight">
                {{ $title }}
            </h2>
            
            <!-- Description -->
            <p class="text-lg text-white/90 leading-relaxed">
                {{ $description }}
            </p>
            
            <!-- Feature Pills -->
            @if(count($featurePills) > 0)
            <div class="flex flex-wrap gap-4 text-sm">
                @foreach($featurePills as $pill)
                <span class="rounded-full bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 text-white">
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
        @endif
    </div>
</section>
