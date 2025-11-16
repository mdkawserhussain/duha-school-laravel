@props([
    'title' => 'Welcome to ' . \App\Helpers\SiteSettingsHelper::websiteName(),
    'description' => 'Providing quality Islamic and Cambridge curriculum education for students from Kindergarten to Grade 12',
    'primaryButton' => ['text' => 'Admission Going On', 'url' => null, 'route' => 'admission.index'],
    'secondaryButton' => ['text' => 'View Events', 'url' => null, 'route' => 'events.index'],
    'backgroundImage' => null,
    'overlay' => true,
    'overlayOpacity' => '40', // 10, 20, 30, 40, 50, 60, 70, 80, 90
    'gradient' => 'from-blue-600 to-blue-800',
    'textAlign' => 'center',
    'height' => 'py-24 lg:py-32',
])

@php
    // Determine primary button URL
    $primaryUrl = $primaryButton['url'] ?? ($primaryButton['route'] ? route($primaryButton['route']) : '#');
    
    // Determine secondary button URL
    $secondaryUrl = $secondaryButton['url'] ?? ($secondaryButton['route'] ? route($secondaryButton['route']) : '#');
    
    // Text alignment classes
    $textAlignClasses = [
        'center' => 'text-center',
        'left' => 'text-left',
        'right' => 'text-right',
    ];
    $alignClass = $textAlignClasses[$textAlign] ?? 'text-center';
    
    // Button alignment classes
    $buttonAlignClasses = [
        'center' => 'justify-center',
        'left' => 'justify-start',
        'right' => 'justify-end',
    ];
    $buttonAlignClass = $buttonAlignClasses[$textAlign] ?? 'justify-center';
@endphp

<section class="relative {{ $backgroundImage ? '' : 'bg-gradient-to-r ' . $gradient }} text-white overflow-hidden">
    @if($backgroundImage)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $backgroundImage }}');"></div>
    @endif
    
    @if($overlay)
        @php
            $opacityClasses = [
                '10' => 'bg-opacity-10',
                '20' => 'bg-opacity-20',
                '30' => 'bg-opacity-30',
                '40' => 'bg-opacity-40',
                '50' => 'bg-opacity-50',
                '60' => 'bg-opacity-60',
                '70' => 'bg-opacity-70',
                '80' => 'bg-opacity-80',
                '90' => 'bg-opacity-90',
            ];
            $opacityClass = $opacityClasses[$overlayOpacity] ?? 'bg-opacity-40';
        @endphp
        <div class="absolute inset-0 bg-black {{ $opacityClass }}"></div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ $height }}">
        <div class="{{ $alignClass }}">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                {{ $title }}
            </h1>
            
            @if($description)
            <p class="text-xl md:text-2xl mb-8 max-w-3xl {{ $textAlign === 'center' ? 'mx-auto' : '' }} opacity-95">
                {{ $description }}
            </p>
            @endif
            
            @if($primaryButton['text'] || $secondaryButton['text'])
            <div class="flex flex-col sm:flex-row gap-4 {{ $buttonAlignClass }}">
                @if($primaryButton['text'])
                <a 
                    href="{{ $primaryUrl }}" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                >
                    {{ $primaryButton['text'] }}
                </a>
                @endif
                
                @if($secondaryButton['text'])
                <a 
                    href="{{ $secondaryUrl }}" 
                    class="bg-white bg-opacity-20 hover:bg-opacity-30 border-2 border-white text-white font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    {{ $secondaryButton['text'] }}
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

