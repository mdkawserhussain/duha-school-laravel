{{-- Zaitoon Academy: Explore Our Services (FR-7) --}}
@php
    // Services configuration (FR-7.3, FR-7.6)
    $services = [
        [
            'title' => 'Apply Online',
            'icon' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
            'bgColor' => 'bg-orange-500', // Orange background
            'textColor' => 'text-white',
            'link' => route('admission.index', [], false),
        ],
        [
            'title' => 'Zaitoon WhatsApp Helpline',
            'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
            'bgColor' => 'bg-blue-500', // Blue background
            'textColor' => 'text-white',
            'link' => '#',
        ],
        [
            'title' => 'Higher Education Support Center',
            'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
            'bgColor' => 'bg-purple-600', // Purple background
            'textColor' => 'text-white',
            'link' => '#',
        ],
        [
            'title' => 'Zaitoon Business Forum (ZBF)',
            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            'bgColor' => 'bg-orange-500', // Orange background
            'textColor' => 'text-white',
            'link' => '#',
        ],
        [
            'title' => 'ZA Bulletin',
            'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'bgColor' => 'bg-blue-500', // Blue background
            'textColor' => 'text-white',
            'link' => '#',
        ],
        [
            'title' => 'Prospectus',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'bgColor' => 'bg-pink-500', // Pink background
            'textColor' => 'text-white',
            'link' => '#',
        ],
    ];
@endphp

<section class="py-16 lg:py-24 relative overflow-hidden" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
    {{-- Light Green Gradient at Top (FR-7.5) --}}
    <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-za-green-50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold mb-4" style="color: #008236;">
                Explore Our Services
            </h2>
        </div>
        
        {{-- Services Grid (FR-7.2) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 service-grid">
            @foreach($services as $service)
            <a href="{{ $service['link'] }}" 
               class="group service-card {{ $service['bgColor'] }} {{ $service['textColor'] }} rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform"
               aria-label="{{ $service['title'] }}">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold {{ $service['textColor'] }}">
                        {{ $service['title'] }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

