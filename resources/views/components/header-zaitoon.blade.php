{{-- Zaitoon Academy Header Component --}}
@props(['transparent' => false])

@php
    // Get site settings
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor() ?: '#0d5a47';
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
    {{-- Top Bar: Contact Info & Action Buttons --}}
    @php
        // Use SiteSettingsHelper or fallback to example data
        $phone = \App\Helpers\SiteSettingsHelper::primaryPhone() ?: '+880 1234-567890';
        $email = \App\Helpers\SiteSettingsHelper::primaryEmail() ?: 'info@zaitoonacademy.com';
        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
    @endphp
    <div class="text-white py-2 text-xs hidden lg:block relative z-60" style="background-color: #0d5a47;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                {{-- Left: Contact Info --}}
                <div class="flex items-center gap-4">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" 
                       class="text-white/90 hover:text-white transition-colors flex items-center gap-1.5" aria-label="Call us">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <span>{{ $phone }}</span>
                    </a>
                    
                    <a href="mailto:{{ $email }}" 
                       class="text-white/90 hover:text-white transition-colors flex items-center gap-1.5" aria-label="Email us">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <span>{{ $email }}</span>
                    </a>
                </div>
                
                {{-- Right: Quick Action Buttons --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('notices.index', [], false) }}" 
                       class="px-3 py-1 text-xs font-medium rounded transition-colors"
                       style="background-color: #fbbf24; color: #0d5a47;"
                       onmouseover="this.style.backgroundColor='#f59e0b'"
                       onmouseout="this.style.backgroundColor='#fbbf24'">
                        Notice
                    </a>
                    <a href="{{ route('events.index', [], false) }}" 
                       class="px-3 py-1 text-xs font-medium rounded transition-colors"
                       style="background-color: #fbbf24; color: #0d5a47;"
                       onmouseover="this.style.backgroundColor='#f59e0b'"
                       onmouseout="this.style.backgroundColor='#fbbf24'">
                        News
                    </a>
                    <a href="{{ route('careers.index', [], false) }}" 
                       class="px-3 py-1 text-xs font-medium rounded transition-colors"
                       style="background-color: #fbbf24; color: #0d5a47;"
                       onmouseover="this.style.backgroundColor='#f59e0b'"
                       onmouseout="this.style.backgroundColor='#fbbf24'">
                        Careers
                    </a>
                    <a href="#faq" 
                       class="px-3 py-1 text-xs font-medium rounded transition-colors"
                       style="background-color: #fbbf24; color: #0d5a47;"
                       onmouseover="this.style.backgroundColor='#f59e0b'"
                       onmouseout="this.style.backgroundColor='#fbbf24'">
                        FAQ
                    </a>
                    <a href="{{ route('admission.index', [], false) }}" 
                       class="px-3 py-1 text-xs font-medium rounded transition-colors"
                       style="background-color: #fbbf24; color: #0d5a47;"
                       onmouseover="this.style.backgroundColor='#f59e0b'"
                       onmouseout="this.style.backgroundColor='#fbbf24'">
                        Apply Online
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation Bar (FR-2) --}}
    <nav
        class="transition-all duration-300 relative z-50 bg-white shadow-sm"
        :class="{ 'shadow-md': scrolled }"
        role="navigation"
        aria-label="Main navigation"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-18">
                
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        @endphp
                        <img
                            class="h-10 lg:h-12 w-auto transition-all duration-300"
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                        <div class="hidden sm:block">
                            <h1 class="text-base lg:text-lg font-bold leading-tight" style="color: #0d5a47;">
                                {{ $siteName }}
                            </h1>
                            <p class="text-xs text-gray-600">
                                Excellence in Education
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-6">
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
                                    class="flex items-center gap-1 px-2 py-1 text-sm font-semibold transition-colors duration-200 focus:outline-none hover:text-za-green-primary"
                                    :style="'color: ' + ({{ $activeState ? 'true' : 'false' }} ? '#0d5a47' : '#1f2937')"
                                    :aria-expanded="open"
                                >
                                    <span>{{ $navItem->title }}</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
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
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
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
                                class="px-2 py-1 text-sm font-semibold transition-colors duration-200 focus:outline-none hover:text-za-green-primary"
                                :style="'color: ' + ({{ $activeState ? 'true' : 'false' }} ? '#0d5a47' : '#1f2937')"
                                {!! $linkAttrs !!}
                            >
                                {{ $navItem->title }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Apply Button --}}
                    <a href="{{ route('admission.index', [], false) }}" 
                       class="px-5 py-2 text-sm font-semibold rounded-md transition-all duration-200 hover:shadow-md"
                       style="background-color: #fbbf24; color: #0d5a47;">
                        Apply Online
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="lg:hidden">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-za-green-500"
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
