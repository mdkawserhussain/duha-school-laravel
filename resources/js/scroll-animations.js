/**
 * Scroll Animations using Intersection Observer API
 * Matches the animation style from beta.zaitoonacademy.com
 */

document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const config = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    // Create Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                // Optional: unobserve after animation to improve performance
                // observer.unobserve(entry.target);
            }
        });
    }, config);

    // Observe all elements with animation classes
    const animatedElements = document.querySelectorAll(
        '.fade-in, .slide-up, .slide-left, .slide-right, .zoom-in, .stagger-item'
    );

    animatedElements.forEach((el, index) => {
        // Add stagger delay for items in the same container
        if (el.classList.contains('stagger-item')) {
            el.style.transitionDelay = `${index * 0.1}s`;
        }
        observer.observe(el);
    });

    // Special handling for card grids (stagger animation)
    const cardContainers = document.querySelectorAll('.card-grid, .service-grid, .program-grid');
    cardContainers.forEach(container => {
        const cards = container.querySelectorAll('.card, .service-card, .program-card');
        cards.forEach((card, index) => {
            card.classList.add('fade-in');
            card.style.transitionDelay = `${index * 0.15}s`;
            observer.observe(card);
        });
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '#!') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Parallax effect for hero section (optional)
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.parallax');
    
    parallaxElements.forEach(el => {
        const speed = el.dataset.speed || 0.5;
        el.style.transform = `translateY(${scrolled * speed}px)`;
    });
});
