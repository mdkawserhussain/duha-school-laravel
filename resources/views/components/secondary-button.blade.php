@props(['size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold text-indigo-600 bg-white border-2 border-indigo-200 transition-all duration-300 min-h-[44px] rounded-xl hover:bg-indigo-50 hover:border-indigo-300 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base sm:px-8 sm:py-4',
        'lg' => 'px-8 py-4 text-lg sm:px-10 sm:py-5',
    ];
    
    $classes = $baseClasses . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>
