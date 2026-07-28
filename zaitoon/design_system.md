# Zaitoon Academy Design System

## Color Palette

### Primary Colors
```
za-green-primary: #1a5e4a (Main brand green - deep forest green)
za-green-dark: #0f3d30 (Darker shade for headers, footers)
za-green-light: #e8f5f1 (Light backgrounds, subtle accents)
za-green-50: #f0fdf7
za-green-100: #d1fae5
za-green-200: #a7f3d0
za-green-300: #6ee7b7
za-green-400: #34d399
za-green-500: #10b981
za-green-600: #059669
za-green-700: #047857
za-green-800: #065f46
za-green-900: #064e3b
```

### Secondary Colors (Accent)
```
za-yellow-accent: #fbbf24 (CTA buttons, highlights)
za-yellow-light: #fef3c7 (Subtle backgrounds)
za-yellow-dark: #d97706 (Hover states)
```

### Neutral Colors
```
za-gray-50: #f9fafb
za-gray-100: #f3f4f6
za-gray-200: #e5e7eb
za-gray-300: #d1d5db
za-gray-500: #6b7280
za-gray-700: #374151
za-gray-900: #111827
```

### Utility Colors
```
za-white: #ffffff
za-black: #000000
za-blue-link: #2563eb (Links)
za-red-error: #dc2626 (Validation errors)
za-green-success: #16a34a (Success messages)
```

---

## Typography

### Font Families
**Primary (Sans-serif)**: 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif
**Headings (Serif)**: 'Playfair Display', 'Merriweather', Georgia, serif
**Monospace**: 'JetBrains Mono', 'Fira Code', monospace

### Font Sizes (Tailwind Scale)
```
text-xs: 0.75rem (12px)
text-sm: 0.875rem (14px)
text-base: 1rem (16px)
text-lg: 1.125rem (18px)
text-xl: 1.25rem (20px)
text-2xl: 1.5rem (24px)
text-3xl: 1.875rem (30px)
text-4xl: 2.25rem (36px)
text-5xl: 3rem (48px)
text-6xl: 3.75rem (60px)
text-7xl: 4.5rem (72px)
```

### Font Weights
```
font-light: 300
font-normal: 400
font-medium: 500
font-semibold: 600
font-bold: 700
font-extrabold: 800
```

### Line Heights
```
leading-tight: 1.25
leading-snug: 1.375
leading-normal: 1.5
leading-relaxed: 1.625
leading-loose: 2
```

### Typography Usage
- **H1 (Page Titles)**: text-4xl/text-5xl, font-serif, font-bold, leading-tight
- **H2 (Section Headers)**: text-3xl/text-4xl, font-serif, font-semibold, leading-snug
- **H3 (Subsections)**: text-2xl/text-3xl, font-sans, font-semibold, leading-normal
- **Body Text**: text-base/text-lg, font-sans, font-normal, leading-relaxed
- **Small Text**: text-sm, font-sans, font-normal, leading-normal
- **Button Text**: text-sm/text-base, font-sans, font-semibold, uppercase tracking-wide

---

## Spacing Scale

### Custom Spacing Values
```
spacing: {
  '18': '4.5rem',
  '22': '5.5rem',
  '26': '6.5rem',
  '30': '7.5rem',
  '34': '8.5rem',
  '88': '22rem',
  '100': '25rem',
  '112': '28rem',
  '128': '32rem',
}
```

### Container Max-Widths
```
sm: 640px
md: 768px
lg: 1024px
xl: 1280px
2xl: 1536px
custom-container: 1320px (Zaitoon's max content width)
```

### Common Spacing Patterns
- **Section Padding (Y)**: py-12 (mobile), py-16 (tablet), py-20/py-24 (desktop)
- **Section Padding (X)**: px-4 (mobile), px-6 (tablet), px-8 (desktop)
- **Card Padding**: p-6 (mobile), p-8 (desktop)
- **Gap Between Elements**: gap-4 (mobile), gap-6 (tablet), gap-8 (desktop)

---

## Breakpoints

### Tailwind Breakpoints
```
sm: 640px (Small devices - landscape phones)
md: 768px (Tablets)
lg: 1024px (Laptops)
xl: 1280px (Desktops)
2xl: 1536px (Large screens)
```

### Custom Breakpoints (if needed)
```
xs: 480px (Extra small - small phones)
3xl: 1920px (Ultra-wide screens)
```

---

## Border Radius

### Standard Radii
```
rounded-sm: 0.125rem (2px)
rounded: 0.25rem (4px)
rounded-md: 0.375rem (6px)
rounded-lg: 0.5rem (8px)
rounded-xl: 0.75rem (12px)
rounded-2xl: 1rem (16px)
rounded-3xl: 1.5rem (24px)
rounded-full: 9999px
```

### Component Usage
- **Buttons**: rounded-lg or rounded-full
- **Cards**: rounded-xl or rounded-2xl
- **Input Fields**: rounded-lg
- **Badges**: rounded-full
- **Modals**: rounded-2xl

---

## Shadows

### Standard Shadows
```
shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05)
shadow: 0 1px 3px rgba(0, 0, 0, 0.1)
shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1)
shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1)
shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1)
shadow-2xl: 0 25px 50px rgba(0, 0, 0, 0.25)
```

### Custom Shadows (if needed)
```
shadow-green: 0 10px 30px rgba(26, 94, 74, 0.15)
shadow-yellow: 0 10px 30px rgba(251, 191, 36, 0.15)
```

---

## Animations & Transitions

### Transition Durations
```
duration-75: 75ms
duration-100: 100ms
duration-150: 150ms
duration-200: 200ms
duration-300: 300ms
duration-500: 500ms
duration-700: 700ms
duration-1000: 1000ms
```

### Transition Timing Functions
```
ease-linear
ease-in
ease-out
ease-in-out
```

### Common Animation Patterns
- **Hover Scale**: `transition-transform duration-300 hover:scale-105`
- **Fade In**: `transition-opacity duration-500 opacity-0 → opacity-100`
- **Slide Up**: `transition-transform duration-500 translate-y-10 → translate-y-0`
- **Button Hover**: `transition-all duration-200 hover:bg-{color} hover:scale-105`

### Custom Animations
```css
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(-30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
```

---

## Component Patterns

### Buttons

#### Primary Button (CTA)
```html
<button class="bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold px-6 py-3 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
  Apply Now
</button>
```

#### Secondary Button (Outline)
```html
<button class="border-2 border-za-green-primary text-za-green-primary hover:bg-za-green-primary hover:text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-300">
  Learn More
</button>
```

### Cards

#### Feature Card
```html
<div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 group">
  <div class="w-16 h-16 bg-za-green-light rounded-full flex items-center justify-center mb-6 group-hover:bg-za-green-primary transition-colors">
    <svg class="w-8 h-8 text-za-green-primary group-hover:text-white transition-colors">...</svg>
  </div>
  <h3 class="text-xl font-bold text-gray-900 mb-3">Card Title</h3>
  <p class="text-gray-600 leading-relaxed">Card description text...</p>
</div>
```

### Section Layout

#### Standard Section
```html
<section class="py-16 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-serif font-bold text-za-green-primary mb-4">Section Title</h2>
      <p class="text-lg text-gray-600 max-w-3xl mx-auto">Section description</p>
    </div>
    <!-- Content -->
  </div>
</section>
```

---

## Accessibility Guidelines

### Color Contrast
- **Body Text on White**: Must be ≥4.5:1 (WCAG AA) - za-gray-700 or darker
- **Large Text on White**: Must be ≥3:1 - za-gray-600 or darker
- **White Text on Green**: Use za-green-700 or darker backgrounds
- **Yellow Accents**: Ensure sufficient contrast (avoid yellow text on white)

### Interactive Elements
- **Focus States**: Always include visible focus indicators (ring-2 ring-za-green-500)
- **Touch Targets**: Minimum 44x44px for mobile
- **Hover States**: Should not be the only way to access functionality

### Motion & Animation
- **Respect `prefers-reduced-motion`**: Disable animations for users with motion sensitivity
- **Non-essential Animations**: Can be disabled without losing functionality

---

## Best Practices

1. **Consistency**: Use design tokens consistently across all components
2. **Hierarchy**: Establish clear visual hierarchy with typography and spacing
3. **Whitespace**: Don't be afraid of whitespace - it improves readability
4. **Responsive**: Design mobile-first, then enhance for larger screens
5. **Performance**: Optimize images, lazy load below-fold content
6. **Accessibility**: Always test with keyboard navigation and screen readers

---

**Document Version**: 1.0  
**Last Updated**: 2025-11-22  
**Maintained By**: Development Team
