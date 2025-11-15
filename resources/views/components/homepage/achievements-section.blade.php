<!-- Achievements Card Deck - AISD Style with Glassmorphism -->
<section class="relative py-24 overflow-hidden" style="background-color: #0F224C;">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;160&quot; height=&quot;160&quot; viewBox=&quot;0 0 160 160&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.16&quot;><path d=&quot;M0 0h160v160H0z&quot;/><path d=&quot;M80 40l40 80H40z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.6&quot; opacity=&quot;.3&quot;/></g></svg>');"></div>
    
    <div class="container relative z-10 mx-auto px-6 lg:px-12">
        @php
            $section = $homePageSections['achievements'] ?? null;
            $sectionData = $section && $section->is_active ? $section->data : [];
            $title = $section?->title ?? 'Recognising Our Learners';
            $subtitle = $section?->data['subtitle'] ?? $section?->subtitle ?? 'Highlights';
            $description = $section?->description ?? 'From Qur\'an recitation championships to Cambridge distinctions, our students lead locally and globally.';
            $defaultAchievements = [
                [
                    'title' => "Cambridge Top Achievers",
                    'copy' => 'Multiple "Top in Bangladesh" awards in Mathematics & English.',
                    'badge' => 'IGCSE',
                    'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                ],
                [
                    'title' => 'International Quran Recital',
                    'copy' => 'Gold medal at the 2024 Kuala Lumpur Tilawah.',
                    'badge' => 'Hifz',
                    'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'
                ],
                [
                    'title' => 'STEM Innovation Fair',
                    'copy' => 'Solar desalination project crowned champion at city science fair.',
                    'badge' => 'STEM',
                    'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
                ],
                [
                    'title' => 'Model OIC Summit',
                    'copy' => 'Best Delegate recognition for our secondary students.',
                    'badge' => 'Leadership',
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                ],
            ];
            
            // Use achievements from section data, or default if not available
            $achievements = $sectionData['achievements'] ?? $defaultAchievements;
        @endphp

        @if($section && $section->is_active && count($achievements) > 0)
        <div class="mb-14 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.5em]" style="color: #7F8DB2;">{{ $subtitle }}</p>
            <h2 class="mt-4 text-3xl font-bold text-white md:text-4xl">{{ $title }}</h2>
            <p class="mt-3 text-white max-w-3xl mx-auto opacity-90">{{ $description }}</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($achievements as $achievement)
                <div class="group relative rounded-3xl border border-white/20 p-8 backdrop-blur-xl shadow-card transition-all hover:-translate-y-1 hover:shadow-soft" style="background-color: rgba(255, 255, 255, 0.08);">
                    <!-- Icon -->
                    <div class="mb-4 inline-flex rounded-2xl p-3" style="background-color: rgba(244, 196, 48, 0.2); color: #F4C430;">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $achievement['icon'] }}" />
                        </svg>
                    </div>
                    
                    <!-- Badge -->
                    <span class="inline-flex items-center rounded-full px-4 py-1 text-xs font-semibold uppercase tracking-wide" style="background-color: rgba(244, 196, 48, 0.2); border: 1px solid rgba(244, 196, 48, 0.3); color: #F4C430;">{{ $achievement['badge'] }}</span>
                    
                    <!-- Content -->
                    <h3 class="mt-4 text-2xl font-semibold text-white">{{ $achievement['title'] }}</h3>
                    <p class="mt-3 text-white leading-relaxed opacity-90">{{ $achievement['copy'] }}</p>
                    
                    <!-- Learn More Link -->
                    @if(!empty($achievement['link']))
                    <a href="{{ $achievement['link'] }}" class="mt-6 flex items-center text-sm font-semibold transition-colors" style="color: #6EC1F5;">
                        Learn More
                        <svg class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @endif
                </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
