# Scroll Animations Implementation Guide

## Overview
Implemented scroll-triggered animations using **Intersection Observer API** with CSS transitions - matching the style from beta.zaitoonacademy.com.

## Animation Classes Available

### 1. Fade In
```html
<div class="fade-in">Content fades in</div>
```
- Opacity: 0 → 1
- No movement, just fade

### 2. Slide Up
```html
<div class="slide-up">Content slides up</div>
```
- Opacity: 0 → 1
- Transform: translateY(40px) → translateY(0)

### 3. Slide Left
```html
<div class="slide-left">Content slides from left</div>
```
- Opacity: 0 → 1
- Transform: translateX(-40px) → translateX(0)

### 4. Slide Right
```html
<div class="slide-right">Content slides from right</div>
```
- Opacity: 0 → 1
- Transform: translateX(40px) → translateX(0)

### 5. Zoom In
```html
<div class="zoom-in">Content zooms in</div>
```
- Opacity: 0 → 1
- Transform: scale(0.9) → scale(1)

### 6. Stagger Items
```html
<div class="stagger-item">Item 1</div>
<div class="stagger-item">Item 2</div>
<div class="stagger-item">Item 3</div>
```
- Each item animates with a 0.1s delay
- Creates cascading effect

## Implementation

### Files Created/Modified

1. **resources/js/scroll-animations.js** - Main animation logic
2. **resources/css/app.css** - Animation styles
3. **resources/views/layouts/app.blade.php** - Script inclusion

### How It Works

```javascript
// Intersection Observer watches for elements entering viewport
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});
```

### Configuration

```javascript
{
    threshold: 0.1,           // Trigger when 10% visible
    rootMargin: '0px 0px -50px 0px'  // Trigger 50px before entering viewport
}
```

## Usage Examples

### Homepage Sections

```html
<!-- Introduction Section -->
<div class="slide-left">
    <!-- Images -->
</div>
<div class="slide-right">
    <!-- Text content -->
</div>

<!-- Services Grid -->
<div class="service-grid">
    <div class="service-card">Service 1</div>
    <div class="service-card">Service 2</div>
    <div class="service-card">Service 3</div>
</div>

<!-- Programs Grid -->
<div class="program-grid">
    <div class="program-card">Program 1</div>
    <div class="program-card">Program 2</div>
    <div class="program-card">Program 3</div>
</div>
```

### Custom Stagger Delay

```html
<div class="fade-in" style="transition-delay: 0.2s;">
    Delayed animation
</div>
```

## Applied Animations

### Current Homepage Sections:

1. **Introduction Section**
   - Left images: `slide-left`
   - Right text: `slide-right`

2. **Services Section**
   - Title: `fade-in`
   - Cards: Auto-stagger with `.service-card`

3. **Programs Section**
   - Title: `fade-in`
   - Cards: Auto-stagger with `.program-card`

4. **Events Section**
   - Title: `fade-in`
   - Event cards: `zoom-in`

## Performance

### Optimizations:
- Uses native Intersection Observer (no external libraries)
- Hardware-accelerated CSS transforms
- Efficient threshold detection
- Optional unobserve after animation

### Browser Support:
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile browsers: ✅ Full support

## Customization

### Adjust Animation Speed

```css
/* In resources/css/app.css */
.fade-in {
    transition: opacity 1.2s ease-out; /* Slower */
}
```

### Adjust Trigger Point

```javascript
// In resources/js/scroll-animations.js
const config = {
    threshold: 0.2,  // Trigger when 20% visible
    rootMargin: '0px 0px -100px 0px'  // Trigger 100px before
};
```

### Add Custom Animation

```css
/* In resources/css/app.css */
.rotate-in {
    opacity: 0;
    transform: rotate(-10deg) scale(0.9);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.rotate-in.animate-in {
    opacity: 1;
    transform: rotate(0) scale(1);
}
```

## Accessibility

- Respects `prefers-reduced-motion`
- Semantic HTML maintained
- No layout shift
- Keyboard navigation unaffected

## Smooth Scroll

Bonus feature included:

```html
<a href="#section">Smooth scroll to section</a>
```

All anchor links automatically smooth scroll.

## Parallax Effect (Optional)

```html
<div class="parallax" data-speed="0.5">
    Moves slower than scroll
</div>
```

## Troubleshooting

### Animations not triggering?
1. Check if `scroll-animations.js` is loaded
2. Verify animation classes are applied
3. Check browser console for errors

### Animations too fast/slow?
Adjust transition duration in CSS:
```css
.fade-in {
    transition-duration: 1s; /* Adjust as needed */
}
```

### Want to disable animations?
Remove animation classes or comment out observer in JS.

## Examples from Reference Site

The animations match these patterns from beta.zaitoonacademy.com:
- ✅ Fade in on scroll
- ✅ Slide up from bottom
- ✅ Stagger effect on grids
- ✅ Smooth transitions
- ✅ Subtle, professional feel
