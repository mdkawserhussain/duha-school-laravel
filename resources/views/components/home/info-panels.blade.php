@props([
    'panels' => [],
])

@if(!empty($panels))
    <section class="section-modern bg-gradient-to-br from-slate-50 to-indigo-50/20 scroll-fade-in" aria-labelledby="features-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($panels as $index => $panel)
                    <article class="modern-card-elevated group h-full stagger-item" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                        <div class="mb-6 inline-flex h-14 w-14 md:h-16 md:w-16 items-center justify-center rounded-2xl gradient-indigo-violet text-white transition-all duration-300 group-hover:scale-110 icon-bounce shadow-lg">
                            @switch($panel['icon'] ?? null)
                                @case('calendar')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3m-9 4h10m-12 9h14a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v13a1 1 0 001 1z" />
                                    </svg>
                                    @break
                                @case('megaphone')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l10-5v14l-10-5Zm10-5v4.618a2 2 0 001.106 1.789l4.788 2.394a1 1 0 001.106-1.79l-4.788-2.393A2 2 0 0113 8.618V5zM7 15a3 3 0 106 0" />
                                    </svg>
                                    @break
                                @default
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                                    </svg>
                            @endswitch
                        </div>

                        <h3 class="text-xl md:text-2xl font-bold text-slate-900 mb-3">
                            {{ $panel['title'] }}
                        </h3>

                        @if(!empty($panel['description']))
                            <p class="mt-3 text-base leading-relaxed text-slate-600" style="letter-spacing: 0.01em; line-height: 1.7;">
                                {{ $panel['description'] }}
                            </p>
                        @endif

                        @if(!empty($panel['button']))
                            <div class="mt-6">
                                <a href="{{ $panel['button']['url'] }}" class="underline-draw text-indigo-600 font-semibold text-sm md:text-base">
                                    {{ $panel['button']['label'] }} →
                                </a>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
