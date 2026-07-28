@props(['variant' => 'default', 'size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-all duration-300 min-h-[44px] focus:outline-none focus:ring-4 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = [
        'default' => 'bg-white text-slate-800 border-2 border-slate-200 rounded-xl shadow-modern hover:shadow-modern-hover hover:border-slate-300',
        'primary' => 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl shadow-primary hover:shadow-primary-hover hover:from-indigo-700 hover:to-violet-700 focus:ring-indigo-500',
        'secondary' => 'bg-white text-indigo-600 border-2 border-indigo-200 rounded-xl hover:bg-indigo-50 hover:border-indigo-300 focus:ring-indigo-500',
        'outline' => 'bg-transparent text-slate-800 border-2 border-slate-300 rounded-xl hover:bg-slate-50 hover:border-slate-400 focus:ring-slate-500',
        'ghost' => 'bg-transparent text-slate-800 rounded-xl hover:bg-slate-100 focus:ring-slate-500',
    ];
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base sm:px-8 sm:py-4',
        'lg' => 'px-8 py-4 text-lg sm:px-10 sm:py-5',
    ];
    
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['default']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>

