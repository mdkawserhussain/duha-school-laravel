<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->getQuickLinks() as $link)
                @php
                    $colorClasses = [
                        'green' => 'bg-green-50 hover:bg-green-100 border-green-200 text-green-600 text-green-700',
                        'blue' => 'bg-blue-50 hover:bg-blue-100 border-blue-200 text-blue-600 text-blue-700',
                        'orange' => 'bg-orange-50 hover:bg-orange-100 border-orange-200 text-orange-600 text-orange-700',
                        'purple' => 'bg-purple-50 hover:bg-purple-100 border-purple-200 text-purple-600 text-purple-700',
                        'red' => 'bg-red-50 hover:bg-red-100 border-red-200 text-red-600 text-red-700',
                        'gray' => 'bg-gray-50 hover:bg-gray-100 border-gray-200 text-gray-600 text-gray-700',
                    ];
                    $colors = explode(' ', $colorClasses[$link['color']]);
                @endphp
                <a href="{{ $link['url'] }}" class="p-4 {{ $colors[0] }} {{ $colors[1] }} border {{ $colors[2] }} transition-colors rounded-lg">
                    <div class="flex flex-col items-center text-center">
                        <x-filament::icon
                            :icon="$link['icon']"
                            class="w-4 h-4 {{ $colors[3] }} mb-2"
                        />
                        <span class="text-sm font-medium {{ $colors[4] }}">{{ $link['label'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
