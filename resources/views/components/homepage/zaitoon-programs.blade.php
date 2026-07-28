{{-- Zaitoon Academy: Academic Programs (FR-9) --}}
@php
    // Programs configuration (Mock Data for now)
    $programs = [
        [
            'title' => 'Playgroup',
            'age' => '3-4 Years',
            'description' => 'A fun and interactive learning environment for our youngest learners.',
            'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'bg-za-green-primary',
        ],
        [
            'title' => 'Nursery',
            'age' => '4-5 Years',
            'description' => 'Building foundational skills in literacy, numeracy, and Islamic values.',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'color' => 'bg-za-yellow-accent',
            'textColor' => 'text-za-green-dark',
        ],
        [
            'title' => 'KG',
            'age' => '5-6 Years',
            'description' => 'Preparing students for primary education with a balanced curriculum.',
            'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'color' => 'bg-za-green-primary',
        ],
        [
            'title' => 'Hifzul Quran',
            'age' => 'Any Age',
            'description' => 'Dedicated program for memorizing the Holy Quran with Tajweed.',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'color' => 'bg-za-green-dark',
        ],
        [
            'title' => 'Class 1-5',
            'age' => '6+ Years',
            'description' => 'Primary education following Cambridge curriculum integrated with Islamic studies.',
            'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
            'color' => 'bg-za-green-primary',
        ],
    ];
@endphp

<section class="py-16 lg:py-24 relative overflow-hidden" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold mb-4" style="color: #008236;">
                Our Academic Programs
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto">
                Comprehensive educational pathways designed to nurture intellectual growth and spiritual development.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 program-grid">
            @foreach($programs as $program)
            <div class="group program-card bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200">
                <div class="p-8">
                    <div class="w-16 h-16 {{ $program['color'] }} rounded-xl flex items-center justify-center mb-6 shadow-md">
                        <svg class="w-8 h-8 {{ isset($program['textColor']) ? $program['textColor'] : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $program['icon'] }}" />
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        {{ $program['title'] }}
                    </h3>
                    <div class="text-sm text-gray-500 mb-4">
                        {{ $program['age'] }}
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $program['description'] }}
                    </p>
                    
                    <a href="#" class="inline-flex items-center font-semibold transition-colors" style="color: #008236;">
                        Learn More
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('admission.index') }}" 
               class="inline-flex items-center justify-center font-bold px-8 py-4 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg"
               style="background-color: #fbbf24; color: #008236;">
                Apply for Admission
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
