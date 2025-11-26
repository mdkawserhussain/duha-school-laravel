{{-- Zaitoon Academy: Explore Our Services (FR-7) --}}
@php
    // Get services from homepage sections (FR-7.3, FR-7.6)
    $homePageSections = $homePageSections ?? collect([]);
    $servicesSection = $homePageSections->get('services');
    $services = [];
    $sectionTitle = 'Explore Our Services';
    
    if ($servicesSection && isset($servicesSection->data)) {
        $services = $servicesSection->data['services'] ?? [];
        $sectionTitle = $servicesSection->title ?? $sectionTitle;
        
        // Check if section is active
        if (!$servicesSection->is_active) {
            return; // Don't render if section is inactive
        }
    }
    
    // Default services if none provided (FR-7.4)
    if (empty($services)) {
        $services = [
            [
                'title' => 'Apply Online',
                'icon' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
                'gradient' => 'from-blue-500 to-blue-600',
                'textColor' => 'text-white',
                'link' => route('admission.index', [], false),
            ],
            [
                'title' => 'Zaitoon WhatsApp Helpline',
                'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                'gradient' => 'from-green-500 to-green-600',
                'textColor' => 'text-white',
                'link' => '#',
            ],
            [
                'title' => 'Higher Education Support Center',
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                'gradient' => 'from-pink-500 via-purple-500 to-purple-600',
                'textColor' => 'text-white',
                'link' => '#',
            ],
            [
                'title' => 'Zaitoon Business Forum (ZBF)',
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'gradient' => 'from-orange-500 to-red-500',
                'textColor' => 'text-white',
                'link' => '#',
            ],
            [
                'title' => 'ZA Bulletin',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'gradient' => 'from-blue-400 to-blue-600',
                'textColor' => 'text-white',
                'link' => '#',
            ],
            [
                'title' => 'Prospectus',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'gradient' => 'from-purple-500 to-purple-600',
                'textColor' => 'text-white',
                'link' => '#',
            ],
            [
                'title' => 'Kishor Zaitoon - 01',
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                'gradient' => 'from-purple-500 via-green-600 to-green-700',
                'textColor' => 'text-white',
                'link' => '#',
            ],
        ];
    }
@endphp

<section class="py-16 lg:py-24 relative overflow-hidden" style="background: linear-gradient(135deg, #e8f5e9 0%, #e3f2fd 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold mb-4" style="color: #0C1B3D;">
                {{ $sectionTitle }}
            </h2>
        </div>
        
        {{-- Services Grid (3-3-1 layout) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 service-grid">
            @foreach($services as $service)
            @php
                // Handle backward compatibility: use gradient if available, otherwise convert bgColor to gradient
                $gradient = $service['gradient'] ?? null;
                if (!$gradient && isset($service['bgColor'])) {
                    // Convert solid colors to gradients
                    $colorMap = [
                        'bg-blue-500' => 'from-blue-500 to-blue-600',
                        'bg-green-500' => 'from-green-500 to-green-600',
                        'bg-purple-500' => 'from-purple-500 to-purple-600',
                        'bg-purple-600' => 'from-purple-500 to-purple-600',
                        'bg-orange-500' => 'from-orange-500 to-orange-600',
                        'bg-pink-500' => 'from-pink-500 to-pink-600',
                    ];
                    $gradient = $colorMap[$service['bgColor']] ?? 'from-gray-500 to-gray-600';
                }
                $gradient = $gradient ?? 'from-gray-500 to-gray-600';
            @endphp
            <a href="{{ $service['link'] }}" 
               class="group service-card bg-gradient-to-r {{ $gradient }} {{ $service['textColor'] ?? 'text-white' }} rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] flex items-center space-x-4"
               aria-label="{{ $service['title'] }}">
                {{-- Icon on left --}}
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                </div>
                {{-- Text on right --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold {{ $service['textColor'] ?? 'text-white' }} leading-tight">
                        {{ $service['title'] }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

