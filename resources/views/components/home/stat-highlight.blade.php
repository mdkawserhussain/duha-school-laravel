@props([
    'items' => [],
])

@if(!empty($items))
    <section class="container">
        <div class="card-muted">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($items as $item)
                    <div class="space-y-2">
                        <p class="text-lg font-semibold text-brand-700">{{ $item['value'] ?? '' }}</p>
                        <p class="text-sm leading-relaxed text-ink-500">{{ $item['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
