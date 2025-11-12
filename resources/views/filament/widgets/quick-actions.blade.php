<x-filament-widgets::widget>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($this->getQuickActions() as $action)
            <a
                href="{{ $action->getUrl() }}"
                @class([
                    'group relative flex w-full items-center gap-x-2 rounded-lg border p-4 text-left transition duration-75 hover:bg-gray-50 focus-visible:ring-2 focus-visible:ring-offset-2 dark:hover:bg-white/5',
                    'border-gray-200 dark:border-white/10' => $action->getColor() === 'gray',
                    'border-success-300 dark:border-success-700' => $action->getColor() === 'success',
                    'border-primary-300 dark:border-primary-700' => $action->getColor() === 'primary',
                    'border-info-300 dark:border-info-700' => $action->getColor() === 'info',
                    'border-warning-300 dark:border-warning-700' => $action->getColor() === 'warning',
                    'border-danger-300 dark:border-danger-700' => $action->getColor() === 'danger',
                ])
            >
                @if($action->getIcon())
                    <x-filament::icon
                        :icon="$action->getIcon()"
                        @class([
                            'h-6 w-6 shrink-0',
                            'text-gray-500 dark:text-gray-400' => $action->getColor() === 'gray',
                            'text-success-600 dark:text-success-400' => $action->getColor() === 'success',
                            'text-primary-600 dark:text-primary-400' => $action->getColor() === 'primary',
                            'text-info-600 dark:text-info-400' => $action->getColor() === 'info',
                            'text-warning-600 dark:text-warning-400' => $action->getColor() === 'warning',
                            'text-danger-600 dark:text-danger-400' => $action->getColor() === 'danger',
                        ])
                    />
                @endif

                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-950 dark:text-white">
                        {{ $action->getLabel() }}
                    </div>
                </div>

                @if($action->getBadge())
                    <x-filament::badge
                        :color="$action->getColor()"
                        class="shrink-0"
                    >
                        {{ $action->getBadge() }}
                    </x-filament::badge>
                @endif
            </a>
        @endforeach
    </div>
</x-filament-widgets::widget>