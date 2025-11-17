<x-filament-widgets::widget>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($this->getQuickActions() as $action)
            <a
                href="{{ $action->getUrl() }}"
                @class([
                    'group relative flex w-full items-center gap-x-2 rounded-lg border p-4 text-left transition duration-75 focus-visible:ring-2 focus-visible:ring-offset-2',
                    // Neutral / gray
                    'border-gray-200 bg-gray-50 hover:bg-gray-100 dark:border-white/10 dark:bg-gray-900 dark:hover:bg-gray-800' => $action->getColor() === 'gray',
                    // Success
                    'border-success-300 bg-success-50 hover:bg-success-100 dark:border-success-700 dark:bg-success-900 dark:hover:bg-success-800' => $action->getColor() === 'success',
                    // Primary
                    'border-primary-300 bg-primary-50 hover:bg-primary-100 dark:border-primary-700 dark:bg-primary-900 dark:hover:bg-primary-800' => $action->getColor() === 'primary',
                    // Info
                    'border-info-300 bg-info-50 hover:bg-info-100 dark:border-info-700 dark:bg-info-900 dark:hover:bg-info-800' => $action->getColor() === 'info',
                    // Warning
                    'border-warning-300 bg-warning-50 hover:bg-warning-100 dark:border-warning-700 dark:bg-warning-900 dark:hover:bg-warning-800' => $action->getColor() === 'warning',
                    // Danger
                    'border-danger-300 bg-danger-50 hover:bg-danger-100 dark:border-danger-700 dark:bg-danger-900 dark:hover:bg-danger-800' => $action->getColor() === 'danger',
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