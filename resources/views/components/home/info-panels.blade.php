@props([
    'panels' => [],
])

@if(!empty($panels))
    <section class="container page-section">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($panels as $panel)
                <article class="card group h-full">
                    <div class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-100">
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

                    <h3 class="text-xl font-semibold text-ink-900">
                        {{ $panel['title'] }}
                    </h3>

                    @if(!empty($panel['description']))
                        <p class="mt-3 text-sm leading-relaxed text-ink-500">
                            {{ $panel['description'] }}
                        </p>
                    @endif

                    @if(!empty($panel['button']))
                        <div class="mt-6">
                            <a href="{{ $panel['button']['url'] }}" class="link-underline text-sm">
                                {{ $panel['button']['label'] }}
                            </a>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
@endif
