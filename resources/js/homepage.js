/**
 * Modern Homepage Interactive Features
 * Implements animations, accessibility, and performance optimizations
 */

(function() {
    'use strict';

    // Check if reduced motion is preferred
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * Intersection Observer for subtle fade-in animations with stagger
     */
    function initScrollAnimations() {
        if (prefersReducedMotion) return;

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    entry.target.classList.remove('scroll-fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe sections with scroll-fade-in class
        document.querySelectorAll('.scroll-fade-in').forEach(element => {
            observer.observe(element);
        });

        // Observe stagger items individually for proper animation
        document.querySelectorAll('.stagger-item').forEach((item, index) => {
            const itemObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const delay = index * 100;
                        setTimeout(() => {
                            entry.target.classList.add('visible');
                        }, delay);
                        itemObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            itemObserver.observe(item);
        });

        // Also observe sections that are below viewport on load
        setTimeout(() => {
            const viewportHeight = window.innerHeight;
            
            document.querySelectorAll('section').forEach((section) => {
                const rect = section.getBoundingClientRect();
                if (rect.top > viewportHeight && !section.classList.contains('scroll-fade-in')) {
                    section.classList.add('scroll-fade-in');
                    observer.observe(section);
                }
            });
        }, 100);
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
            } else {
                header.classList.remove('scrolled');
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

