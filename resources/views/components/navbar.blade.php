{{-- Enhanced Navbar Component with Alpine.js --}}
@props(['transparent' => false])

@php
    // Get primary color from site settings
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    if (!str_starts_with($primaryColor, '#')) {
        $primaryColor = '#' . ltrim($primaryColor, '#');
    }
    
    // Completely disable announcements during exception rendering
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
    
    // Get dynamic navigation items from database (hybrid approach: Navigation Items control menu structure)
    $navigationItems = collect([]);
    try {
        if (!app()->bound('exception')) {
            $navigationService = app(\App\Services\NavigationService::class);
            $navigationItems = $navigationService->getActiveNavigation('main');
        }
    } catch (\Throwable $e) {
        $navigationItems = collect([]);
    }
@endphp

{{-- Static wrapper with x-data - never receives dynamic classes --}}
<header
    x-data="{ 
        mobileMenuOpen: false,
        transparent: {{ $transparent ? 'true' : 'false' }},
        scrolled: false
    }"
    @keydown.window.tab="
        if (mobileMenuOpen) {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                const focusable = menu.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex=\'-1\'])');
                if (focusable.length) {
                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];
                    if ($event.shiftKey) {
                        if (document.activeElement === first) {
                            $event.preventDefault();
                            last.focus();
                        }
                    } else {
                        if (document.activeElement === last) {
                            $event.preventDefault();
                            first.focus();
                        }
                    }
                }
            }
        }
    "
    x-init="
        // Watch mobile menu state to lock/unlock body scroll
        $watch('mobileMenuOpen', value => {
            if (value) {
                document.body.classList.add('overflow-hidden');
                document.documentElement.classList.add('overflow-hidden');
                // Focus first element
                setTimeout(() => {
                    const menu = document.getElementById('mobile-menu');
                    if (menu) {
                        const focusable = menu.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex=\'-1\'])');
                        if (focusable.length) focusable[0].focus();
                    }
                }, 100);
            } else {
                document.body.classList.remove('overflow-hidden');
                document.documentElement.classList.remove('overflow-hidden');
            }
        });
        
        function handleScroll() {
            scrolled = window.pageYOffset > 50;
        }
        
        handleScroll();
        window.addEventListener('scroll', () => handleScroll());
    "
    class="fixed top-0 left-0 w-full z-[9999]"
    style="z-index: 9999;"
    role="banner"
>
    {{-- Top Bar: Social Media, Phone, Email (Zaitoon Style) --}}
    @php
        $settings = \App\Models\SiteSettings::getSettings();
        $phone = $settings->primary_phone ?? $settings->contact_phone ?? '+880 1748306492';
        $email = $settings->primary_email ?? $settings->contact_email ?? 'mail.zaitoonacademy@gmail.com';
        $socialLinks = $settings->social_media_links ?? [];
        $facebook = $socialLinks['facebook'] ?? '#';
        $linkedin = $socialLinks['linkedin'] ?? '#';
        $instagram = $socialLinks['instagram'] ?? '#';
        $youtube = $socialLinks['youtube'] ?? '#';
    @endphp
    <div class="bg-za-green-dark text-white py-2 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                {{-- Left: Social Media Icons --}}
                <div class="flex items-center gap-4">
                    @if($facebook && $facebook !== '#')
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if($linkedin && $linkedin !== '#')
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                    @if($instagram && $instagram !== '#')
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($youtube && $youtube !== '#')
                    <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer" 
                       class="text-white hover:text-za-yellow-accent transition-colors" aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                
                {{-- Right: Phone and Email --}}
                <div class="flex items-center gap-6">
                    @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" 
                       class="text-white hover:text-za-yellow-accent transition-colors text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $phone }}</span>
                    </a>
                    @endif
                    @if($email)
                    <a href="mailto:{{ $email }}" 
                       class="text-white hover:text-za-yellow-accent transition-colors text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $email }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Top Announcement Bar --}}
    @if($announcements->isNotEmpty() && request()->routeIs('home'))
    <div 
        class="announcement-bar" 
        x-show="!scrolled"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="marquee-wrapper">
            <div class="marquee-content">
                @foreach($announcements as $announcement)
                    @if($announcement && !empty($announcement->message))
                    <span>
                        @if(!empty($announcement->link))
                            <a href="{{ e($announcement->link ?? '') }}" class="hover:underline text-white" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                                {{ e($announcement->message ?? '') }}
                                @if(!empty($announcement->link_text))
                                    <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                                @endif
                            </a>
                        @else
                            {{ e($announcement->message ?? '') }}
                        @endif
                    </span>
                    <span>
                        @if(!empty($announcement->link))
                            <a href="{{ e($announcement->link ?? '') }}" class="hover:underline text-white" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                                {{ e($announcement->message ?? '') }}
                                @if(!empty($announcement->link_text))
                                    <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                                @endif
                            </a>
                        @else
                            {{ e($announcement->message ?? '') }}
                        @endif
                    </span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Inner nav with scroll-based styling --}}
<nav
    class="transition-all duration-300 shadow-md"
    :class="{
        'bg-transparent': transparent && !scrolled
    }"
    :style="(transparent && !scrolled) ? 'background-color: transparent' : 'background-color: #1a5e4a'"
        role="navigation"
        aria-label="Main navigation"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 lg:h-20 relative">
                {{-- Logo --}}
                <div class="flex-shrink-0 z-10">
                    <a
                        href="{{ route('home') }}"
                        class="navbar-logo navbar-focus focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg p-1"
                        :class="{
                            'focus:ring-white': true
                        }"
                        aria-label="Go to homepage"
                    >
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        @endphp
                        <img
                            class="h-8 sm:h-10 lg:h-12 w-auto transition-all duration-300"
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                    </a>
                </div>

                {{-- Desktop Navigation - Centered (only on xl screens and above) --}}
                <div class="hidden xl:flex items-center gap-1 2xl:gap-2 flex-1 justify-center min-w-0 px-4 2xl:px-6">
                    {{-- Dynamic Navigation Items --}}
                    @foreach($navigationItems as $navItem)
                        @php
                            // Navigation Items already filtered at repository level (is_active = true, section = 'main')
                            $children = $navItem->children ?? collect([]);
                            $hasChildren = $children->count() > 0;
                            
                            // Get URL from NavigationItem (handles route_name, url, slug, external)
                            $navUrl = $navItem->url ?? '#';
                            
                            // Check active state - improved detection
                            // Check active state using View Composer helper
                            $activeState = $isActive($navItem);
                            
                            // Link attributes
                            $linkAttrs = '';
                            if ($navItem->is_external || $navItem->target_blank) {
                                $linkAttrs = 'target="_blank" rel="noopener noreferrer"';
                            }
                        @endphp

                        @if($hasChildren)
                            {{-- Dropdown Menu Item --}}
                            <div class="relative" x-data="{ open: false }">
                                <button
                                    @click="open = !open"
                                    @keydown.escape="open = false"
                                    class="nav-link flex items-center gap-1 px-2 2xl:px-3 py-2 text-xs 2xl:text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors whitespace-nowrap"
                                    :class="{
                                        'text-white hover:bg-white/10 focus:ring-white': true,
                                        'bg-white/20 font-semibold': {{ $activeState ? 'true' : 'false' }}
                                    }"
                                    :aria-expanded="open"
                                    aria-haspopup="true"
                                >
                                    @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                        <span class="inline-block mr-2">{!! $navItem->icon !!}</span>
                                    @endif
                                    <span>{{ $navItem->title }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl min-w-[220px] z-50 py-1"
                                    style="display: none;"
                                >
                                    {{-- Parent Link (if route_name or url exists) --}}
                                    @if($navItem->route_name || $navItem->url)
                                        <a
                                            href="{{ $navUrl }}"
                                            class="block px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition-colors border-b border-gray-100"
                                            @click="open = false"
                                            {!! $linkAttrs !!}
                                        >
                                            {{ $navItem->title }}
                                        </a>
                                    @endif

                                    {{-- Child Navigation Items --}}
                                    @foreach($children as $child)
                                        @php
                                            $childUrl = $child->url ?? '#';
                                            $childLinkAttrs = '';
                                            if ($child->is_external || $child->target_blank) {
                                                $childLinkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                            }
                                            
                                            // Check active state for child
                                            $childActive = false;
                                            if ($child->route_name) {
                                                try {
                                                    $childActive = request()->routeIs($child->route_name);
                                                } catch (\Exception $e) {
                                                    // Route doesn't exist
                                                }
                                            }
                                        @endphp
                                        <a
                                            href="{{ $childUrl }}"
                                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors {{ $childActive ? 'bg-gray-50 font-medium' : '' }}"
                                            @click="open = false"
                                            {!! $childLinkAttrs !!}
                                            aria-current="{{ $childActive ? 'page' : null }}"
                                        >
                                            @if($child->icon && !str_starts_with($child->icon, 'heroicon'))
                                                <span class="inline-block mr-2">{!! $child->icon !!}</span>
                                            @endif
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Simple Link Menu Item --}}
                            <a
                                href="{{ $navUrl }}"
                                class="nav-link flex items-center gap-1 px-2 2xl:px-3 py-2 text-xs 2xl:text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors whitespace-nowrap"
                                :class="{
                                    'text-white hover:bg-white/10 focus:ring-white': true,
                                    'bg-white/20 font-semibold': {{ $activeState ? 'true' : 'false' }}
                                }"
                                aria-current="{{ $isActive ? 'page' : null }}"
                                {!! $linkAttrs !!}
                            >
                                @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                    <span>{!! $navItem->icon !!}</span>
                                @endif
                                <span>{{ $navItem->title }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Right Side: Apply Online Button & Login --}}
                <div class="hidden lg:flex items-center space-x-4 flex-shrink-0 z-10">
                    {{-- Apply Online Button --}}
                    <a href="{{ route('admission.index', [], false) ?? '#' }}" 
                       class="bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold px-6 py-2.5 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                        Apply Online
                    </a>
                    
                    {{-- Login Icon/Button --}}
                    @auth
                        <a href="{{ route('filament.admin.pages.dashboard') }}" 
                           class="text-white hover:text-za-yellow-accent transition-colors p-2 rounded-lg hover:bg-white/10"
                           aria-label="Admin Dashboard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-white hover:text-za-yellow-accent transition-colors p-2 rounded-lg hover:bg-white/10"
                           aria-label="Login">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button (show on screens below xl) --}}
                <div class="xl:hidden flex-shrink-0 ml-auto z-10">
                    <button
                        @click.stop="mobileMenuOpen = !mobileMenuOpen; $dispatch('mobile-menu-toggle', { open: mobileMenuOpen })"
                        class="inline-flex items-center justify-center p-2.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 min-w-[44px] min-h-[44px]"
                        :class="{
                            'text-white hover:bg-white/10 focus:ring-white': true
                        }"
                        :aria-expanded="mobileMenuOpen"
                        aria-controls="mobile-menu"
                        aria-label="Toggle mobile menu"
                    >
                        <svg class="block h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- Mobile Menu Dropdown (inline accordion - show on screens below xl) --}}
<div 
    x-data="{ mobileMenuOpen: false }"
    @mobile-menu-toggle.window="mobileMenuOpen = $event.detail.open"
    class="xl:hidden"
>
    <div
        x-show="mobileMenuOpen"
        x-cloak
        @keydown.escape.window="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-200 max-h-[calc(100vh-4rem)] overflow-y-auto"
        style="z-index: 9998;"
        id="mobile-menu"
        role="navigation"
        aria-label="Mobile navigation"
    >
        <div class="py-4 px-4">
            <nav class="space-y-1">
                        {{-- Dynamic Navigation Items --}}
                        @foreach($navigationItems as $navItem)
                            @php
                                // Navigation Items already filtered at repository level (is_active = true, section = 'main')
                                $children = $navItem->children ?? collect([]);
                                $hasChildren = $children->count() > 0;
                                
                                // Get URL from NavigationItem (handles route_name, url, slug, external)
                                $navUrl = $navItem->url ?? '#';
                                
                                // Check active state for mobile
                                $isActiveMobile = false;
                                
                                // Check active state using View Composer helper
                                $isActiveMobile = $isActive($navItem);
                                
                                // Link attributes
                                $linkAttrs = '';
                                if ($navItem->is_external || $navItem->target_blank) {
                                    $linkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                }
                            @endphp

                            @if($hasChildren)
                                {{-- Navigation Item with Children --}}
                                <div x-data="{ open: false }" class="space-y-1">
                                    <button
                                        @click="open = !open"
                                        class="flex items-center justify-between w-full px-4 py-3 text-base font-medium rounded-lg text-gray-900 hover:bg-gray-100 transition-colors"
                                        :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
                                    >
                                        <span class="flex items-center gap-2">
                                            @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                                <span>{!! $navItem->icon !!}</span>
                                            @endif
                                            <span>{{ $navItem->title }}</span>
                                        </span>
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        class="pl-4 space-y-1 ml-4 overflow-hidden border-l-2 border-gray-200"
                                    >
                                        {{-- Parent Link (if route_name or url exists) --}}
                                        @if($navItem->route_name || $navItem->url)
                                            <a
                                                href="{{ $navUrl }}"
                                                @click="mobileMenuOpen = false"
                                                class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-800 hover:bg-gray-100 border-b border-gray-100"
                                                {!! $linkAttrs !!}
                                            >
                                                {{ $navItem->title }}
                                            </a>
                                        @endif
                                        {{-- Child Navigation Items --}}
                                        @foreach($children as $child)
                                            @php
                                                $childUrl = $child->url ?? '#';
                                                $childLinkAttrs = '';
                                                if ($child->is_external || $child->target_blank) {
                                                    $childLinkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                                }
                                                
                                                // Check active state for child
                                                $childActive = false;
                                                if ($child->route_name) {
                                                    try {
                                                        $childActive = request()->routeIs($child->route_name);
                                                    } catch (\Exception $e) {
                                                        // Route doesn't exist
                                                    }
                                                }
                                            @endphp
                                            <a
                                                href="{{ $childUrl }}"
                                                @click="mobileMenuOpen = false"
                                                class="block px-4 py-2.5 text-sm rounded-lg transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ $childActive ? 'font-medium bg-gray-50' : '' }}"
                                                {!! $childLinkAttrs !!}
                                                aria-current="{{ $childActive ? 'page' : null }}"
                                            >
                                                @if($child->icon && !str_starts_with($child->icon, 'heroicon'))
                                                    <span class="inline-block mr-2">{!! $child->icon !!}</span>
                                                @endif
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                {{-- Simple Link Menu Item --}}
                                <a
                                    href="{{ $navUrl }}"
                                    @click="mobileMenuOpen = false"
                                    class="block px-4 py-3 text-base font-medium rounded-lg transition-colors text-gray-900 hover:bg-gray-100"
                                    :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
                                    {!! $linkAttrs !!}
                                >
                                    <span class="flex items-center gap-2">
                                        @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                            <span>{!! $navItem->icon !!}</span>
                                        @endif
                                        <span>{{ $navItem->title }}</span>
                                    </span>
                                </a>
                            @endif
                        @endforeach

                        {{-- Mobile Logout (only for logged-in users) --}}
                        @auth
                            <div class="px-2 py-3 mt-auto border-t border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="block w-full text-left px-4 py-3 text-base font-medium rounded-lg transition-colors text-gray-900 hover:bg-gray-100"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth
            </nav>
        </div>
    </div>
</div>
