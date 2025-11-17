<div
    x-data
    role="radiogroup"
    aria-label="Theme switcher"
    class="fi-theme-switcher"
>
    <x-filament-panels::theme-switcher.button
        :icon="\Filament\Support\Icons\Heroicon::Sun"
        theme="light"
    />

    <x-filament-panels::theme-switcher.button
        :icon="\Filament\Support\Icons\Heroicon::Moon"
        theme="dark"
    />

    <x-filament-panels::theme-switcher.button
        :icon="\Filament\Support\Icons\Heroicon::ComputerDesktop"
        theme="system"
    />
</div>
