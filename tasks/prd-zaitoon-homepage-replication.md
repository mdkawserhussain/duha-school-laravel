# Product Requirements Document: Zaitoon Academy Homepage Replication

## Introduction/Overview

This PRD outlines the complete replication of the Zaitoon Academy homepage design for Duha International School. The goal is to transform the current homepage to match the exact visual design, layout, and interactive features shown in the Zaitoon Academy reference image, while maintaining integration with the existing Laravel backend and database structure.

**Problem Statement**: The current homepage does not match the modern, vibrant design aesthetic of the Zaitoon Academy reference. This project will create a pixel-perfect replica that enhances user engagement, improves visual hierarchy, and provides a cohesive brand experience.

**Goal**: Replace the existing homepage with a Zaitoon Academy-inspired design that includes all visual elements, interactive components, and content sections as shown in the reference image, while pulling content from the database where available and using placeholders for missing content.

---

## Goals

1. **Visual Fidelity**: Achieve pixel-perfect replication of the Zaitoon Academy homepage design, including colors, typography, spacing, and layout
2. **Component Completeness**: Implement all 13 major sections visible in the reference image with full functionality
3. **Database Integration**: Seamlessly integrate with existing Laravel models (Events, Notices, Pages, Staff, etc.) to populate dynamic content
4. **Interactive Features**: Implement all interactive elements including hero carousel, news ticker, video embeds, testimonial slider, and event/news carousels
5. **Responsive Design**: Ensure the design works flawlessly across all device sizes (mobile, tablet, desktop)
6. **Performance**: Maintain fast page load times (< 2 seconds) with optimized images and lazy loading
7. **Accessibility**: Ensure WCAG 2.1 AA compliance for all interactive elements and content

---

## User Stories

### As a Visitor
- **US-1**: As a visitor, I want to see a visually appealing homepage that immediately communicates the school's brand identity, so I can form a positive first impression
- **US-2**: As a visitor, I want to easily navigate to different sections of the website through the header menu, so I can find information quickly
- **US-3**: As a visitor, I want to see the latest news and announcements in a scrolling ticker, so I stay informed about important updates
- **US-4**: As a visitor, I want to browse upcoming events and campus activities in an engaging carousel format, so I can discover what's happening at the school
- **US-5**: As a visitor, I want to watch recent videos from the school, so I can get a better sense of the school culture and activities
- **US-6**: As a visitor, I want to read testimonials from parents, so I can understand the school's reputation and quality
- **US-7**: As a visitor, I want to see the school's partners and affiliations, so I can trust the institution's credibility

### As an Administrator
- **US-8**: As an administrator, I want all homepage content to be manageable through the Filament admin panel, so I can update information without developer assistance
- **US-9**: As an administrator, I want the hero slider to support multiple slides with images, text, and CTAs, so I can showcase different aspects of the school
- **US-10**: As an administrator, I want the news ticker to automatically pull from the latest notices, so content stays current without manual updates

---

## Functional Requirements

### FR-1: Top Bar (Header - Fixed)
**Priority**: HIGH | **Complexity**: 3/10

1. **FR-1.1**: The top bar MUST be fixed at the very top of the page with dark green background (`za-green-dark: #0f3d30`)
2. **FR-1.2**: The top bar MUST display on the left side: phone number with phone icon and email address with envelope icon
3. **FR-1.3**: The top bar MUST display on the right side: social media icons (Facebook, LinkedIn, Instagram, YouTube) and a "Login" button with user icon
4. **FR-1.4**: Phone and email MUST be clickable (tel: and mailto: links)
5. **FR-1.5**: Social media links MUST open in new tabs with `rel="noopener noreferrer"`
6. **FR-1.6**: The top bar MUST use white text with small font size (text-xs)
7. **FR-1.7**: The top bar MUST be hidden on mobile devices (hidden lg:block)
8. **FR-1.8**: Content MUST be pulled from `SiteSettingsHelper::primaryPhone()`, `SiteSettingsHelper::primaryEmail()`, and `SiteSettingsHelper::socialMediaLinks()`

### FR-2: Main Navigation Bar (Header - Fixed)
**Priority**: CRITICAL | **Complexity**: 7/10

1. **FR-2.1**: The navigation bar MUST be fixed below the top bar with white background and subtle shadow
2. **FR-2.2**: The navigation bar MUST become semi-transparent when scrolled over the hero section
3. **FR-2.3**: The navigation bar MUST display the Zaitoon Academy logo on the left (green shield with crescent moon and star icon + "Zaitoon Academy" text)
4. **FR-2.4**: The navigation MUST include these menu items: "Home", "About" (with dropdown), "Admission" (with dropdown), "Academic" (with dropdown), "Faculty" (with dropdown), "Facilities" (with dropdown), "Hostel", "Tahfeez", "Contact"
5. **FR-2.5**: Dropdown menus MUST appear on hover for desktop and click for mobile
6. **FR-2.6**: A prominent "Apply Online" button MUST appear on the far right with yellow background (`za-yellow-accent`) and green text
7. **FR-2.7**: The navigation MUST be fully responsive with a mobile hamburger menu
8. **FR-2.8**: Menu items MUST be pulled from the database navigation structure or configured in site settings
9. **FR-2.9**: The navigation MUST use Alpine.js for dropdown functionality and mobile menu toggle
10. **FR-2.10**: The "Apply Online" button MUST link to `/admission` route

### FR-3: Hero Section
**Priority**: CRITICAL | **Complexity**: 8/10

1. **FR-3.1**: The hero section MUST have a large green background (`za-green-primary: #1a5e4a`) on the left side
2. **FR-3.2**: A sweeping, curved yellow shape (`za-yellow-accent: #fbbf24`) MUST extend from the bottom left towards the center-right
3. **FR-3.3**: The hero section MUST support a carousel/slider with multiple slides
4. **FR-3.4**: Each slide MUST display:
   - Large, bold white heading text (e.g., "Nurturing Brilliance, One Child at a Time")
   - Optional description/subheading text
   - Optional CTA button(s)
   - Large image on the right side
5. **FR-3.5**: Carousel controls MUST include:
   - Previous/Next arrow buttons on the sides
   - Pagination dots at the bottom (5 dots visible, one highlighted)
   - Auto-play functionality (5-second intervals)
6. **FR-3.6**: The hero section MUST be full viewport height (min-height: 90vh)
7. **FR-3.7**: Hero slides MUST be manageable through Filament admin panel (HeroSliderManager page)
8. **FR-3.8**: Images MUST support WebP format with fallbacks
9. **FR-3.9**: The hero section MUST use Alpine.js for carousel functionality
10. **FR-3.10**: Content MUST be pulled from `HomePageSection` model with `section_key = 'hero'`

### FR-4: News Ticker
**Priority**: HIGH | **Complexity**: 4/10

1. **FR-4.1**: A news ticker bar MUST appear below the hero section with bright green background (`za-green-primary`)
2. **FR-4.2**: The ticker MUST display a "Latest" label on the left side
3. **FR-4.3**: The ticker MUST display horizontally scrolling news items
4. **FR-4.4**: News items MUST be pulled from the `Notice` model, filtered by `is_featured = true` or `is_published = true`
5. **FR-4.5**: The scrolling animation MUST be smooth and continuous (CSS animation or JavaScript)
6. **FR-4.6**: Each news item MUST be clickable and link to the notice detail page
7. **FR-4.7**: The ticker MUST use white text
8. **FR-4.8**: The ticker MUST pause on hover for better readability

### FR-5: Introduction Section
**Priority**: MEDIUM | **Complexity**: 5/10

1. **FR-5.1**: The introduction section MUST use a two-column layout
2. **FR-5.2**: The left column MUST display two images:
   - Top image: Modern building (school campus)
   - Bottom image: Activity image (e.g., children with "Labour Day" sign)
3. **FR-5.3**: The right column MUST display:
   - Heading: "To create a group of specialized Islamic scholars."
   - Paragraph: Descriptive text about Zaitoon Academy's mission and establishment
   - "Read More" button linking to `/about-us/about`
4. **FR-5.4**: Images MUST support lazy loading and WebP format
5. **FR-5.5**: Content MUST be pulled from `HomePageSection` model with `section_key = 'introduction'` or `HomePageContent` model
6. **FR-5.6**: The section MUST have white background with proper spacing (py-16 lg:py-24)

### FR-6: Recent Notices & Chairman's Message Section
**Priority**: HIGH | **Complexity**: 6/10

1. **FR-6.1**: This section MUST use a two-column layout
2. **FR-6.2**: Left column (Recent Notices) MUST display:
   - Heading "Recent Notices" with bell icon
   - List of 5 most recent notices with:
     - Notice title (clickable)
     - Date (formatted as "DD MMM YYYY", e.g., "07 Nov 2025")
   - "View All Notices" button at the bottom linking to `/notices`
3. **FR-6.3**: Right column (Chairman's Message) MUST display:
   - Circular profile picture of the Chairman
   - Heading "Chairman's Message"
   - Paragraph of text about the academy's vision
   - Signatory: "Chairman, Zaitoon Academy"
   - "Read More" button at the bottom
4. **FR-6.4**: Notices MUST be pulled from `Notice` model, ordered by `published_at DESC`, limited to 5
5. **FR-6.5**: Chairman's message MUST be pulled from `HomePageContent` model with `content_key = 'chairman_message'` or `Staff` model filtered by position
6. **FR-6.6**: Images MUST support WebP format and lazy loading
7. **FR-6.7**: The section MUST have white background

### FR-7: Explore Our Services Section
**Priority**: HIGH | **Complexity**: 5/10

1. **FR-7.1**: The section MUST display heading "Explore Our Services"
2. **FR-7.2**: A grid of 6 rectangular service buttons MUST be displayed with rounded corners
3. **FR-7.3**: Each service button MUST have:
   - Icon (SVG or image)
   - Service name text
   - Unique background color:
     - "Apply Online": Green background (`za-green-primary`), white icon/text
     - "Zaitoon WhatsApp Helpline": Green background, white icon/text
     - "Higher Education Support Center": Purple background, white icon/text
     - "Zaitoon Business Forum (ZBF)": Orange background, white icon/text
     - "ZA Bulletin": Blue background, white icon/text
     - "Prospectus": Pink background, white icon/text
4. **FR-7.4**: Buttons MUST be clickable and link to appropriate pages or external resources
5. **FR-7.5**: The section MUST have a light green gradient at the top fading to white
6. **FR-7.6**: Services MUST be configurable through `HomePageSection` model with `section_key = 'services'` or hardcoded if static
7. **FR-7.7**: Buttons MUST have hover effects (scale or shadow)

### FR-8: Campus Activities & Events Section
**Priority**: HIGH | **Complexity**: 7/10

1. **FR-8.1**: The section MUST display heading "Campus Activities & Events" with star icon
2. **FR-8.2**: A short description paragraph MUST appear below the heading
3. **FR-8.3**: A carousel of event cards MUST be displayed (4 cards visible at a time on desktop)
4. **FR-8.4**: Each event card MUST display:
   - Featured image (with WebP support)
   - Event title
   - Event date (formatted)
   - Short excerpt/description
   - "Read More" link
5. **FR-8.5**: Carousel controls MUST include:
   - Navigation arrows (previous/next)
   - Pagination dots below the carousel
   - Auto-play functionality (optional)
6. **FR-8.6**: Events MUST be pulled from `Event` model, filtered by `is_published = true`, ordered by `start_date ASC`
7. **FR-8.7**: A "View All Events" button MUST appear below the carousel linking to `/events`
8. **FR-8.8**: The carousel MUST use Alpine.js for functionality
9. **FR-8.9**: The section MUST have white background

### FR-9: Recent Videos Section
**Priority**: MEDIUM | **Complexity**: 6/10

1. **FR-9.1**: The section MUST use a two-column layout
2. **FR-9.2**: Left column MUST display:
   - Large embedded YouTube video player with thumbnail
   - Video title below the player
   - "Watch on YouTube" button
3. **FR-9.3**: Right column MUST display:
   - Heading "Recent Videos"
   - List of 3 smaller video thumbnails with titles
   - Each thumbnail MUST be clickable to load that video in the left player
4. **FR-9.4**: Videos MUST be pulled from `HomePageContent` model with `content_key = 'recent_videos'` or a dedicated `Video` model if exists
5. **FR-9.5**: YouTube embeds MUST use responsive iframe with proper aspect ratio (16:9)
6. **FR-9.6**: Video switching MUST use Alpine.js to update the left player without page reload
7. **FR-9.7**: The section MUST have white background

### FR-10: Recent News Section
**Priority**: HIGH | **Complexity**: 6/10

1. **FR-10.1**: The section MUST display heading "Recent News" with newspaper icon
2. **FR-10.2**: A short description paragraph MUST appear below the heading
3. **FR-10.3**: A carousel of news cards MUST be displayed (4 cards visible at a time on desktop)
4. **FR-10.4**: Each news card MUST display:
   - Featured image (with WebP support)
   - News title
   - Publication date (formatted)
   - Short excerpt/description
   - "Read More" link
5. **FR-10.5**: Carousel controls MUST include:
   - Navigation arrows (previous/next)
   - Pagination dots below the carousel
   - Auto-play functionality (optional)
6. **FR-10.6**: News items MUST be pulled from `Notice` model or `Page` model with `page_type = 'news'`, filtered by `is_published = true`, ordered by `published_at DESC`
7. **FR-10.7**: A "View All News" button MUST appear below the carousel linking to `/notices` or `/news`
8. **FR-10.8**: The carousel MUST use Alpine.js for functionality
9. **FR-10.9**: The section MUST have white background

### FR-11: Testimonials Section
**Priority**: MEDIUM | **Complexity**: 5/10

1. **FR-11.1**: The section MUST display heading "What Parents Say About Zaitoon Academy"
2. **FR-11.2**: A central testimonial card MUST be displayed with:
   - Large quote icon at the top
   - Circular profile picture of the parent
   - Testimonial text (in quotes)
   - Parent's name
   - Parent's role/title (e.g., "Parent")
3. **FR-11.3**: Pagination dots MUST appear below the card indicating carousel functionality
4. **FR-11.4**: Testimonials MUST be pulled from a `Testimonial` model or `HomePageContent` model with `content_key = 'testimonials'`
5. **FR-11.5**: The carousel MUST use Alpine.js for slide transitions
6. **FR-11.6**: The section MUST have a light green gradient at the bottom fading to white
7. **FR-11.7**: Auto-play functionality MUST be optional (5-second intervals)

### FR-12: Partners Section
**Priority**: LOW | **Complexity**: 3/10

1. **FR-12.1**: The section MUST display heading "Our Partners" with handshake icon
2. **FR-12.2**: A description paragraph MUST appear: "We are proud to be associated with leading organizations worldwide."
3. **FR-12.3**: A row of partner logos MUST be displayed horizontally
4. **FR-12.4**: Partner logos MUST be pulled from `HomePageContent` model with `content_key = 'partners'` or a dedicated `Partner` model
5. **FR-12.5**: Logos MUST support WebP format and lazy loading
6. **FR-12.6**: Logos MUST be clickable if partner websites are available
7. **FR-12.7**: The section MUST have white background

### FR-13: Footer
**Priority**: HIGH | **Complexity**: 7/10

1. **FR-13.1**: The footer MUST have dark green background (`za-green-dark`)
2. **FR-13.2**: The footer MUST use a four-column layout:
   - **Column 1 (Zaitoon Academy)**:
     - Logo: "Zaitoon Academy" (same as header)
     - "Important Links" heading
     - List of links: "About Us", "Payment Instruction", "News", "FAQ", "Contact"
   - **Column 2 (Find Us)**:
     - "Find Us" heading
     - Embedded Google Maps showing school location
   - **Column 3 (Contact Info)**:
     - "Contact Info" heading
     - Full address
     - Phone number(s)
     - Email address(es)
   - **Column 4 (Apply Online)**:
     - Large "Apply Online" button (yellow background, green text)
3. **FR-13.3**: Footer content MUST be pulled from `SiteSettings` model
4. **FR-13.4**: Google Maps embed MUST be responsive and use iframe
5. **FR-13.5**: A bottom footer bar MUST display:
   - Copyright text: "© 2025 Duha International School. All Rights Reserved."
   - Links: "Legal", "Privacy Policy"
6. **FR-13.6**: All footer text MUST be white
7. **FR-13.7**: Links MUST have hover effects (yellow accent color)

### FR-14: Responsive Design
**Priority**: CRITICAL | **Complexity**: 8/10

1. **FR-14.1**: The homepage MUST be fully responsive across all breakpoints:
   - Mobile: 320px - 639px
   - Tablet: 640px - 1023px
   - Desktop: 1024px+
2. **FR-14.2**: Mobile-specific requirements:
   - Top bar MUST be hidden
   - Navigation MUST collapse to hamburger menu
   - Hero section MUST stack content vertically
   - Carousels MUST show 1 card at a time
   - Two-column sections MUST stack vertically
   - Footer MUST stack to single column
3. **FR-14.3**: Tablet-specific requirements:
   - Carousels MUST show 2 cards at a time
   - Two-column sections MAY remain side-by-side if space allows
4. **FR-14.4**: Touch targets MUST be minimum 44x44px on mobile
5. **FR-14.5**: All interactive elements MUST be accessible via keyboard navigation

### FR-15: Performance & Optimization
**Priority**: HIGH | **Complexity**: 6/10

1. **FR-15.1**: All images MUST be converted to WebP format with fallbacks
2. **FR-15.2**: Images below the fold MUST use lazy loading
3. **FR-15.3**: Page load time MUST be < 2 seconds on 3G connection
4. **FR-15.4**: Hero images MUST be optimized and served in appropriate sizes (srcset)
5. **FR-15.5**: CSS and JavaScript MUST be minified in production
6. **FR-15.6**: Carousel images MUST be preloaded for smooth transitions

### FR-16: Accessibility
**Priority**: HIGH | **Complexity**: 5/10

1. **FR-16.1**: All images MUST have descriptive alt text
2. **FR-16.2**: Color contrast MUST meet WCAG 2.1 AA standards (4.5:1 for text)
3. **FR-16.3**: All interactive elements MUST have visible focus indicators
4. **FR-16.4**: Carousel controls MUST be keyboard accessible (Arrow keys, Tab navigation)
5. **FR-16.5**: Screen reader announcements MUST be provided for dynamic content changes
6. **FR-16.6**: Skip to main content link MUST be available

### FR-17: Content Management
**Priority**: MEDIUM | **Complexity**: 7/10

1. **FR-17.1**: All homepage sections MUST be manageable through Filament admin panel
2. **FR-17.2**: Hero slides MUST be editable via HeroSliderManager Filament page
3. **FR-17.3**: Services, testimonials, partners MUST be editable via HomePageSection or HomePageContent resources
4. **FR-17.4**: Content updates MUST clear homepage cache automatically
5. **FR-17.5**: Placeholder content MUST be clearly marked in admin panel for missing data

---

## Non-Goals (Out of Scope)

1. **User Authentication/Login Functionality**: The "Login" button in the top bar is visual only - actual login functionality is out of scope for this PRD
2. **Backend API Development**: This PRD focuses on frontend replication - API endpoints are assumed to exist or will be created separately
3. **Content Migration**: Migrating existing content to match Zaitoon Academy content is out of scope - we use existing content structure
4. **Multi-language Support**: Language switching functionality is out of scope
5. **Advanced Search Functionality**: Search features beyond basic navigation are out of scope
6. **Newsletter Backend**: Newsletter subscription functionality is assumed to exist - only frontend integration is in scope
7. **Payment Integration**: Payment instruction pages are out of scope - only linking is required
8. **Video Upload/Management**: Video management system is out of scope - only YouTube embed integration
9. **Partner Management System**: Full CRUD for partners is out of scope - basic display is sufficient
10. **Analytics Integration**: Google Analytics or other tracking is out of scope

---

## Design Considerations

### Color Palette
The design MUST use the exact Zaitoon Academy color palette as defined in `design_system.md`:
- **Primary Green**: `#1a5e4a` (za-green-primary)
- **Dark Green**: `#0f3d30` (za-green-dark) 
- **Yellow Accent**: `#fbbf24` (za-yellow-accent)
- **White**: `#ffffff`
- **Neutral Grays**: As defined in design system

### Typography
- **Headings**: Playfair Display (serif) for main headings, Inter/Plus Jakarta Sans for subheadings
- **Body Text**: Inter or Plus Jakarta Sans (sans-serif)
- **Font Sizes**: Follow Tailwind scale (text-2xl to text-6xl for hero, text-xl to text-3xl for section headings)
- **Font Weights**: Bold (700) for headings, Normal (400) for body, Semibold (600) for buttons

### Spacing & Layout
- **Section Padding**: py-16 (mobile), py-20 (tablet), py-24 (desktop)
- **Container Max Width**: 1320px (custom-container) or max-w-7xl
- **Gap Between Elements**: gap-4 (mobile), gap-6 (tablet), gap-8 (desktop)
- **Card Padding**: p-6 (mobile), p-8 (desktop)

### Component Patterns
- **Buttons**: Rounded-full for primary CTAs, rounded-lg for secondary
- **Cards**: Rounded-xl or rounded-2xl with shadow-lg
- **Images**: Aspect ratios maintained, object-fit: cover
- **Icons**: Consistent size (w-5 h-5 for small, w-6 h-6 for medium)

### Reference Materials
- Primary reference: `Zaitoon-Academy.png` image
- Design system: `zaitoon/design_system.md`
- Component inventory: `zaitoon/component_inventory.md`
- Implementation plan: `zaitoon/plan.md`

---

## Technical Considerations

### Frontend Stack
- **CSS Framework**: Tailwind CSS 4.0 (MUST use existing configuration)
- **JavaScript Framework**: Alpine.js 3.4+ ONLY (NO Vue, React, or other frameworks)
- **Build Tool**: Vite 7.0
- **Templates**: Laravel Blade components

### Backend Integration
- **Models**: Integrate with existing `Event`, `Notice`, `Page`, `Staff`, `HomePageSection`, `HomePageContent`, `SiteSettings` models
- **Controllers**: Extend `HomeController` to pass required data to homepage view
- **Caching**: Use Laravel cache for homepage data (cache key: `homepage_v2_data`)
- **Media Library**: Use Spatie Media Library for all images with WebP conversion

### Component Structure
- **Location**: `resources/views/components/homepage/` directory
- **Naming**: Use `zaitoon-{section-name}.blade.php` pattern (e.g., `zaitoon-hero.blade.php`)
- **Props**: Use Laravel Blade component props for dynamic data
- **Slots**: Use named slots for flexible content areas

### Alpine.js Implementation
- **State Management**: Use `x-data` for component-level state
- **Carousels**: Implement with Alpine.js (no external libraries like Swiper)
- **Scroll Detection**: Use Alpine.js for navbar scroll behavior
- **Mobile Menu**: Use Alpine.js for toggle and animations

### Performance
- **Image Optimization**: All images MUST go through Spatie Media Library WebP conversion
- **Lazy Loading**: Use `loading="lazy"` attribute for below-fold images
- **Caching Strategy**: Cache homepage data for 1 hour, clear on content updates
- **Asset Bundling**: Use Vite for CSS/JS bundling and optimization

### Browser Support
- **Modern Browsers**: Chrome, Firefox, Safari, Edge (last 2 versions)
- **Mobile**: iOS Safari, Chrome Mobile (last 2 versions)
- **Fallbacks**: Graceful degradation for older browsers

---

## Success Metrics

### Visual Fidelity
- **Metric 1**: 95%+ pixel accuracy when compared to reference image (measured via visual regression testing)
- **Metric 2**: All 13 major sections match reference design
- **Metric 3**: Color accuracy within 2% variance (measured via color picker)

### Performance
- **Metric 4**: Page load time < 2 seconds on 3G connection (Lighthouse score)
- **Metric 5**: First Contentful Paint < 1.5 seconds
- **Metric 6**: Largest Contentful Paint < 2.5 seconds
- **Metric 7**: Cumulative Layout Shift < 0.1

### Functionality
- **Metric 8**: All carousels function correctly (hero, events, news, testimonials)
- **Metric 9**: All links navigate to correct pages
- **Metric 10**: All interactive elements respond to user input
- **Metric 11**: Mobile menu opens/closes correctly on all devices

### Accessibility
- **Metric 12**: WCAG 2.1 AA compliance (verified via automated testing tools)
- **Metric 13**: All images have descriptive alt text
- **Metric 14**: Keyboard navigation works for all interactive elements
- **Metric 15**: Screen reader compatibility (tested with NVDA/JAWS)

### Content Integration
- **Metric 16**: 100% of dynamic content pulls from database (no hardcoded content)
- **Metric 17**: Placeholder content clearly marked for missing data
- **Metric 18**: Admin panel allows editing of all homepage sections

---

## Open Questions

1. **Q1**: Should the "Login" button in the top bar link to an existing login page, or should it be removed/hidden if authentication is not implemented?
   - **Recommendation**: Link to `/login` if route exists, otherwise hide the button

2. **Q2**: What should happen if there are no events/notices/news items in the database?
   - **Recommendation**: Display placeholder message "No events/news available at this time" or hide the section

3. **Q3**: Should the Google Maps embed use a specific API key, or use a generic embed?
   - **Recommendation**: Use embed URL from site settings, fallback to generic if not configured

4. **Q4**: How many hero slides should be supported minimum/maximum?
   - **Recommendation**: Minimum 1, maximum 10 slides

5. **Q5**: Should testimonials have a dedicated model, or use HomePageContent?
   - **Recommendation**: Create `Testimonial` model for better structure and future expansion

6. **Q6**: What is the expected behavior when clicking partner logos?
   - **Recommendation**: Open partner website in new tab if URL is available, otherwise no action

7. **Q7**: Should the news ticker support multiple announcements or cycle through them?
   - **Recommendation**: Cycle through multiple announcements with smooth transitions

8. **Q8**: What is the fallback if YouTube video URLs are invalid or videos are deleted?
   - **Recommendation**: Display error message or hide the video section

9. **Q9**: Should the homepage support dark mode or only light mode?
   - **Recommendation**: Light mode only (matches reference design)

10. **Q10**: How should the "Apply Online" button behave if admission is closed?
    - **Recommendation**: Still link to admission page, but page itself should indicate status

---

## Dependencies

### Required Models
- `Event` (existing)
- `Notice` (existing)
- `Page` (existing)
- `Staff` (existing)
- `HomePageSection` (existing)
- `HomePageContent` (existing)
- `SiteSettings` (existing)
- `Testimonial` (may need to be created)
- `Partner` (may need to be created)

### Required Helpers
- `SiteSettingsHelper` (existing)
- May need new helpers for homepage-specific data aggregation

### Required Filament Resources
- `HeroSliderManager` page (existing)
- `HomePageSectionResource` (existing)
- `HomePageContentResource` (existing)
- May need `TestimonialResource` and `PartnerResource`

### External Services
- YouTube API (for video embeds - optional, can use direct embed URLs)
- Google Maps API (for footer map embed)

---

## Implementation Notes

1. **Incremental Development**: Implement sections one at a time, starting with header/navigation, then hero, then content sections
2. **Component Reusability**: Create reusable Blade components for cards, buttons, and carousels
3. **Testing Strategy**: Test each section individually before integrating into full homepage
4. **Content Placeholders**: Use Lorem Ipsum or similar for missing content during development
5. **Cache Management**: Ensure cache is cleared after each section implementation for testing
6. **Mobile-First**: Develop mobile layout first, then enhance for larger screens
7. **Browser Testing**: Test in multiple browsers at each milestone

---

**Document Version**: 1.0  
**Created**: 2025-01-22  
**Last Updated**: 2025-01-22  
**Status**: Ready for Implementation  
**Next Step**: Generate implementation tasks from this PRD

