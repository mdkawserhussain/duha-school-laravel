@props(['variant' => 'default', 'hover' => true])

@php
    $baseClasses = 'bg-white rounded-2xl overflow-hidden transition-all duration-300';
    
    $variantClasses = [
        'default' => 'shadow-md border border-slate-200/80' . ($hover ? ' hover:shadow-xl hover:-translate-y-1' : ''),
        'elevated' => 'shadow-xl border border-slate-200/80' . ($hover ? ' hover:shadow-2xl hover:-translate-y-2' : ''),
        'premium' => 'shadow-2xl border border-slate-200/50 rounded-3xl' . ($hover ? ' hover:scale-105' : ''),
    ];
    
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

