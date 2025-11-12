/**
 * Modern Homepage Interactive Features
 * Implements animations, accessibility, and performance optimizations
 */

(function() {
    'use strict';

    // Check if reduced motion is preferred
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * Intersection Observer for subtle fade-in animations
     * Disabled by default to prevent flickering - can be enabled if needed
     */
    function initScrollAnimations() {
        // Disabled to prevent flickering - elements remain visible
        // Uncomment below to enable subtle animations (only for elements below viewport)
        return;
        
        /*
        if (prefersReducedMotion) return;

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Wait for page to be fully loaded before checking positions
        setTimeout(() => {
            const viewportHeight = window.innerHeight;
            
            document.querySelectorAll('section').forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top > viewportHeight + 100) {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(20px)';
                    section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                    observer.observe(section);
                }
            });
        }, 100);
        */
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: prefersReducedMotion ? 'auto' : 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Header scroll effect
     */
    function initHeaderScroll() {
        const header = document.querySelector('header');
        if (!header) return;

        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                header.classList.add('scrolled');
                header.style.background = 'rgba(30, 58, 138, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.classList.remove('scrolled');
                header.style.background = '';
                header.style.backdropFilter = '';
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Lazy load images
     */
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading supported
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
            });
        } else {
            // Fallback for browsers without native lazy loading
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Keyboard navigation enhancements
     */
    function initKeyboardNavigation() {
        // Skip to main content link
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.className = 'sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded-lg';
        if (document.body.firstChild) {
            document.body.insertBefore(skipLink, document.body.firstChild);
        } else {
            document.body.appendChild(skipLink);
        }

        // Enhanced focus management
        document.addEventListener('keydown', (e) => {
            // Tab navigation enhancement
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    }

    /**
     * Initialize all features
     */
    function init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }

        initScrollAnimations();
        initSmoothScroll();
        initHeaderScroll();
        initLazyLoading();
        initKeyboardNavigation();

        // Add loaded class to body
        document.body.classList.add('homepage-loaded');
    }

    // Initialize
    init();

    // Export for external use if needed
    window.HomepageEnhancements = {
        initScrollAnimations,
        initSmoothScroll,
        initHeaderScroll,
        initLazyLoading,
        initKeyboardNavigation
    };
})();

