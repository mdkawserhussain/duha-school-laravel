{{-- Scroll Reveal Directive for Alpine.js --}}
{{-- Add this to your main JavaScript file or include inline --}}

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    // Scroll reveal animations
    Alpine.directive('scroll-reveal', (el, { expression }, { evaluate }) => {
        const options = expression ? evaluate(expression) : {};
        
        const defaultOptions = {
            animation: 'fade-up',
            delay: 0,
            duration: 500,
            once: true,
            ...options
        };
        
        // Animation classes
        const animations = {
            'fade-up': {
                initial: 'opacity-0 translate-y-8',
                animate: 'opacity-100 translate-y-0'
            },
            'fade-down': {
                initial: 'opacity-0 -translate-y-8',
                animate: 'opacity-100 translate-y-0'
            },
            'fade-left': {
                initial: 'opacity-0 translate-x-8',
                animate: 'opacity-100 translate-x-0'
            },
            'fade-right': {
                initial: 'opacity-0 -translate-x-8',
                animate: 'opacity-100 translate-x-0'
            },
            'fade': {
                initial: 'opacity-0',
                animate: 'opacity-100'
            },
            'zoom-in': {
                initial: 'opacity-0 scale-95',
                animate: 'opacity-100 scale-100'
            },
            'zoom-out': {
                initial: 'opacity-0 scale-105',
                animate: 'opacity-100 scale-100'
            }
        };
        
        const anim = animations[defaultOptions.animation] || animations['fade-up'];
        
        // Apply initial state
        el.classList.add('transition-all', ...anim.initial.split(' '));
        el.style.transitionDuration = `${defaultOptions.duration}ms`;
        el.style.transitionDelay = `${defaultOptions.delay}ms`;
        
        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Remove initial classes and add animate classes
                    setTimeout(() => {
                        anim.initial.split(' ').forEach(cls => el.classList.remove(cls));
                        anim.animate.split(' ').forEach(cls => el.classList.add(cls));
                    }, 10);
                    
                    if (defaultOptions.once) {
                        observer.unobserve(el);
                    }
                } else if (!defaultOptions.once) {
                    // Reset animation if not 'once'
                    anim.animate.split(' ').forEach(cls => el.classList.remove(cls));
                    anim.initial.split(' ').forEach(cls => el.classList.add(cls));
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        observer.observe(el);
    });
    
    // Parallax directive
    Alpine.directive('parallax', (el, { expression }, { evaluate }) => {
        const options = expression ? evaluate(expression) : {};
        const speed = options.speed || 0.5;
        
        function updateParallax() {
            const rect = el.getBoundingClientRect();
            const scrolled = window.pageYOffset;
            const elementTop = rect.top + scrolled;
            const elementHeight = rect.height;
            const windowHeight = window.innerHeight;
            
            if (scrolled + windowHeight > elementTop && scrolled < elementTop + elementHeight) {
                const yPos = (scrolled - elementTop) * speed;
                el.style.transform = `translateY(${yPos}px)`;
            }
        }
        
        window.addEventListener('scroll', updateParallax, { passive: true });
        updateParallax();
    });
    
    // Stagger children directive
    Alpine.directive('stagger', (el, { expression }, { evaluate }) => {
        const delay = expression ? parseInt(evaluate(expression)) : 100;
        const children = el.children;
        
        Array.from(children).forEach((child, index) => {
            child.style.transitionDelay = `${index * delay}ms`;
        });
    });
});
</script>
@endpush

{{-- Usage Examples:

<!-- Fade up on scroll -->
<div x-scroll-reveal>Content</div>

<!-- Fade down with custom duration -->
<div x-scroll-reveal="{ animation: 'fade-down', duration: 700 }">Content</div>

<!-- Zoom in with delay -->
<div x-scroll-reveal="{ animation: 'zoom-in', delay: 200 }">Content</div>

<!-- Parallax effect -->
<div x-parallax="{ speed: 0.3 }">Background</div>

<!-- Stagger children animations -->
<div x-stagger="150" class="grid grid-cols-3 gap-4">
    <div class="transition-all">Item 1</div>
    <div class="transition-all">Item 2</div>
    <div class="transition-all">Item 3</div>
</div>

--}}
