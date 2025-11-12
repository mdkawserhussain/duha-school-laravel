@props(['class' => ''])

@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
        'bn' => ['name' => 'বাংলা', 'flag' => '🇧🇩'],
    ];
@endphp

<div class="relative group {{ $class }}" x-data="{ open: false }">
    <button 
        @click="open = !open"
        class="flex items-center gap-2 px-3 py-2 text-blue-900 hover:text-white hover:bg-blue-600 rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        aria-label="Change language"
        aria-expanded="false"
    >
        <span class="text-lg">{{ $locales[$currentLocale]['flag'] ?? '🌐' }}</span>
        <span class="hidden sm:inline">{{ $locales[$currentLocale]['name'] ?? strtoupper($currentLocale) }}</span>
        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
        style="display: none;"
    >
        <div class="py-1">
            @foreach($locales as $code => $locale)
                <a 
                    href="{{ route('language.switch', $code) }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ $currentLocale === $code ? 'bg-blue-50 text-blue-700 font-medium' : '' }}"
                >
                    <span class="text-xl">{{ $locale['flag'] }}</span>
                    <span>{{ $locale['name'] }}</span>
                    @if($currentLocale === $code)
                        <svg class="h-4 w-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>

