{{-- Zaitoon Academy Header Component --}}
@props(['transparent' => false])

@php
    // Get site settings
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor() ?: '#1a5e4a';
    if (!str_starts_with($primaryColor, '#')) {
        $primaryColor = '#' . ltrim($primaryColor, '#');
    }
    
    // Get announcements safely
    $announcements = collect([]);
    try {
        if (!app()->bound('exception') && 
            !str_contains(request()->path() ?? '', 'errors') &&
            !str_contains(request()->path() ?? '', '_dusk') &&
            !str_contains(request()->path() ?? '', 'telescope')) {
            $announcements = \App\Helpers\AnnouncementHelper::getSafe();
        }
    } catch (\Throwable $e) {
        $announcements = collect([]);
    }
    
    // Get navigation items
    $navigationItems = collect([]);
    try {
        if (!app()->bound('exception')) {
            $navigationService = app(\App\Services\NavigationService::class);
            $navigationItems = $navigationService->getActiveNavigation('main');
        }
    } catch (\Throwable $e) {
        $navigationItems = collect([]);
    }
    
    // Helper function to check if navigation item is active
    $isActive = function($navItem) {
        if (!$navItem || !$navItem->route_name) return false;
        try {
            return request()->routeIs($navItem->route_name . '*');
        } catch (\Exception $e) {
            return false;
        }
    };
@endphp

<header
    x-data="{ 
        mobileMenuOpen: false,
        transparent: {{ $transparent ? 'true' : 'false' }},
        scrolled: false,
        searchOpen: false,
        activeDropdown: null
    }"
    @keydown.escape.window="mobileMenuOpen = false; searchOpen = false; activeDropdown = null"
    @click.away="activeDropdown = null"
    x-init="
        scrolled = window.pageYOffset > 50;
        window.addEventListener('scroll', function() {
            scrolled = window.pageYOffset > 50;
        });
        $watch('mobileMenuOpen', function(value) {
            if (value) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        });
    "
    class="fixed top-0 left-0 w-full z-50"
    role="banner"
>
    {{-- Top Bar: Phone, Email (Left) | Social Media, Login (Right) - FR-1 --}}
    @php
        // Use SiteSettingsHelper as per PRD FR-1.8
        $phone = \App\Helpers\SiteSettingsHelper::primaryPhone();
        $email = \App\Helpers\SiteSettingsHelper::primaryEmail();
        $socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();
        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
        
        $facebook = $socialLinks['facebook'] ?? '#';
        $linkedin = $socialLinks['linkedin'] ?? '#';
        $instagram = $socialLinks['instagram'] ?? '#';
        $youtube = $socialLinks['youtube'] ?? '#';
    @endphp
    <div class="bg-za-green-dark text-white py-2 text-xs hidden lg:block relative z-60" style="background-color: #0f3d30;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                {{-- Left: Site Name, Phone, Email (FR-1.2) --}}
                <div class="flex items-center gap-6">
                    {{-- Site Name (from image description) --}}
                    <span class="font-semibold">{{ $siteName }}</span>
                    
                    @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" 
                       class="text-white hover:text-za-yellow-accent transition-colors flex items-center gap-2" aria-label="Call us">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $phone }}</span>
                    </a>
                    @endif
                    @if($email)
                    <a href="mailto:{{ $email }}" 
                       class="text-white hover:text-za-yellow-accent transition-colors flex items-center gap-2" aria-label="Email us">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $email }}</span>
                    </a>
                    @endif
                </div>
                
                {{-- Right: Social Media Icons + Login Button (FR-1.3) --}}
                <div class="flex items-center gap-4">
                    @if($facebook && $facebook !== '#')
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if($linkedin && $linkedin !== '#')
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                    @if($instagram && $instagram !== '#')
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($youtube && $youtube !== '#')
                    <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                    
                    {{-- Login Button (FR-1.5) --}}
                    @php
                        try {
                            $loginRoute = route('login', [], false);
                            $hasLoginRoute = true;
                        } catch (\Exception $e) {
                            $hasLoginRoute = false;
                            $loginRoute = '#';
                        }
                    @endphp
                    @if($hasLoginRoute)
                    <a href="{{ $loginRoute }}" 
                       class="text-white hover:text-za-yellow-accent transition-colors flex items-center gap-2" aria-label="Login">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Login</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Announcement Ticker Bar --}}
    @if($announcements->isNotEmpty())
    <div 
        x-show="!scrolled"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-full"
        class="bg-za-green-dark text-white py-2 overflow-hidden"
        style="background-color: {{ $primaryColor }};"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-4">
                <svg class="w-5 h-5 flex-shrink-0 text-za-yellow-accent" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <div class="flex-1 overflow-hidden">
                    <div class="animate-marquee whitespace-nowrap">
                        @foreach($announcements as $announcement)
                            <span class="inline-block px-8">
                                @if($announcement->link)
                                    <a href="{{ $announcement->link }}" class="hover:text-za-yellow-accent transition-colors">
                                        {{ $announcement->message }}
                                        @if($announcement->link_text)
                                            <span class="ml-1 font-semibold">{{ $announcement->link_text }} →</span>
                                        @endif
                                    </a>
                                @else
                                    {{ $announcement->message }}
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Navigation Bar (FR-2) --}}
    <nav
        class="transition-all duration-300 relative z-50"
        :class="{
            'bg-white shadow-lg': scrolled || !transparent,
            'bg-white/95 backdrop-blur-md': !scrolled && transparent
        }"
        role="navigation"
        aria-label="Main navigation"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        @endphp
                        <img
                            class="h-12 lg:h-14 w-auto transition-all duration-300"
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                        <div class="hidden md:block">
                            <h1 
                                class="text-lg font-bold leading-tight transition-colors duration-300"
                                :class="(scrolled || !transparent) ? 'text-za-green-primary' : 'text-white'"
                            >
                                {{ $siteName }}
                            </h1>
                            <p 
                                class="text-xs tracking-wide uppercase transition-colors duration-300"
                                :class="(scrolled || !transparent) ? 'text-za-yellow-accent' : 'text-za-yellow-light'"
                            >
                                Excellence in Education
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-8">
                    @foreach($navigationItems as $navItem)
                        @php
                            $children = $navItem->children ?? collect([]);
                            $hasChildren = $children->count() > 0;
                            $navUrl = $navItem->url ?? '#';
                            $activeState = $isActive($navItem);
                            $linkAttrs = '';
                            if ($navItem->is_external || $navItem->target_blank) {
                                $linkAttrs = 'target="_blank" rel="noopener noreferrer"';
                            }
                        @endphp

                        @if($hasChildren)
                            {{-- Dropdown Menu --}}
                            <div class="relative" x-data="{ open: false }">
                                <button
                                    @click="open = !open"
                                    @mouseenter="open = true"
                                    @mouseleave="open = false"
                                    class="flex items-center gap-1 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                                    :class="{
                                        'text-za-green-primary bg-za-green-light': {{ $activeState ? 'true' : 'false' }} && (scrolled || !transparent),
                                        'text-gray-700 hover:text-za-green-primary hover:bg-za-green-50': !{{ $activeState ? 'true' : 'false' }} && (scrolled || !transparent),
                                        'text-white hover:text-za-yellow-accent': !scrolled && transparent
                                    }"
                                    :aria-expanded="open"
                                >
                                    <span>{{ $navItem->title }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                {{-- Dropdown Content --}}
                                <div
                                    x-show="open"
                                    @mouseenter="open = true"
                                    @mouseleave="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                                    style="display: none;"
                                >
                                    @foreach($children as $child)
                                        @php
                                            $childUrl = $child->url ?? '#';
                                            $childLinkAttrs = '';
                                            if ($child->is_external || $child->target_blank) {
                                                $childLinkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                            }
                                        @endphp
                                        <a
                                            href="{{ $childUrl }}"
                                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-za-green-50 hover:text-za-green-primary transition-colors"
                                            {!! $childLinkAttrs !!}
                                        >
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Simple Link --}}
                            <a
                                href="{{ $navUrl }}"
                                class="px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                                :class="{
                                    'text-za-green-primary bg-za-green-light': {{ $activeState ? 'true' : 'false' }} && (scrolled || !transparent),
                                    'text-gray-700 hover:text-za-green-primary hover:bg-za-green-50': !{{ $activeState ? 'true' : 'false' }} && (scrolled || !transparent),
                                    'text-white hover:text-za-yellow-accent': !scrolled && transparent
                                }"
                                {!! $linkAttrs !!}
                            >
                                {{ $navItem->title }}
                            </a>
                        @endif
                    @endforeach

                    {{-- CTA Button (FR-2.6, FR-2.10) --}}
                    <a 
                        href="{{ route('admission.index', [], false) }}" 
                        class="px-6 py-2.5 bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-bold rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-za-yellow"
                    >
                        Apply Online
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="lg:hidden">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-za-green-500"
                        :class="(scrolled || !transparent) ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                        :aria-expanded="mobileMenuOpen"
                        aria-label="Toggle mobile menu"
                    >
                        <svg class="h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="lg:hidden bg-white border-t border-gray-200 shadow-lg"
        style="display: none;"
        id="mobile-menu"
    >
        <div class="px-4 py-6 space-y-1 max-h-screen overflow-y-auto">
            @foreach($navigationItems as $navItem)
                @php
                    $children = $navItem->children ?? collect([]);
                    $hasChildren = $children->count() > 0;
                    $navUrl = $navItem->url ?? '#';
                    $isActiveMobile = $isActive($navItem);
                @endphp

                @if($hasChildren)
                    {{-- Mobile Accordion --}}
                    <div x-data="{ open: false }" class="space-y-1">
                        <button
                            @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-3 text-base font-semibold rounded-lg transition-colors"
                            :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-za-green-light text-za-green-primary' : 'text-gray-700 hover:bg-gray-100'"
                        >
                            <span>{{ $navItem->title }}</span>
                            <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div 
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-96"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 max-h-96"
                            x-transition:leave-end="opacity-0 max-h-0"
                            class="pl-4 space-y-1 overflow-hidden"
                            style="display: none;">
                            @foreach($children as $child)
                                <a
                                    href="{{ $child->url ?? '#' }}"
                                    @click="mobileMenuOpen = false"
                                    class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-za-green-50 hover:text-za-green-primary rounded-lg transition-colors"
                                >
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Mobile Simple Link --}}
                    <a
                        href="{{ $navUrl }}"
                        @click="mobileMenuOpen = false"
                        class="block px-4 py-3 text-base font-semibold rounded-lg transition-colors"
                        :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-za-green-light text-za-green-primary' : 'text-gray-700 hover:bg-gray-100'"
                    >
                        {{ $navItem->title }}
                    </a>
                @endif
            @endforeach

            {{-- Mobile CTA --}}
            <div class="pt-4 mt-4 border-t border-gray-200">
                <a 
                    href="{{ route('admission.index') }}"
                    @click="mobileMenuOpen = false"
                    class="block w-full text-center px-6 py-3 bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-bold rounded-full transition-colors shadow-md"
                >
                    Apply for Admission
                </a>
            </div>
        </div>
    </div>
</header>

{{-- Add marquee animation CSS --}}
@push('styles')
<style>
    @keyframes marquee {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }
    
    .animate-marquee {
        display: inline-block;
        animation: marquee 20s linear infinite;
    }
    
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>
@endpush
