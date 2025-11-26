# Zaitoon Academy - Component Inventory

## Component Hierarchy (Atomic Design)

This document categorizes all UI components using **Atomic Design** methodology:
- **Atoms**: Basic building blocks (buttons, inputs, icons)
- **Molecules**: Groups of atoms (cards, form fields)
- **Organisms**: Complex UI sections (header, footer, hero)
- **Templates**: Page-level layouts
- **Pages**: Specific instances of templates

---

## 🔹 ATOMS (Basic Building Blocks)

### 1. Buttons

#### Primary Button (CTA)
**File**: `resources/views/components/atoms/button-primary.blade.php`
```html
@props(['href' => null, 'type' => 'button', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    $classes = 'bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-za-yellow inline-flex items-center justify-center ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
```

**Props**:
- `href` (optional): URL for link button
- `type`: button|submit|reset (default: button)
- `size`: sm|md|lg (default: md)

**Usage**:
```html
<x-atoms.button-primary href="/admission">Apply Now</x-atoms.button-primary>
```

---

#### Secondary Button (Outline)
**File**: `resources/views/components/atoms/button-secondary.blade.php`
```html
@props(['href' => null, 'type' => 'button', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    $classes = 'border-2 border-za-green-primary text-za-green-primary hover:bg-za-green-primary hover:text-white font-semibold rounded-lg transition-colors duration-300 inline-flex items-center justify-center ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
```

---

### 2. Form Inputs

#### Text Input
**File**: `resources/views/components/atoms/input.blade.php`
**Props**: name, type, label, placeholder, required, value
**Alpine.js**: ❌ No
**Features**: Error state, helper text, icon support

#### Textarea
**File**: `resources/views/components/atoms/textarea.blade.php`
**Props**: name, label, rows, placeholder, required
**Alpine.js**: ❌ No

#### Select Dropdown
**File**: `resources/views/components/atoms/select.blade.php`
**Props**: name, label, options, required
**Alpine.js**: ✅ Yes (for custom styling)

---

### 3. Typography

#### Heading
**File**: `resources/views/components/atoms/heading.blade.php`
**Props**: level (h1-h6), serif (boolean), color
**Usage**:
```html
<x-atoms.heading level="h2" :serif="true" color="za-green-primary">
    Section Title
</x-atoms.heading>
```

#### Paragraph
**File**: `resources/views/components/atoms/paragraph.blade.php`
**Props**: size (sm, base, lg), color

---

### 4. Icons & Graphics

#### Icon Wrapper
**File**: `resources/views/components/atoms/icon.blade.php`
**Props**: name, size, color
**Implementation**: Support for Heroicons, custom SVGs

#### Badge
**File**: `resources/views/components/atoms/badge.blade.php`
**Props**: variant (primary, secondary, success, warning, error), size
**Usage**: Date badges, category tags

---

### 5. Media Elements

#### Image with Lazy Loading
**File**: `resources/views/components/atoms/image.blade.php`
**Props**: src, alt, lazy (boolean), aspectRatio, objectFit
**Features**: WebP support, srcset for responsive, blur placeholder

#### Video Player
**File**: `resources/views/components/atoms/video.blade.php`
**Props**: src, poster, autoplay, muted, loop, controls
**Alpine.js**: ✅ Yes (for custom controls)

---

## 🔸 MOLECULES (Composed Components)

### 1. Feature Card
**File**: `resources/views/components/molecules/feature-card.blade.php`

**Structure**:
- Icon container (with background circle)
- Heading (h3)
- Description (p)
- Optional CTA link

**Props**:
- `icon`: SVG icon content
- `title`: Card heading
- `description`: Card text
- `link`: Optional URL
- `linkText`: CTA text

**Alpine.js**: ❌ No (pure CSS hover effects)

**Usage**:
```html
<x-molecules.feature-card 
    icon="<svg>...</svg>"
    title="Islamic & Modern Curriculum"
    description="A balanced education system..."
    link="/academics"
    linkText="Learn More"
/>
```

---

### 2. Testimonial Card
**File**: `resources/views/components/molecules/testimonial-card.blade.php`

**Structure**:
- Quote icon
- Testimonial text
- Author avatar
- Author name & title
- Star rating

**Props**:
- `quote`: Testimonial text
- `author`: Name
- `role`: Author's role/title
- `avatar`: Image URL
- `rating`: 1-5 stars

**Alpine.js**: ❌ No

---

### 3. News/Event Card
**File**: `resources/views/components/molecules/event-card.blade.php`

**Structure**:
- Featured image
- Date badge (overlay)
- Category badge
- Title
- Excerpt
- Read more link

**Props**:
- `image`: Cover image URL
- `date`: Event date
- `category`: Event category
- `title`: Event title
- `excerpt`: Short description
- `link`: Event detail URL

**Alpine.js**: ❌ No

---

### 4. Stat Counter
**File**: `resources/views/components/molecules/stat-counter.blade.php`

**Structure**:
- Large number (animated count-up)
- Label/description
- Optional icon

**Props**:
- `value`: Target number
- `label`: Stat description
- `suffix`: Optional (e.g., "+", "K", "M")
- `icon`: Optional icon

**Alpine.js**: ✅ Yes (count-up animation with Intersection Observer)

**Implementation**:
```javascript
x-data="{
    count: 0,
    target: {{ $value }},
    increment() {
        const duration = 2000; // 2 seconds
        const steps = 60;
        const stepValue = this.target / steps;
        const interval = duration / steps;
        
        const counter = setInterval(() => {
            this.count += stepValue;
            if (this.count >= this.target) {
                this.count = this.target;
                clearInterval(counter);
            }
        }, interval);
    }
}"
x-intersect.once="increment()"
```

---

### 5. Form Group
**File**: `resources/views/components/molecules/form-group.blade.php`

**Structure**:
- Label
- Input/Textarea/Select
- Error message
- Helper text

**Props**:
- `label`: Field label
- `name`: Input name
- `type`: Input type
- `error`: Error message
- `help`: Helper text

**Alpine.js**: ✅ Yes (validation state)

---

### 6. Social Share Buttons
**File**: `resources/views/components/molecules/social-share.blade.php`

**Structure**:
- Share label
- Icon buttons (Facebook, Twitter, LinkedIn, WhatsApp)

**Props**:
- `url`: URL to share
- `title`: Page title
- `platforms`: Array of platforms

**Alpine.js**: ❌ No

---

## 🔷 ORGANISMS (Complex UI Sections)

### 1. Header/Navigation
**File**: `resources/views/components/organisms/header.blade.php`

**Structure**:
- Logo
- Primary navigation (mega-menu support)
- CTA button
- Mobile menu toggle
- Search bar (optional)
- Language switcher (optional)

**Props**:
- `transparent`: Boolean for transparent header
- `sticky`: Boolean for sticky behavior

**Alpine.js**: ✅ Yes (extensive)
- Mobile menu state
- Dropdown menus
- Scroll behavior
- Search overlay

**State Management**:
```javascript
{
    mobileMenuOpen: false,
    searchOpen: false,
    scrolled: false,
    activeDropdown: null,
    
    toggleMobileMenu() { ... },
    openDropdown(id) { ... },
    closeAllDropdowns() { ... }
}
```

**Sub-components**:
- `organisms/header/desktop-nav.blade.php`
- `organisms/header/mobile-menu.blade.php`
- `organisms/header/mega-menu.blade.php`

---

### 2. Footer
**File**: `resources/views/components/organisms/footer.blade.php`

**Structure**:
- 4 columns: About, Quick Links, Contact, Office Hours
- Newsletter signup form
- Social media links
- Copyright notice
- Back to top button

**Props**:
- None (pulls from settings/database)

**Alpine.js**: ✅ Yes (newsletter form, back-to-top button)

**Features**:
- Wavy top border (SVG)
- Sticky back-to-top button
- Newsletter AJAX submission

---

### 3. Hero Slider
**File**: `resources/views/components/organisms/hero-slider.blade.php`

**Structure**:
- Multiple slides with background images
- Text overlay (heading, description, CTAs)
- Navigation arrows
- Pagination dots
- Auto-play controls

**Props**:
- `slides`: Array of slide data
  - `image`: Background image
  - `heading`: Main heading
  - `subheading`: Subtitle
  - `description`: Body text
  - `ctaPrimary`: Primary button data
  - `ctaSecondary`: Secondary button data

**Alpine.js**: ✅ Yes (slider logic)

**Dependencies**: Swiper.js (optional) or pure Alpine.js

**State Management**:
```javascript
{
    currentSlide: 0,
    totalSlides: {{ count($slides) }},
    autoplayInterval: null,
    
    nextSlide() { ... },
    prevSlide() { ... },
    goToSlide(index) { ... },
    startAutoplay() { ... },
    stopAutoplay() { ... }
}
```

---

### 4. Feature Grid Section
**File**: `resources/views/components/organisms/feature-grid.blade.php`

**Structure**:
- Section heading
- Description text
- Grid of feature cards (2-4 columns responsive)
- Optional CTA at bottom

**Props**:
- `heading`: Section title
- `description`: Section intro text
- `features`: Array of feature data
- `columns`: 2|3|4 (default: 3)

**Alpine.js**: ✅ Yes (scroll reveal animation)

**Slots**:
- `heading`: Custom heading markup
- `default`: Feature cards

---

### 5. Testimonial Slider
**File**: `resources/views/components/organisms/testimonial-slider.blade.php`

**Structure**:
- Section heading
- Carousel of testimonial cards
- Navigation controls
- Auto-rotation

**Props**:
- `testimonials`: Array of testimonial data
- `autoplay`: Boolean (default: true)
- `interval`: Auto-play interval in ms (default: 5000)

**Alpine.js**: ✅ Yes (carousel logic)

---

### 6. Newsletter Signup Section
**File**: `resources/views/components/organisms/newsletter-section.blade.php`

**Structure**:
- Heading & description
- Email input with submit button (inline form)
- Success/error messages
- GDPR checkbox

**Props**:
- `heading`: Section title
- `description`: Subtitle
- `buttonText`: Submit button text

**Alpine.js**: ✅ Yes (form submission, validation, success state)

**Backend Integration**:
- Route: `POST /newsletter/subscribe`
- Controller: `NewsletterController@subscribe`
- Validation: Email, unique, rate limiting

---

### 7. Contact Form
**File**: `resources/views/components/organisms/contact-form.blade.php`

**Structure**:
- Name, Email, Subject, Message fields
- reCAPTCHA
- Submit button
- Success/error messages

**Props**:
- `heading`: Form title
- `showMap`: Boolean to show Google Maps embed

**Alpine.js**: ✅ Yes (validation, AJAX submission)

**Backend Integration**:
- Route: `POST /contact`
- Controller: `ContactController@submit`
- Features: Email notification, DB storage, spam protection

---

### 8. Announcement Bar (Ticker)
**File**: `resources/views/components/organisms/announcement-bar.blade.php`

**Structure**:
- Fixed position bar (top of page)
- Scrolling text/news items
- Close button with localStorage

**Props**:
- `announcements`: Array of announcement data
- `dismissible`: Boolean (default: true)

**Alpine.js**: ✅ Yes (marquee animation, dismiss state)

**CSS Animation**:
```css
@keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
```

---

## 📐 TEMPLATES (Page Layouts)

### 1. Master Layout
**File**: `resources/views/layouts/app.blade.php`

**Structure**:
- `<head>` with meta tags, fonts, CSS
- Header component
- Main content area (`@yield('content')`)
- Footer component
- Scripts, Alpine.js, analytics

**Sections**:
- `@section('title')`: Page title
- `@section('meta')`: Additional meta tags
- `@section('content')`: Main content
- `@push('scripts')`: Page-specific scripts
- `@push('styles')`: Page-specific styles

---

### 2. Full-Width Section Template
**File**: `resources/views/components/templates/section.blade.php`

**Props**:
- `bgColor`: Background color class
- `bgImage`: Background image URL
- `bgGradient`: Gradient class
- `padding`: Padding size (sm, md, lg, xl)
- `containerWidth`: max-w-* class

**Usage**:
```html
<x-templates.section bgColor="bg-white" padding="lg">
    <x-slot name="heading">
        <x-atoms.heading level="h2" :serif="true">Section Title</x-atoms.heading>
    </x-slot>
    
    <!-- Content -->
</x-templates.section>
```

---

### 3. Two-Column Layout
**File**: `resources/views/components/templates/two-column.blade.php`

**Props**:
- `reverse`: Boolean (image on right?)
- `imageRatio`: Aspect ratio for image
- `vAlign`: Vertical alignment (start, center, end)

**Slots**:
- `image`: Image content
- `content`: Text/CTA content

---

## 📄 PAGES (Specific Instances)

### Homepage Components
Based on Zaitoon Academy analysis:

1. **Hero Slider** (`organisms/hero-slider`)
2. **Announcement Ticker** (`organisms/announcement-bar`)
3. **Features Grid** - "Why Choose Us" section
4. **Stats Counter Section** - School statistics
5. **Image + Text Sections** - About/Mission alternating
6. **Testimonials Slider**
7. **Latest Events Grid**
8. **Newsletter Signup**
9. **CTA Section** - "Enroll Today" banner

---

## 🎯 Alpine.js Integration Map

### Components Requiring Alpine.js

| Component | State Variables | Key Functions | Events Dispatched |
|-----------|----------------|---------------|-------------------|
| **Header** | `mobileMenuOpen`, `scrolled`, `activeDropdown` | `toggleMenu()`, `openDropdown()` | `menu-toggled` |
| **Hero Slider** | `currentSlide`, `autoplayInterval` | `nextSlide()`, `prevSlide()`, `startAutoplay()` | `slide-changed` |
| **Stat Counter** | `count`, `target` | `increment()` | None |
| **Newsletter Form** | `email`, `loading`, `success`, `error` | `submit()`, `validate()` | `newsletter-subscribed` |
| **Contact Form** | `formData`, `loading`, `errors` | `submit()`, `validate()` | `contact-submitted` |
| **Modal** | `open` | `openModal()`, `closeModal()` | `modal-opened`, `modal-closed` |
| **Tabs** | `activeTab` | `switchTab(index)` | `tab-changed` |
| **Accordion** | `openItems` (array) | `toggle(id)` | None |
| **Lightbox** | `isOpen`, `currentImage` | `open()`, `close()`, `next()`, `prev()` | None |
| **Search Overlay** | `query`, `results`, `loading` | `search()`, `clear()` | `search-performed` |

---

## 🗂️ Directory Structure

```
resources/views/components/
├── atoms/
│   ├── button-primary.blade.php
│   ├── button-secondary.blade.php
│   ├── input.blade.php
│   ├── textarea.blade.php
│   ├── select.blade.php
│   ├── heading.blade.php
│   ├── paragraph.blade.php
│   ├── icon.blade.php
│   ├── badge.blade.php
│   ├── image.blade.php
│   └── video.blade.php
│
├── molecules/
│   ├── feature-card.blade.php
│   ├── testimonial-card.blade.php
│   ├── event-card.blade.php
│   ├── stat-counter.blade.php
│   ├── form-group.blade.php
│   └── social-share.blade.php
│
├── organisms/
│   ├── header.blade.php
│   ├── header/
│   │   ├── desktop-nav.blade.php
│   │   ├── mobile-menu.blade.php
│   │   └── mega-menu.blade.php
│   ├── footer.blade.php
│   ├── hero-slider.blade.php
│   ├── feature-grid.blade.php
│   ├── testimonial-slider.blade.php
│   ├── newsletter-section.blade.php
│   ├── contact-form.blade.php
│   └── announcement-bar.blade.php
│
└── templates/
    ├── section.blade.php
    └── two-column.blade.php
```

---

## 📋 Implementation Priorities

### High Priority (Week 2)
1. ✅ **Atoms**: Buttons, Typography
2. **Organisms**: Header, Footer
3. **Organisms**: Hero Slider
4. **Molecules**: Feature Card, Event Card

### Medium Priority (Week 3)
5. **Organisms**: Feature Grid, Newsletter Section
6. **Molecules**: Testimonial Card, Stat Counter
7. **Templates**: Section, Two-Column

### Low Priority (Week 4+)
8. **Organisms**: Contact Form, Lightbox
9. **Atoms**: Video, Advanced inputs
10. **Molecules**: Social Share, Advanced form groups

---

**Document Version**: 1.0  
**Last Updated**: 2025-11-22  
**Next Review**: After Phase 3 completion
