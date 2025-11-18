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

        <!-- Favicon -->
        @if($faviconUrl)
            <link rel="icon" href="{{ $faviconUrl }}">
        @endif

        <!-- Open Graph / Facebook -->
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

        <!-- Twitter -->
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

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

        <!-- Theme Colors as CSS Variables -->
        <style>
            [x-cloak] {
                display: none !important;
            }
            :root {
                --color-primary: {{ $primaryColor }};
                --color-secondary: {{ $secondaryColor }};
                --color-accent: {{ $accentColor }};
            }
        </style>

        <!-- Custom CSS -->
        @if($customCss)
            <style>{!! $customCss !!}</style>
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Google Analytics -->
        @if($googleAnalyticsId)
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $googleAnalyticsId }}');
        </script>
        @elseif(config('services.google_analytics.id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.id') }}');
        </script>
        @endif

        <!-- Google Tag Manager -->
        @if(config('services.google_tag_manager.id'))
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('services.google_tag_manager.id') }}');</script>
        <!-- End Google Tag Manager -->
        @endif

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

        <noscript>
            @vite('resources/css/fallback.css')
        </noscript>
        
    </head>
    <body class="font-sans antialiased">
        @if(config('services.google_tag_manager.id'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google_tag_manager.id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        <div style="margin: 0 !important; padding: 0 !important; min-height: 0;">
            <x-header />

            <!-- Page Content -->
            <main id="main-content" style="margin: 0 !important; padding: 0 !important; min-height: 0;">
                @yield('content')
            </main>

            <x-footer />
        </div>
        
        <!-- Simple Vanilla JS Lightbox -->
        <div id="lightbox-overlay" class="lightbox-overlay" style="display: none;">
            <div class="lightbox-container">
                <img id="lightbox-image" src="" alt="" />
                <button id="lightbox-close" class="lightbox-close">&times;</button>
                <div id="lightbox-counter" class="lightbox-counter"></div>
            </div>
        </div>
        
        <script>
            // Simple Vanilla JS Lightbox Implementation
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.getElementById('lightbox-overlay');
                const image = document.getElementById('lightbox-image');
                const closeBtn = document.getElementById('lightbox-close');
                const counter = document.getElementById('lightbox-counter');
                
                let currentImages = [];
                let currentIndex = 0;
                
                // Find all lightbox links
                const lightboxLinks = document.querySelectorAll('a[data-lightbox]');
                
                lightboxLinks.forEach((link, index) => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Get all images in the same gallery
                        const gallery = this.getAttribute('data-lightbox');
                        currentImages = Array.from(document.querySelectorAll(`a[data-lightbox="${gallery}"]`));
                        currentIndex = currentImages.indexOf(this);
                        
                        showLightbox(this.href, this.getAttribute('data-title') || '');
                    });
                });
                
                function showLightbox(src, title) {
                    image.src = src;
                    image.alt = title;
                    updateCounter();
                    overlay.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
                
                function hideLightbox() {
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                }
                
                function updateCounter() {
                    if (currentImages.length > 1) {
                        counter.textContent = `${currentIndex + 1} of ${currentImages.length}`;
                        counter.style.display = 'block';
                    } else {
                        counter.style.display = 'none';
                    }
                }
                
                function showNext() {
                    if (currentIndex < currentImages.length - 1) {
                        currentIndex++;
                        const nextLink = currentImages[currentIndex];
                        showLightbox(nextLink.href, nextLink.getAttribute('data-title') || '');
                    }
                }
                
                function showPrev() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        const prevLink = currentImages[currentIndex];
                        showLightbox(prevLink.href, prevLink.getAttribute('data-title') || '');
                    }
                }
                
                // Event listeners
                closeBtn.addEventListener('click', hideLightbox);
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        hideLightbox();
                    }
                });
                
                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (overlay.style.display === 'flex') {
                        switch(e.key) {
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
                    }
                });
            });
        </script>
        
        @stack('scripts')
        
        <!-- Custom JavaScript -->
        @if($customJs ?? null)
            <script>{!! $customJs !!}</script>
        @endif
    </body>
</html>
