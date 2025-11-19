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
    x-init="
        const header = $el;
        const announcementBar = header.querySelector('.announcement-bar');
        
        function updatePosition() {
            if (announcementBar && !scrolled) {
                const height = announcementBar.offsetHeight;
                header.style.top = height + 'px';
            } else {
                header.style.top = '0';
            }
        }
        
        function handleScroll() {
            scrolled = window.pageYOffset > 50;
            updatePosition();
        }
        
        if (announcementBar) {
            updatePosition();
            new ResizeObserver(() => updatePosition()).observe(announcementBar);
        }
        
        handleScroll();
        window.addEventListener('scroll', () => handleScroll());
    "
    class="fixed top-0 left-0 w-full z-50"
    role="banner"
>
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
        class="transition-all duration-300"
        :class="{
            'bg-white shadow-md': scrolled || !transparent,
            'bg-transparent': transparent && !scrolled
        }"
        :style="(scrolled || !transparent) ? 'background-color: {{ $primaryColor }}' : ''"
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
                        :class="scrolled || (transparent && !scrolled) ? 'focus:ring-white' : 'focus:ring-gray-900'"
                        aria-label="Go to homepage"
                    >
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        @endphp
                        <img
                            class="h-8 sm:h-10 lg:h-12 w-auto transition-all duration-300"
                            :class="scrolled || (transparent && !scrolled) ? 'brightness-0 invert' : ''"
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                    </a>
                </div>

                {{-- Desktop Navigation - Centered --}}
                <div class="hidden lg:flex items-center space-x-2 flex-1 justify-center min-w-0 px-6">
                    {{-- Dynamic Navigation Items --}}
                    @foreach($navigationItems as $navItem)
                        @php
                            // Navigation Items already filtered at repository level (is_active = true, section = 'main')
                            $children = $navItem->children ?? collect([]);
                            $hasChildren = $children->count() > 0;
                            
                            // Get URL from NavigationItem (handles route_name, url, slug, external)
                            $navUrl = $navItem->url ?? '#';
                            
                            // Check active state - improved detection
                            $isActive = false;
                            
                            // Check if route_name matches current route
                            if ($navItem->route_name) {
                                try {
                                    $isActive = request()->routeIs($navItem->route_name) || 
                                               request()->routeIs($navItem->route_name . '.*');
                                } catch (\Exception $e) {
                                    // Route doesn't exist, skip
                                }
                            }
                            
                            // Also check URL match for non-route items
                            if (!$isActive && $navItem->url && !$navItem->is_external) {
                                $currentUrl = request()->fullUrl();
                                $navUrlPath = parse_url($navItem->url, PHP_URL_PATH);
                                $currentPath = request()->path();
                                
                                if ($navUrlPath && ($currentPath === ltrim($navUrlPath, '/') || str_starts_with($currentPath, ltrim($navUrlPath, '/')))) {
                                    $isActive = true;
                                }
                            }
                            
                            // If parent has children, check if any child is active
                            if (!$isActive && $hasChildren) {
                                foreach ($children as $child) {
                                    if ($child->route_name) {
                                        try {
                                            if (request()->routeIs($child->route_name) || request()->routeIs($child->route_name . '.*')) {
                                                $isActive = true;
                                                break;
                                            }
                                        } catch (\Exception $e) {
                                            // Route doesn't exist, skip
                                        }
                                    } elseif ($child->url && !$child->is_external) {
                                        $childUrlPath = parse_url($child->url, PHP_URL_PATH);
                                        $currentPath = request()->path();
                                        if ($childUrlPath && ($currentPath === ltrim($childUrlPath, '/') || str_starts_with($currentPath, ltrim($childUrlPath, '/')))) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                }
                            }
                            
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
                                    class="nav-link flex items-center gap-1.5 px-4 py-2.5 text-base font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                                    :class="scrolled || (transparent && !scrolled) ? 'text-white hover:bg-white/10 focus:ring-white' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-900'"
                                    :class="(scrolled || (transparent && !scrolled)) && {{ $isActive ? 'true' : 'false' }} ? 'bg-white/20 font-semibold' : !(scrolled || (transparent && !scrolled)) && {{ $isActive ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
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
                                class="nav-link flex items-center gap-1.5 px-4 py-2.5 text-base font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                                :class="scrolled || (transparent && !scrolled) ? 'text-white hover:bg-white/10 focus:ring-white' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-900'"
                                :class="(scrolled || (transparent && !scrolled)) && {{ $isActive ? 'true' : 'false' }} ? 'bg-white/20 font-semibold' : !(scrolled || (transparent && !scrolled)) && {{ $isActive ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
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

                {{-- Right Side --}}
                <div class="hidden lg:flex items-center space-x-3 flex-shrink-0 z-10">
                    {{-- Logout Button (only for logged-in users) --}}
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="px-4 py-2.5 rounded-lg text-base font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                                :class="scrolled || (transparent && !scrolled) ? 'text-white hover:bg-white/10 focus:ring-white' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-900'"
                            >
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <div class="lg:hidden flex-shrink-0 ml-auto z-10">
                    <button
                        @click.stop="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 min-w-[44px] min-h-[44px]"
                        :class="scrolled || (transparent && !scrolled) ? 'text-white hover:bg-white/10 focus:ring-white' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-900'"
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

    {{-- Mobile Menu Overlay & Panel --}}
    <div
        x-show="mobileMenuOpen"
        x-cloak
        @keydown.escape.window="mobileMenuOpen = false"
        class="fixed inset-0 z-40 lg:hidden"
        style="display: none;"
    >
        {{-- Backdrop Overlay --}}
        <div 
            class="fixed inset-0 bg-black/50 transition-opacity duration-300"
            :class="mobileMenuOpen ? 'opacity-100' : 'opacity-0'"
            @click="mobileMenuOpen = false"
        ></div>

        {{-- Mobile Menu Panel --}}
        <div
            @click.stop
            class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-2xl overflow-y-auto z-50 transform"
            :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-full'"
            style="transition: transform 300ms ease-in-out;"
            :style="scrolled ? 'background-color: {{ $primaryColor }}' : ''"
        >
            <div class="flex flex-col h-full">
                {{-- Mobile Header --}}
                <div class="flex items-center justify-between p-4 border-b" :class="scrolled ? 'bg-transparent border-white/20' : 'border-gray-200 bg-white'">
                    <span class="text-lg font-semibold" :class="scrolled ? 'text-white' : 'text-gray-900'">Menu</span>
                    <button
                        @click="mobileMenuOpen = false"
                        class="p-2.5 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 min-w-[44px] min-h-[44px] flex items-center justify-center"
                        :class="scrolled ? 'text-white/80 hover:text-white hover:bg-white/10 focus:ring-white' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:ring-gray-500'"
                        aria-label="Close mobile menu"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu Content --}}
                <div class="flex-1 overflow-y-auto py-4 px-3">
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
                                
                                // Check if route_name matches current route
                                if ($navItem->route_name) {
                                    try {
                                        $isActiveMobile = request()->routeIs($navItem->route_name) || 
                                                         request()->routeIs($navItem->route_name . '.*');
                                    } catch (\Exception $e) {
                                        // Route doesn't exist, skip
                                    }
                                }
                                
                                // Also check URL match for non-route items
                                if (!$isActiveMobile && $navItem->url && !$navItem->is_external) {
                                    $navUrlPath = parse_url($navItem->url, PHP_URL_PATH);
                                    $currentPath = request()->path();
                                    
                                    if ($navUrlPath && ($currentPath === ltrim($navUrlPath, '/') || str_starts_with($currentPath, ltrim($navUrlPath, '/')))) {
                                        $isActiveMobile = true;
                                    }
                                }
                                
                                // If parent has children, check if any child is active
                                if (!$isActiveMobile && $hasChildren) {
                                    foreach ($children as $child) {
                                        if ($child->route_name) {
                                            try {
                                                if (request()->routeIs($child->route_name) || request()->routeIs($child->route_name . '.*')) {
                                                    $isActiveMobile = true;
                                                    break;
                                                }
                                            } catch (\Exception $e) {
                                                // Route doesn't exist, skip
                                            }
                                        } elseif ($child->url && !$child->is_external) {
                                            $childUrlPath = parse_url($child->url, PHP_URL_PATH);
                                            $currentPath = request()->path();
                                            if ($childUrlPath && ($currentPath === ltrim($childUrlPath, '/') || str_starts_with($currentPath, ltrim($childUrlPath, '/')))) {
                                                $isActiveMobile = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                                
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
                                        class="flex items-center justify-between w-full px-4 py-3 text-base font-medium rounded-lg transition-colors"
                                        :class="scrolled ? 'text-white hover:bg-white/10' : 'text-gray-900 hover:bg-gray-100'"
                                        :class="{{ $isActiveMobile ? 'true' : 'false' }} ? (scrolled ? 'bg-white/20 font-semibold' : 'bg-gray-100 font-semibold') : ''"
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
                                        class="pl-4 space-y-1 ml-4 overflow-hidden"
                                        :class="scrolled ? 'border-l-2 border-white/20' : 'border-l-2 border-gray-200'"
                                    >
                                        {{-- Parent Link (if route_name or url exists) --}}
                                        @if($navItem->route_name || $navItem->url)
                                            <a
                                                href="{{ $navUrl }}"
                                                @click="mobileMenuOpen = false"
                                                class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors"
                                                :class="scrolled ? 'text-white hover:bg-white/10 border-b border-white/20' : 'text-gray-800 hover:bg-gray-100 border-b border-gray-100'"
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
                                                class="block px-4 py-2.5 text-sm rounded-lg transition-colors {{ $childActive ? 'font-medium' : '' }}"
                                                :class="scrolled ? 'text-white/90 hover:bg-white/10 hover:text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'"
                                                :class="scrolled && {{ $childActive ? 'true' : 'false' }} ? 'bg-white/10' : !scrolled && {{ $childActive ? 'true' : 'false' }} ? 'bg-gray-50' : ''"
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
                                    class="block px-4 py-3 text-base font-medium rounded-lg transition-colors"
                                    :class="scrolled ? 'text-white hover:bg-white/10' : 'text-gray-900 hover:bg-gray-100'"
                                    :class="{{ $isActiveMobile ? 'true' : 'false' }} ? (scrolled ? 'bg-white/20 font-semibold' : 'bg-gray-100 font-semibold') : ''"
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
                            <div class="px-2 py-3 mt-auto" :class="scrolled ? 'border-t border-white/20' : 'border-t border-gray-200'">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="block w-full text-left px-4 py-3 text-base font-medium rounded-lg transition-colors"
                                        :class="scrolled ? 'text-white hover:bg-white/10' : 'text-gray-900 hover:bg-gray-100'"
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
    </div>
</header>
