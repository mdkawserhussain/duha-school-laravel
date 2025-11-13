<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->getQuickActions() as $action)
                <a href="{{ $action->url }}" 
                   class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    @if($action->icon)
                        <x-filament::icon
                            :icon="$action->icon"
                            class="h-5 w-5 text-primary-600"
                        />
                    @endif
                    <span class="font-medium text-gray-900">
                        {{ $action->label }}
                    </span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>