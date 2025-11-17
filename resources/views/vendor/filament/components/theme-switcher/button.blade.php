@props([
    'icon',
    'theme',
])

@php
    $label = __("filament-panels::layout.actions.theme_switcher.{$theme}.label");
@endphp

<button
    aria-label="{{ $label }}"
    type="button"
    x-on:click="$dispatch('theme-changed', @js($theme));(typeof close !== 'undefined' ? close() : null)"
    x-tooltip="{
        content: @js($label),
        theme: $store.theme,
    }"
    x-bind:class="{ 'fi-active': $store.theme === @js($theme) }"
    role="radio"
    x-bind:aria-checked="$store.theme === @js($theme) ? 'true' : 'false'"
    class="fi-theme-switcher-btn"
>
    {{
        \Filament\Support\generate_icon_html($icon, alias: match ($theme) {
            'light' => \Filament\View\PanelsIconAlias::THEME_SWITCHER_LIGHT_BUTTON,
            'dark' => \Filament\View\PanelsIconAlias::THEME_SWITCHER_DARK_BUTTON,
            'system' => \Filament\View\PanelsIconAlias::THEME_SWITCHER_SYSTEM_BUTTON,
        })
    }}
</button>
