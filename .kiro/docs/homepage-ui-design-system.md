# Homepage UI Design System Analysis

## Overview
The homepage uses a **dual design system** approach:
1. **Zaitoon Academy Design** - Primary green/yellow Islamic school branding
2. **AISD Design System** - Professional blue/gold academic institution styling

---

## Design Systems

### 1. Zaitoon Academy Design System

**Brand Colors:**
```css
--za-green-primary: #1a5e4a    /* Primary green */
--za-green-dark: #0f3d30       /* Dark green */
--za-green-light: #e8f5f1      /* Light green background */
--za-yellow-accent: #fbbf24    /* Yellow accent/CTA */
--za-yellow-dark: #d97706      /* Hover yellow */
```

**Typography:**
- Headings: `'Playfair Display'` (serif) - Bold, elegant
- Body: `'Plus Jakarta Sans'` (sans-serif) - Modern, clean
- Letter spacing: Tight for headings (-0.02em)

**Key Components:**

#### Hero Section (Zaitoon)
- **Layout**: Split 50/50 - Text left, Image right
- **Background**: Dark green (#0f3d30)
- **Image Treatment**: Yellow curved shape with rotated image overlay
- **CTA Button**: Yellow accent with dark green text
- **Features**:
  - Carousel with 5s autoplay
  - Pause on hover
  - Navigation dots + arrows
  - WebP image support
  - Responsive: Stacks vertically on mobile

#### Service Cards
- **Grid**: 3 columns (responsive to 1 column mobile)
- **Colors**: Orange, Blue, Purple, Pink backgrounds
- **Style**: Rounded cards with white icon circles
- **Hover**: Scale 1.05 transform
- **Icons**: Heroicons outline style

#### Program Cards
- **Background**: White with shadow
- **Icon**: Colored square with rounded corners
- **Hover**: Shadow elevation
- **CTA**: Inline link with arrow

---

### 2. AISD Design System

**Brand Colors:**
```css
--aisd-midnight: #0F224C       /* Deep blue */
--aisd-ocean: #0C1B3D          /* Darker blue */
--aisd-cobalt: #192D5A         /* Medium blue */
--aisd-gold: #FCD34D           /* Gold accent */
--aisd-cream: #F8F5EB          /* Cream background */
--aisd-sky: #6EC1F5            /* Light blue */
```

**Key Components:**

#### News & Events Section
- **Layout**: Two-column grid (Events left, Notices right)
- **Background**: Light gradient (#f5f7fa to #e8ecf1)
- **Cards**: White with subtle border, rounded corners
- **Category Chips**: Color-coded by type
  - Academic: Green (#48BB78)
  - Social: Blue (#4299E1)
  - Islamic: Orange (#ED8936)
  - Sports: Red (#E53E3E)
- **Date Badges**: Inline with category
- **Hover**: Slight lift (-translate-y-1)

#### Advisors Section
- **Background**: Dark blue (#0B1533)
- **Cards**: Glass morphism (white/5 with backdrop blur)
- **Avatar**: Circular with decorative ring on hover
- **Text**: White on dark
- **Hover**: Scale and shadow effects
- **Social Icons**: Circular with white/10 background

#### Board Members Section
- **Background**: Slightly lighter blue (#1a1f3a)
- **Similar to Advisors** but with organization field
- **Blue accent** instead of gold

---

## Component Patterns

### Button Styles

#### Primary Button (AISD)
```css
.btn-aisd-primary {
  background: white;
  color: #192D5A;
  border: 2px solid #192D5A;
  border-radius: 9999px; /* Full rounded */
  padding: 0.75rem 1.5rem;
  min-height: 44px; /* Accessibility */
}
.btn-aisd-primary:hover {
  background: #192D5A;
  color: white;
}
```

#### Gold Button (AISD)
```css
.btn-aisd-gold {
  background: #FCD34D;
  color: #0C1B3D;
  border-radius: 9999px;
  padding: 1rem 1rem;
  min-height: 44px;
}
.btn-aisd-gold:hover {
  background: #ffdc5c;
  transform: scale(1.05);
}
```

#### Zaitoon CTA Button
```css
background: #fbbf24; /* Yellow */
color: #0f3d30; /* Dark green */
border-radius: 9999px;
padding: 1rem 2rem;
hover: scale(1.05) + shadow-lg
```

### Card Styles

#### AISD Card
```css
.card-aisd {
  background: white;
  border: 1px solid #D1D5DB;
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.card-aisd:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 25px rgba(0,0,0,0.15);
}
```

#### AISD Elevated Card
```css
.card-aisd-elevated {
  /* Same as card-aisd but with stronger hover */
  transform: translateY(-8px);
  box-shadow: 0 25px 50px rgba(0,0,0,0.25);
}
```

#### Glass Card (Advisors/Board)
```css
background: rgba(255,255,255,0.05);
border: 1px solid rgba(255,255,255,0.1);
backdrop-filter: blur(12px);
```

---

## Layout Patterns

### Section Structure
```html
<section class="py-16 lg:py-24 bg-{color}">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <p class="text-xs uppercase tracking-[0.5em]">Subtitle</p>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">Title</h2>
      <p class="text-base sm:text-lg text-gray-600">Description</p>
    </div>
    
    <!-- Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
      <!-- Cards -->
    </div>
  </div>
</section>
```

### Responsive Grid Breakpoints
- Mobile: 1 column
- Tablet (md): 2 columns
- Desktop (lg): 3-4 columns
- Gap: 1.5rem (mobile) → 2rem (desktop)

---

## Typography Scale

### Headings
```css
h1: 3rem (48px) → 5rem (80px) on desktop
h2: 1.875rem (30px) → 3rem (48px) on desktop
h3: 1.5rem (24px) → 2.25rem (36px) on desktop
h4: 1.25rem (20px) → 1.5rem (24px) on desktop
```

### Body Text
```css
Base: 1rem (16px)
Small: 0.875rem (14px)
Large: 1.125rem (18px)
```

### Line Heights
- Headings: 1.2 (tight)
- Body: 1.5-1.6 (relaxed)
- Descriptions: 1.75 (loose)

---

## Spacing System

### Section Padding
```css
Mobile: py-12 (3rem / 48px)
Tablet: py-16 (4rem / 64px)
Desktop: py-20 (5rem / 80px)
Large: py-24 (6rem / 96px)
```

### Container Padding
```css
Mobile: px-4 (1rem / 16px)
Tablet: px-6 (1.5rem / 24px)
Desktop: px-8 (2rem / 32px)
Large: px-12 (3rem / 48px)
```

### Gap Spacing
```css
Cards: gap-6 (1.5rem) → gap-8 (2rem) on desktop
Inline elements: gap-2 (0.5rem) → gap-4 (1rem)
```

---

## Shadow System

### Elevation Levels
```css
/* Card Default */
shadow-md: 0 4px 6px rgba(0,0,0,0.1)

/* Card Hover */
shadow-xl: 0 20px 25px rgba(0,0,0,0.15)

/* Elevated Card Hover */
shadow-2xl: 0 25px 50px rgba(0,0,0,0.25)

/* Soft Shadow (AISD) */
shadow-soft: 0 25px 50px -12px rgba(13,29,77,0.18)

/* Card Shadow (AISD) */
shadow-card: 0 18px 40px -15px rgba(9,20,45,0.2)
```

---

## Animation & Transitions

### Hover Effects
```css
/* Card Lift */
transition: all 0.3s ease;
hover: transform translateY(-4px);

/* Scale */
transition: transform 0.2s ease;
hover: transform scale(1.05);

/* Shadow Elevation */
transition: box-shadow 0.3s ease;
```

### Carousel (Hero)
```css
/* Slide Transition */
x-transition:enter="transition ease-out duration-500"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"

/* Autoplay: 5 seconds */
/* Pause on hover */
```

### Scroll Animations
```css
.scroll-fade-in {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}
.scroll-fade-in.visible {
  opacity: 1;
  transform: translateY(0);
}
```

---

## Icon System

### Icon Library
- **Heroicons** (outline and solid variants)
- Size: 1rem (16px) → 1.5rem (24px)
- Stroke width: 2px

### Icon Placement
- **Buttons**: Right side with ml-2 spacing
- **Cards**: Top with mb-4 spacing
- **Lists**: Left side with mr-2 spacing

---

## Accessibility Features

### Minimum Touch Targets
```css
min-height: 44px; /* All interactive elements */
min-width: 44px;
```

### Focus States
```css
focus:outline-none
focus:ring-2
focus:ring-offset-2
focus:ring-{color}
```

### Skip Links
```html
<a href="#main-content" class="sr-only focus:not-sr-only">
  Skip to main content
</a>
```

### ARIA Labels
- All buttons have aria-label
- Carousel has aria-selected states
- Images have descriptive alt text

---

## Responsive Breakpoints

```css
sm: 640px   /* Small tablets */
md: 768px   /* Tablets */
lg: 1024px  /* Laptops */
xl: 1280px  /* Desktops */
2xl: 1536px /* Large screens */
```

### Mobile-First Approach
- Base styles for mobile
- Progressive enhancement for larger screens
- Touch-friendly spacing (min 44px)

---

## Image Optimization

### WebP Support
```html
<picture>
  <source srcset="image.webp" type="image/webp">
  <img src="image.jpg" alt="Description">
</picture>
```

### Lazy Loading
```html
loading="lazy" /* For below-fold images */
loading="eager" /* For hero/above-fold */
```

### Responsive Images
```html
<!-- Conversions: thumb (300x300), medium (600x400), large (1920x1080) -->
```

---

## Performance Optimizations

### Caching Strategy
- Homepage data cached for 1 hour
- Cache key: `homepage_v2_data`
- Cleared on content updates via observers

### Asset Loading
- Vite for bundling
- CSS: Tailwind with purging
- JS: Alpine.js for interactivity
- Fonts: Google Fonts with preconnect

---

## Component Checklist

When creating new homepage sections:

- [ ] Use appropriate design system (Zaitoon or AISD)
- [ ] Follow responsive grid patterns
- [ ] Include hover states
- [ ] Add proper spacing (py-16 lg:py-24)
- [ ] Use semantic HTML
- [ ] Add ARIA labels
- [ ] Implement min-height: 44px for interactive elements
- [ ] Include loading states for images
- [ ] Add fallback images
- [ ] Test on mobile, tablet, desktop
- [ ] Verify color contrast (WCAG AA)
- [ ] Add smooth transitions
- [ ] Check cache invalidation

---

## Design Tokens Summary

### Zaitoon Tokens
```
Primary: #1a5e4a (Green)
Accent: #fbbf24 (Yellow)
Background: #e8f5f1 (Light Green)
Text: #0f3d30 (Dark Green)
```

### AISD Tokens
```
Primary: #0C1B3D (Ocean Blue)
Secondary: #192D5A (Cobalt)
Accent: #FCD34D (Gold)
Background: #f5f7fa (Light Gray)
Text: #0F224C (Midnight)
```

### Neutral Tokens
```
White: #ffffff
Gray-50: #F9FAFB
Gray-100: #F3F4F6
Gray-600: #4B5563
Gray-900: #111827
```
