<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $settings = \App\Helpers\SiteSettingsHelper::all();
            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
            $siteDescription = \App\Helpers\SiteSettingsHelper::websiteDescription();
            $metaTitle = \App\Helpers\SiteSettingsHelper::metaTitle();
            $metaDescription = \App\Helpers\SiteSettingsHelper::metaDescription();
            $metaKeywords = \App\Helpers\SiteSettingsHelper::metaKeywords();
            $ogTitle = \App\Helpers\SiteSettingsHelper::ogTitle();
            $ogDescription = \App\Helpers\SiteSettingsHelper::ogDescription();
            $ogImageUrl = \App\Helpers\SiteSettingsHelper::ogImageUrl();
            $canonicalUrl = \App\Helpers\SiteSettingsHelper::canonicalUrl();
            $faviconUrl = \App\Helpers\SiteSettingsHelper::faviconUrl();
            $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
            $secondaryColor = \App\Helpers\SiteSettingsHelper::secondaryColor();
            $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
            $customCss = \App\Helpers\SiteSettingsHelper::customCss();
            $customJs = \App\Helpers\SiteSettingsHelper::customJs();
            $googleAnalyticsId = \App\Helpers\SiteSettingsHelper::googleAnalyticsId();
        @endphp
        <title>@yield('title', $metaTitle ?? $siteName)</title>

        @hasSection('meta-description')
            <meta name="description" content="@yield('meta-description')">
        @elseif($metaDescription)
            <meta name="description" content="{{ $metaDescription }}">
        @else
            <meta name="description" content="{{ $siteName }} - {{ $siteDescription ?? 'Excellence in Islamic Education' }}">
        @endif

        @hasSection('meta-keywords')
            <meta name="keywords" content="@yield('meta-keywords')">
        @elseif($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}">
        @endif

        @if($faviconUrl)
            <link rel="icon" href="{{ $faviconUrl }}">
        @endif

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $canonicalUrl ?? url()->current() }}">
        <meta property="og:title" content="@yield('title', $ogTitle ?? $metaTitle ?? $siteName)">
        @hasSection('meta-description')
            <meta property="og:description" content="@yield('meta-description')">
        @elseif($ogDescription)
            <meta property="og:description" content="{{ $ogDescription }}">
        @elseif($metaDescription)
            <meta property="og:description" content="{{ $metaDescription }}">
        @endif
        @hasSection('og-image')
            <meta property="og:image" content="@yield('og-image')">
        @elseif($ogImageUrl)
            <meta property="og:image" content="{{ $ogImageUrl }}">
        @else
            <meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
        @endif
        <meta property="og:site_name" content="{{ $siteName }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ $canonicalUrl ?? url()->current() }}">
        <meta name="twitter:title" content="@yield('title', $ogTitle ?? $metaTitle ?? $siteName)">
        @hasSection('meta-description')
            <meta name="twitter:description" content="@yield('meta-description')">
        @elseif($ogDescription)
            <meta name="twitter:description" content="{{ $ogDescription }}">
        @elseif($metaDescription)
            <meta name="twitter:description" content="{{ $metaDescription }}">
        @endif
        @hasSection('og-image')
            <meta name="twitter:image" content="@yield('og-image')">
        @elseif($ogImageUrl)
            <meta name="twitter:image" content="{{ $ogImageUrl }}">
        @endif

        <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">
        <x-organization-structured-data />

        <style>
            [x-cloak] { display: none !important; }
            :root {
                --site-chrome: #01041C;
                --site-chrome-mid: #152a52;
                --color-primary: #01041C;
                --color-secondary: #152a52;
                --color-accent: #01041C;
            }
        </style>

        @if($customCss)
            <style>{!! $customCss !!}</style>
        @endif

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if($googleAnalyticsId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $googleAnalyticsId }}');
        </script>
        @elseif(config('services.google_analytics.id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.id') }}');
        </script>
        @endif

        @if(config('services.google_tag_manager.id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('services.google_tag_manager.id') }}');</script>
        @endif

        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/scroll-animations.js'
        ])

        <noscript>
            @vite('resources/css/fallback.css')
        </noscript>

        <style id="site-navy-no-green">
            header[role="banner"] > div.text-white { background-color: var(--site-chrome) !important; }
            footer.relative.text-white { background-color: var(--site-chrome) !important; }
            header[role="banner"] .bg-za-green-dark.text-white { background-color: var(--site-chrome) !important; }

            header[role="banner"] > div.text-white a[style*="background-color: #fbbf24"],
            header[role="banner"] > div.text-white a[style*="background-color:#fbbf24"],
            header[role="banner"] > div.text-white a[style*="background-color: #ffffff"],
            header[role="banner"] > div.text-white a[style*="background-color:#ffffff"] {
                background-color: var(--site-chrome) !important;
                color: #ffffff !important;
            }
            header[role="banner"] > div.text-white .lg\:hidden a[style*="background-color: #fbbf24"],
            header[role="banner"] > div.text-white .lg\:hidden a[style*="background-color:#fbbf24"],
            header[role="banner"] > div.text-white .lg\:hidden a[style*="background-color: #ffffff"],
            header[role="banner"] > div.text-white .lg\:hidden a[style*="background-color:#ffffff"] {
                background-color: var(--site-chrome) !important;
                color: #ffffff !important;
            }

            .bg-za-green-primary { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .hover\:bg-za-green-primary:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }
            .group:hover .group-hover\:bg-za-green-primary { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .bg-za-green-dark { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .hover\:bg-za-green-dark:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }
            .text-za-green-primary { color: var(--site-chrome) !important; }
            .hover\:text-za-green-primary:hover { color: var(--site-chrome-mid) !important; }
            .group:hover .group-hover\:text-za-green-primary { color: var(--site-chrome) !important; }
            .border-za-green-primary { border-color: var(--site-chrome) !important; }
            .ring-za-green-500, .focus\:ring-za-green-500:focus { --tw-ring-color: var(--site-chrome-mid) !important; }
            .bg-za-green-light { background-color: rgba(1, 4, 28, 0.08) !important; }
            .bg-za-green-50 { background-color: rgba(1, 4, 28, 0.05) !important; }
            .hover\:bg-za-green-50:hover { background-color: rgba(1, 4, 28, 0.12) !important; }
            .bg-za-green-gradient {
                background-image: linear-gradient(135deg, #01041C 0%, #152a52 100%) !important;
                color: #ffffff !important;
            }

            .text-\[\#008236\] { color: var(--site-chrome) !important; }
            .bg-\[\#008236\] { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .border-\[\#008236\] { border-color: var(--site-chrome) !important; }
            .hover\:bg-\[\#006a2b\]:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }
            .from-\[\#008236\]\/5 {
                --tw-gradient-from: rgba(1, 4, 28, 0.05) var(--tw-gradient-from-position) !important;
                --tw-gradient-to: rgba(1, 4, 28, 0) var(--tw-gradient-to-position) !important;
                --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
            }
            .group:hover .group-hover\:bg-\[\#008236\] { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .group:hover .group-hover\:text-\[\#008236\] { color: var(--site-chrome) !important; }

            a.text-white[style*="background-color: #008236"],
            a.text-white[style*="background-color:#008236"],
            button.text-white[style*="background-color: #008236"],
            button.text-white[style*="background-color:#008236"] { color: #ffffff !important; }

            a.bg-white.text-\[\#008236\].border.border-\[\#008236\],
            a.border-\[\#008236\].text-\[\#008236\].bg-white {
                background-color: var(--site-chrome) !important;
                color: #ffffff !important;
                border-color: var(--site-chrome) !important;
            }

            .file\:bg-za-green-primary::file-selector-button { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .hover\:file\:bg-za-green-dark:hover::file-selector-button { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }

            a[style*="linear-gradient(135deg, #008236"], a[style*="linear-gradient(135deg,#008236"] {
                background: linear-gradient(135deg, #01041C 0%, #152a52 100%) !important;
                color: #ffffff !important;
            }

            [style*="background-color: #008236"], [style*="background-color:#008236"] { background-color: var(--site-chrome) !important; }
            [style^="color: #008236"], [style^="color:#008236"],
            [style*="; color: #008236"], [style*="; color:#008236"] { color: var(--site-chrome) !important; }

            [style*="linear-gradient(135deg, #008236"], [style*="linear-gradient(135deg,#008236"],
            [style*="linear-gradient(135deg, #008236 0%, #0a4536"], [style*="linear-gradient(135deg,#008236 0%,#0a4536"],
            [style*="linear-gradient(135deg, #008236 0%, #7AB91E"], [style*="linear-gradient(135deg, #008236 0%, #A8D86E"],
            [style*="linear-gradient(135deg, #008236 0%, #95CA55"] {
                background: linear-gradient(135deg, #01041C 0%, #152a52 100%) !important;
            }
            a[style*="linear-gradient(135deg, #008236"], a[style*="linear-gradient(135deg,#008236"] { color: #ffffff !important; }

            [style*="linear-gradient(180deg, #ffffff 0%, #f0fdf4"], [style*="linear-gradient(180deg, #f0fdf4"] {
                background: linear-gradient(180deg, #ffffff 0%, rgba(1, 4, 28, 0.06) 50%, #ffffff 100%) !important;
            }

            [style*="radial-gradient(circle, #008236"] {
                background-image: radial-gradient(circle, #01041C 1px, transparent 1px) !important;
            }

            [class*="text-green-"] { color: var(--site-chrome) !important; }

            [class*="bg-green-50"] { background-color: rgba(1, 4, 28, 0.05) !important; color: inherit !important; }
            [class*="bg-green-100"] { background-color: rgba(1, 4, 28, 0.08) !important; color: inherit !important; }
            [class*="bg-green-200"] { background-color: rgba(1, 4, 28, 0.1) !important; color: inherit !important; }
            [class*="bg-green-300"] { background-color: rgba(1, 4, 28, 0.14) !important; color: inherit !important; }
            [class*="bg-green-400"] { background-color: rgba(1, 4, 28, 0.2) !important; color: inherit !important; }
            [class*="bg-green-500"], [class*="bg-green-600"], [class*="bg-green-700"],
            [class*="bg-green-800"], [class*="bg-green-900"] {
                background-color: var(--site-chrome) !important;
                color: #ffffff !important;
            }
            [class*="border-green-"] { border-color: var(--site-chrome) !important; }
            [class*="ring-green-"] { --tw-ring-color: var(--site-chrome-mid) !important; }
            [class*="fill-green-"] { fill: var(--site-chrome) !important; }
            [class*="stroke-green-"] { stroke: var(--site-chrome) !important; }

            [class*="text-emerald-"] { color: var(--site-chrome) !important; }
            [class*="bg-emerald-50"] { background-color: rgba(1, 4, 28, 0.05) !important; color: inherit !important; }
            [class*="bg-emerald-100"] { background-color: rgba(1, 4, 28, 0.08) !important; color: inherit !important; }
            [class*="bg-emerald-200"] { background-color: rgba(1, 4, 28, 0.1) !important; color: inherit !important; }
            [class*="bg-emerald-300"] { background-color: rgba(1, 4, 28, 0.14) !important; color: inherit !important; }
            [class*="bg-emerald-400"] { background-color: rgba(1, 4, 28, 0.2) !important; color: inherit !important; }
            [class*="bg-emerald-500"], [class*="bg-emerald-600"], [class*="bg-emerald-700"],
            [class*="bg-emerald-800"], [class*="bg-emerald-900"] {
                background-color: var(--site-chrome) !important;
                color: #ffffff !important;
            }
            [class*="border-emerald-"] { border-color: var(--site-chrome) !important; }

            .bg-indigo-600 { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .hover\:bg-indigo-700:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }
            .focus\:ring-indigo-500:focus { --tw-ring-color: var(--site-chrome-mid) !important; }
            button.bg-gradient-to-r.from-indigo-600.to-violet-600 {
                background-image: linear-gradient(to right, #01041C, #152a52) !important;
                color: #ffffff !important;
            }
            button.bg-gradient-to-r.from-indigo-600.to-violet-600:hover {
                background-image: linear-gradient(to right, #152a52, #1e3a5c) !important;
            }

            .bg-blue-600 { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .hover\:bg-blue-700:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }

            .bg-aisd-ocean { background-color: var(--site-chrome) !important; color: #ffffff !important; }
            .border-aisd-ocean { border-color: var(--site-chrome) !important; }
            .hover\:bg-aisd-cobalt:hover { background-color: var(--site-chrome-mid) !important; color: #ffffff !important; }
            .hover\:border-aisd-cobalt:hover { border-color: var(--site-chrome-mid) !important; }

            header[role="banner"] nav {
                background-color: var(--site-chrome) !important;
                color: #f9fafb !important;
                box-shadow: 0 1px 0 rgba(255, 255, 255, 0.08) !important;
            }
            header[role="banner"] nav h1, header[role="banner"] nav h1[style*="#008236"] { color: #ffffff !important; }
            header[role="banner"] nav .text-gray-600 { color: #cbd5e1 !important; }
            header[role="banner"] nav .hidden.lg\:flex > a,
            header[role="banner"] nav .hidden.lg\:flex button.flex.items-center.gap-1 { color: #e5e7eb !important; }
            header[role="banner"] nav .hidden.lg\:flex .hover\:text-za-green-primary:hover { color: #ffffff !important; }
            header[role="banner"] nav .lg\:hidden button.text-gray-700 { color: #e5e7eb !important; }
            header[role="banner"] nav .lg\:hidden button.text-gray-700:hover {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: #ffffff !important;
            }

            header[role="banner"] nav .hidden.lg\:flex .absolute.left-0.mt-2.w-48.bg-white,
            header[role="banner"] nav .bg-white.rounded-lg.shadow-lg.border.border-gray-100 {
                background-color: var(--site-chrome-mid) !important;
                border-color: rgba(255, 255, 255, 0.15) !important;
            }
            header[role="banner"] nav .bg-white.rounded-lg a,
            header[role="banner"] nav .absolute.left-0.mt-2 a { color: #ffffff !important; }
            header[role="banner"] nav .bg-white.rounded-lg a:hover,
            header[role="banner"] nav .absolute.left-0.mt-2 a:hover {
                background-color: rgba(255, 255, 255, 0.12) !important;
                color: #ffffff !important;
            }

            header[role="banner"] .lg\:hidden.bg-white.border-t.border-gray-200.shadow-lg {
                background-color: var(--site-chrome) !important;
                border-color: rgba(255, 255, 255, 0.15) !important;
            }
            header[role="banner"] .lg\:hidden.border-t.border-gray-200 .text-gray-700 { color: #e5e7eb !important; }
            header[role="banner"] .lg\:hidden.border-t.border-gray-200 .hover\:bg-gray-100:hover {
                background-color: rgba(255, 255, 255, 0.08) !important;
            }

            #mobile-menu .bg-za-green-light { background-color: rgba(255, 255, 255, 0.12) !important; }
            #mobile-menu .text-za-green-primary { color: #ffffff !important; }
            #mobile-menu .hover\:bg-za-green-50:hover { background-color: rgba(255, 255, 255, 0.08) !important; }
            #mobile-menu .hover\:text-za-green-primary:hover { color: #ffffff !important; }
            #mobile-menu a.text-gray-600, #mobile-menu a.text-gray-700 { color: #e5e7eb !important; }
            #mobile-menu .hover\:bg-gray-100:hover { background-color: rgba(255, 255, 255, 0.08) !important; }
            a.intro-cta {
    background-color: #01041C !important;
    color: #ffffff !important;
}
a.intro-cta:hover {
    background-color: #152a52 !important;
    color: #ffffff !important;
}
        </style>

    </head>
    <body class="font-sans antialiased">
        @if(config('services.google_tag_manager.id'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google_tag_manager.id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif

        <a href="#main-content" 
           class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-za-green-primary focus:text-white focus:rounded-lg focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-za-yellow-accent">
            Skip to main content
        </a>

        <div style="margin: 0 !important; padding: 0 !important; min-height: 0;">
            @php
                $useZaitoonHeader = config('app.use_zaitoon_header', env('USE_ZAITOON_HEADER', true));
            @endphp
            @if($useZaitoonHeader)
                <x-header-zaitoon :transparent="request()->routeIs('home')" />
            @else
                <x-navbar :transparent="request()->routeIs('home')" />
            @endif
        </div>

        <div style="margin: 0 !important; padding: 0 !important; min-height: 0;">
            <main id="main-content" class="{{ request()->routeIs('home') ? '' : 'pt-16 lg:pt-20' }}" style="margin: 0 !important; padding: 0 !important; min-height: 0;">
                @yield('content')
            </main>
            <div class="relative" style="margin-top: 0;">
                @if($useZaitoonHeader)
                    <x-footer-zaitoon :showNewsletter="false" />
                @else
                    <x-footer />
                @endif
            </div>
        </div>

        <div id="lightbox-overlay" class="lightbox-overlay" style="display: none;">
            <div class="lightbox-container">
                <img id="lightbox-image" src="" alt="" />
                <button id="lightbox-close" class="lightbox-close">&times;</button>
                <div id="lightbox-counter" class="lightbox-counter"></div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.getElementById('lightbox-overlay');
                const image = document.getElementById('lightbox-image');
                const closeBtn = document.getElementById('lightbox-close');
                const counter = document.getElementById('lightbox-counter');
                let currentImages = [];
                let currentIndex = 0;

                document.querySelectorAll('a[data-lightbox]').forEach((link) => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const gallery = this.getAttribute('data-lightbox');
                        currentImages = Array.from(document.querySelectorAll(`a[data-lightbox="${gallery}"]`));
                        currentIndex = currentImages.indexOf(this);
                        image.src = this.href;
                        image.alt = this.getAttribute('data-title') || '';
                        if (currentImages.length > 1) {
                            counter.textContent = `${currentIndex + 1} of ${currentImages.length}`;
                            counter.style.display = 'block';
                        } else {
                            counter.style.display = 'none';
                        }
                        overlay.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    });
                });

                function hideLightbox() {
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                }

                function showNext() {
                    if (currentIndex < currentImages.length - 1) {
                        currentIndex++;
                        const nextLink = currentImages[currentIndex];
                        image.src = nextLink.href;
                        image.alt = nextLink.getAttribute('data-title') || '';
                        counter.textContent = `${currentIndex + 1} of ${currentImages.length}`;
                    }
                }

                function showPrev() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        const prevLink = currentImages[currentIndex];
                        image.src = prevLink.href;
                        image.alt = prevLink.getAttribute('data-title') || '';
                        counter.textContent = `${currentIndex + 1} of ${currentImages.length}`;
                    }
                }

                closeBtn.addEventListener('click', hideLightbox);
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) hideLightbox();
                });

                document.addEventListener('keydown', function(e) {
                    if (overlay.style.display !== 'flex') return;
                    switch (e.key) {
                        case 'Escape':
                            hideLightbox();
                            break;
                        case 'ArrowLeft':
                            showPrev();
                            break;
                        case 'ArrowRight':
                            showNext();
                            break;
                    }
                });
            });
        </script>

        @stack('scripts')
        @if($customJs ?? null)
            <script>{!! $customJs !!}</script>
        @endif
    </body>
</html>