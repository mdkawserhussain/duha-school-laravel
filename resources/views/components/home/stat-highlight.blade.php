@props([
    'items' => [],
])

@if(!empty($items))
    <section class="section-modern bg-white scroll-fade-in" aria-labelledby="stats-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="modern-card-premium p-8 md:p-12">
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach($items as $index => $item)
                        <div class="space-y-2 text-center stagger-item" style="transition-delay: {{ $index * 100 }}ms">
                            <p class="text-3xl md:text-4xl font-bold text-gradient">{{ $item['value'] ?? '' }}</p>
                            <p class="text-sm md:text-base leading-relaxed text-slate-600 font-medium" style="letter-spacing: 0.02em;">{{ $item['label'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
