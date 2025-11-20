<!-- Stats Section -->
<section class="relative overflow-hidden py-20 bg-aisd-ink-50">
    <div class="absolute inset-0" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;200&quot; height=&quot;200&quot; viewBox=&quot;0 0 200 200&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.12&quot;><circle stroke=&quot;%230C1B3D&quot; stroke-width=&quot;0.4&quot; cx=&quot;100&quot; cy=&quot;100&quot; r=&quot;96&quot;/><circle stroke=&quot;%236EC1F5&quot; stroke-width=&quot;0.4&quot; cx=&quot;100&quot; cy=&quot;100&quot; r=&quot;70&quot;/></g></svg>');"></div>
    <div class="container relative z-10 mx-auto px-6 lg:px-12">
        @php
            $section = $homePageSections['stats_main'] ?? null;
            $sectionData = $section && $section->is_active ? $section->data : [];
            $subtitle = $sectionData['subtitle'] ?? 'Impact';
            $title = $section?->title ?? 'Our School in Numbers';
            $description = $section?->description ?? 'A snapshot of growth across our Cambridge and Islamic streams.';
            $stats = $sectionData['stats'] ?? [
                ['label' => 'Students', 'value' => '1200+', 'copy' => 'Across Early Years to A-Level', 'icon' => 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z'],
                ['label' => 'Teachers', 'value' => '85', 'copy' => 'Certified international faculty', 'icon' => 'M5 13l4 4L19 7'],
                ['label' => 'Years', 'value' => '15+', 'copy' => 'Established excellence', 'icon' => 'M9 12l2 2 4-4'],
                ['label' => 'Success Rate', 'value' => '98%', 'copy' => 'IGCSE & A-Level results', 'icon' => 'M5 13l4 4L19 7'],
            ];
            $cta = $sectionData['cta'] ?? [
                'title' => 'Join a community grounded in faith and excellence.',
                'button1' => ['text' => 'Schedule a Visit', 'link' => '#visit'],
                'button2' => ['text' => 'Talk to Admissions', 'link' => '#contact'],
            ];
        @endphp

        @if($section && $section->is_active && count($stats) > 0)
        <div class="mb-10 sm:mb-14 text-center px-4">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-[0.4em] text-aisd-ink-500">{{ $subtitle }}</p>
            <h2 class="mt-3 sm:mt-4 text-2xl sm:text-3xl font-bold md:text-4xl text-aisd-ocean">{{ $title }}</h2>
            <p class="mt-3 sm:mt-4 text-base sm:text-lg max-w-2xl mx-auto px-4 text-aisd-ink-700">{{ $description }}</p>
        </div>

        <div class="grid gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="group rounded-3xl border bg-white p-4 sm:p-6 md:p-8 shadow-card transition hover:-translate-y-1 border-slate-200">
                    <div class="mb-4 sm:mb-6 inline-flex rounded-2xl p-2.5 sm:p-3 bg-aisd-ocean/10 text-aisd-ocean">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24" height="24">
                            <path d="{{ $stat['icon'] }}" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-aisd-ocean">{{ $stat['value'] }}</div>
                    <div class="mt-2 text-xs sm:text-sm font-semibold uppercase tracking-widest text-aisd-ink-500">{{ $stat['label'] }}</div>
                    <p class="mt-3 sm:mt-4 text-sm sm:text-base text-aisd-ink-700">{{ $stat['copy'] }}</p>
                </div>
            @endforeach
        </div>

        @if(isset($cta['title']) && $cta['title'])
        <div class="mt-10 sm:mt-16 grid gap-4 sm:gap-6 rounded-3xl p-6 sm:p-8 md:p-10 text-white md:grid-cols-2 bg-aisd-ocean">
            <div>
                <p class="text-xs sm:text-sm uppercase tracking-[0.4em] text-white/90">Admissions</p>
                <h3 class="mt-2 sm:mt-3 text-xl sm:text-2xl md:text-3xl font-bold text-white">{{ $cta['title'] }}</h3>
            </div>
            <div class="flex flex-col gap-3 sm:gap-4 md:flex-row md:items-center md:justify-end">
                @if(isset($cta['button1']['text']) && isset($cta['button1']['link']))
                <a href="{{ $cta['button1']['link'] }}" class="rounded-xl border px-5 sm:px-6 py-3 text-center font-semibold text-white transition-all hover:bg-white/10 min-h-[44px] flex items-center justify-center border-white/30">{{ $cta['button1']['text'] }}</a>
                @endif
                @if(isset($cta['button2']['text']) && isset($cta['button2']['link']))
                <a href="{{ $cta['button2']['link'] }}" class="btn-aisd-gold">{{ $cta['button2']['text'] }}</a>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</section>