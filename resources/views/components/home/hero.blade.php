@props([
    'badge' => null,
    'heading' => 'Inspire Lifelong Learning',
    'description' => 'A carefully balanced Cambridge and Islamic curriculum delivered by passionate educators across modern campuses.',
    'primaryAction' => null,
    'secondaryAction' => null,
    'stats' => [],
    'background' => null,
])

<section class="container page-section pt-12 lg:pt-20">
    <div class="hero-panel px-6 py-12 md:px-12 md:py-16 lg:px-16 lg:py-20">
        <div class="blurred-spot" aria-hidden="true"></div>

        <div class="relative grid gap-12 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-8">
                @if($badge)
                    <span class="badge-soft bg-white/20 text-xs font-semibold uppercase tracking-[0.3em] text-white">{{ $badge }}</span>
                @endif

                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-white">
                        {!! \Illuminate\Support\Str::of($heading)->replace('\n', '<br>') !!}
                    </h1>
                    <p class="max-w-2xl text-base md:text-lg text-white/80">
                        {{ $description }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-4">
                    @if($primaryAction)
                        <a href="{{ $primaryAction['url'] ?? '#' }}" class="btn-primary bg-white text-brand-700 hover:text-brand-800">
                            {{ $primaryAction['label'] ?? 'Learn More' }}
                        </a>
                    @endif

                    @if($secondaryAction)
                        <a href="{{ $secondaryAction['url'] ?? '#' }}" class="btn-secondary bg-transparent border-white/50 text-white hover:bg-white/10">
                            {{ $secondaryAction['label'] ?? 'Discover More' }}
                        </a>
                    @endif
                </div>

                @if(!empty($stats))
                    <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($stats as $stat)
                            <div class="stat-pill bg-white/10 text-white">
                                <dt class="text-sm uppercase tracking-wide text-white/70">{{ $stat['label'] ?? '' }}</dt>
                                <dd class="text-2xl font-semibold">{{ $stat['value'] ?? '' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif
            </div>

            <div class="relative">
                <div class="absolute -left-8 -top-8 h-24 w-24 rounded-3xl bg-accent-400/70 blur-2xl opacity-60" aria-hidden="true"></div>
                <div class="absolute -bottom-10 right-6 h-28 w-28 rounded-full bg-white/20 blur-3xl opacity-70" aria-hidden="true"></div>

                <div class="relative overflow-hidden rounded-[2rem] bg-white/5 shadow-[0_35px_60px_-30px_rgba(8,19,54,0.45)] backdrop-blur">
                    @if($background)
                        <img
                            src="{{ $background }}"
                            alt="Campus life preview"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        >
                    @else
                        <div class="aspect-[4/5] bg-gradient-to-br from-white/20 via-brand-300/30 to-brand-600/40"></div>
                    @endif

                    <div class="absolute inset-x-6 bottom-6 flex flex-col gap-2 rounded-2xl bg-white/85 p-6 text-brand-900 shadow-card">
                        <span class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-500">Cambridge & Islamic Excellence</span>
                        <span class="text-lg font-semibold leading-tight">Holistic development with STEAM labs, Hifz program and global citizenship</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
