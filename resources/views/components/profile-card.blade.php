@props([
    'name' => '',
    'title' => '',
    'image' => null,
    'bio' => '',
    'email' => null,
    'phone' => null,
    'linkedin' => null,
    'layout' => 'horizontal' // horizontal or vertical
])

<div class="profile-card {{ $layout === 'vertical' ? 'flex flex-col items-center text-center' : 'flex flex-col md:flex-row gap-6 md:gap-8' }} bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 md:p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
    {{-- Profile Image --}}
    <div class="{{ $layout === 'vertical' ? 'mb-6' : 'flex-shrink-0' }}">
        <div class="relative">
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden ring-4 ring-aisd-gold/20 shadow-lg">
                @if($image)
                    <img 
                        src="{{ $image }}" 
                        alt="{{ $name }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                @else
                    <div class="w-full h-full bg-gradient-to-br from-aisd-ocean to-aisd-cobalt flex items-center justify-center">
                        <span class="text-4xl md:text-5xl font-bold text-white">
                            {{ substr($name, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>
            {{-- Decorative Element --}}
            <div class="absolute -bottom-2 -right-2 w-16 h-16 bg-aisd-gold/20 rounded-full blur-xl"></div>
        </div>
    </div>

    {{-- Profile Info --}}
    <div class="flex-1 {{ $layout === 'vertical' ? 'w-full' : '' }}">
        {{-- Name & Title --}}
        <div class="mb-4">
            <h3 class="text-2xl md:text-3xl font-bold text-aisd-midnight mb-2">
                {{ $name }}
            </h3>
            <p class="text-base md:text-lg font-semibold text-aisd-ocean">
                {{ $title }}
            </p>
        </div>

        {{-- Bio --}}
        @if($bio)
        <div class="prose prose-sm md:prose-base prose-gray max-w-none mb-6">
            <p class="text-gray-700 leading-relaxed">{{ $bio }}</p>
        </div>
        @endif

        {{-- Contact Info --}}
        @if($email || $phone || $linkedin)
        <div class="flex flex-wrap gap-3 {{ $layout === 'vertical' ? 'justify-center' : '' }}">
            @if($email)
            <a 
                href="mailto:{{ $email }}" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:border-aisd-ocean hover:text-aisd-ocean transition-all min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Email</span>
            </a>
            @endif

            @if($phone)
            <a 
                href="tel:{{ $phone }}" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:border-aisd-ocean hover:text-aisd-ocean transition-all min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Call</span>
            </a>
            @endif

            @if($linkedin)
            <a 
                href="{{ $linkedin }}" 
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:border-aisd-ocean hover:text-aisd-ocean transition-all min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                <span>LinkedIn</span>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
