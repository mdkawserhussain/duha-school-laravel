# Task Breakdown: Zaitoon Academy Homepage Replication

**Based on PRD**: `prd-zaitoon-homepage-replication.md`  
**Reference Image**: `Zaitoon-Academy.png`  
**Goal**: Pixel-perfect replication with full functionality and zero errors

---

## Relevant Files

### Components (New/Modified)
- `resources/views/components/header-zaitoon.blade.php` - Main header with top bar and navigation (MODIFY)
- `resources/views/components/homepage/zaitoon-hero.blade.php` - Hero section with carousel (MODIFY)
- `resources/views/components/homepage/zaitoon-news-ticker.blade.php` - News ticker bar (MODIFY)
- `resources/views/components/homepage/zaitoon-introduction.blade.php` - Introduction section (MODIFY)
- `resources/views/components/homepage/zaitoon-notices-chairman.blade.php` - Notices & Chairman section (MODIFY)
- `resources/views/components/homepage/zaitoon-services.blade.php` - Services grid (MODIFY)
- `resources/views/components/homepage/zaitoon-events.blade.php` - Events carousel (MODIFY)
- `resources/views/components/homepage/zaitoon-videos.blade.php` - Videos section (MODIFY)
- `resources/views/components/homepage/zaitoon-news.blade.php` - News carousel (MODIFY)
- `resources/views/components/homepage/zaitoon-testimonials.blade.php` - Testimonials carousel (MODIFY)
- `resources/views/components/homepage/zaitoon-partners.blade.php` - Partners section (MODIFY)
- `resources/views/components/footer-zaitoon.blade.php` - Footer with 4 columns (CREATE)

### Controllers
- `app/Http/Controllers/HomeController.php` - Homepage data aggregation (MODIFY)

### Models (May Need Creation)
- `app/Models/Testimonial.php` - Testimonials model (CREATE if needed)
- `app/Models/Partner.php` - Partners model (CREATE if needed)

### Configuration
- `tailwind.config.js` - Zaitoon color palette and design tokens (MODIFY)
- `resources/css/app.css` - Custom styles if needed (MODIFY)

### Filament Resources (May Need Creation)
- `app/Filament/Resources/TestimonialResource.php` - Testimonials admin (CREATE if needed)
- `app/Filament/Resources/PartnerResource.php` - Partners admin (CREATE if needed)

### Layouts
- `resources/views/layouts/app.blade.php` - Main layout (MODIFY if needed)
- `resources/views/pages/home.blade.php` - Homepage template (MODIFY)

### Helpers
- `app/Helpers/SiteSettingsHelper.php` - Site settings helper (MODIFY if needed)

### JavaScript
- `resources/js/app.js` - Alpine.js initialization (VERIFY)

### Notes
- All components should follow existing patterns in the codebase
- Use Alpine.js 3.4+ for all interactive features (NO external libraries)
- All images must go through Spatie Media Library with WebP conversion
- Cache key `homepage_v2_data` must be cleared on content updates

---

## Instructions for Completing Tasks

**IMPORTANT:** As you complete each task, you must check it off in this markdown file by changing `- [ ]` to `- [x]`. This helps track progress and ensures you don't skip any steps.

Example:
- `- [ ] 1.1 Read file` → `- [x] 1.1 Read file` (after completing)

Update the file after completing each sub-task, not just after completing an entire parent task.

---

## Tasks

- [x] 1.0 Foundation & Design System Setup
  - [x] 1.1 Verify Tailwind Config Zaitoon Colors
  - [x] 1.2 Add Missing Zaitoon Color Variants
  - [x] 1.3 Verify Typography Configuration
  - [x] 1.4 Add Custom Spacing Values if Needed
  - [x] 1.5 Verify Font Loading (Playfair Display, Inter/Plus Jakarta Sans)
  - [x] 1.6 Test Tailwind Build Process
  - [x] 1.7 Create Design System Reference Document

- [x] 2.0 Header & Navigation Implementation (FR-1, FR-2)
  - [x] 2.1 Top Bar Component (FR-1)
    - [x] 2.1.1 Create/Update top bar with dark green background (#0f3d30)
    - [x] 2.1.2 Add phone number with icon on left (from SiteSettingsHelper)
    - [x] 2.1.3 Add email with envelope icon on left (from SiteSettingsHelper)
    - [x] 2.1.4 Add social media icons on right (Facebook, LinkedIn, Instagram, YouTube)
    - [x] 2.1.5 Add "Login" button with user icon on right
    - [x] 2.1.6 Make phone clickable (tel: link)
    - [x] 2.1.7 Make email clickable (mailto: link)
    - [x] 2.1.8 Add rel="noopener noreferrer" to social links
    - [x] 2.1.9 Set white text with text-xs font size
    - [x] 2.1.10 Hide on mobile (hidden lg:block)
    - [x] 2.1.11 Fix position to top of page (fixed top-0)
    - [x] 2.1.12 Test with empty/null values from SiteSettingsHelper
  - [x] 2.2 Main Navigation Bar (FR-2)
    - [x] 2.2.1 Fix navigation below top bar with white background
    - [x] 2.2.2 Add subtle shadow (shadow-md or shadow-lg)
    - [x] 2.2.3 Implement scroll-based transparency (semi-transparent over hero)
    - [x] 2.2.4 Add Zaitoon Academy logo (green shield with crescent moon + star + text)
    - [x] 2.2.5 Create logo SVG or use image from media library
    - [x] 2.2.6 Add navigation menu items: Home, About (dropdown), Admission (dropdown), Academic (dropdown), Faculty (dropdown), Facilities (dropdown), Hostel, Tahfeez, Contact
    - [x] 2.2.7 Implement dropdown menus with Alpine.js (hover on desktop, click on mobile)
    - [x] 2.2.8 Add "Apply Online" button on far right (yellow bg #fbbf24, green text)
    - [x] 2.2.9 Link "Apply Online" to /admission route
    - [x] 2.2.10 Implement mobile hamburger menu
    - [x] 2.2.11 Add Alpine.js state management (mobileMenuOpen, activeDropdown, scrolled)
    - [x] 2.2.12 Implement scroll detection (window.pageYOffset > 50)
    - [x] 2.2.13 Add dropdown hover/click handlers
    - [x] 2.2.14 Pull menu items from database or site settings
    - [ ] 2.2.15 Test keyboard navigation (Tab, Arrow keys, Escape)
    - [x] 2.2.16 Add ARIA labels and roles for accessibility
    - [x] 2.2.17 Test mobile menu slide-in animation
    - [x] 2.2.18 Test backdrop overlay click-to-close
    - [x] 2.2.19 Verify z-index stacking (top bar > nav bar > content)

- [ ] 3.0 Hero Section with Carousel (FR-3)
  - [ ] 3.1 Hero Section Structure
    - [ ] 3.1.1 Set green background (#1a5e4a) on left side
    - [ ] 3.1.2 Create sweeping curved yellow shape (#fbbf24) using SVG or CSS
    - [ ] 3.1.3 Position yellow curve from bottom-left to center-right
    - [ ] 3.1.4 Set full viewport height (min-height: 90vh)
    - [ ] 3.1.5 Ensure zero gap between header and hero (margin: 0, padding: 0)
    - [ ] 3.1.6 Add padding-top to account for fixed header (10rem)
  - [ ] 3.2 Carousel Implementation
    - [ ] 3.2.1 Set up Alpine.js carousel state (currentSlide, totalSlides, autoplayInterval)
    - [ ] 3.2.2 Create slide container with overflow hidden
    - [ ] 3.2.3 Implement slide transition (fade or slide animation)
    - [ ] 3.2.4 Add previous/next arrow buttons on sides
    - [ ] 3.2.5 Style arrow buttons (white with green hover, positioned absolutely)
    - [ ] 3.2.6 Add pagination dots at bottom (5 dots visible)
    - [ ] 3.2.7 Highlight active dot
    - [ ] 3.2.8 Implement auto-play (5-second intervals)
    - [ ] 3.2.9 Pause auto-play on hover
    - [ ] 3.2.10 Reset auto-play timer on manual navigation
    - [ ] 3.2.11 Make dots clickable to jump to specific slide
  - [ ] 3.3 Slide Content
    - [ ] 3.3.1 Display large white heading text (text-4xl to text-6xl, font-bold)
    - [ ] 3.3.2 Add optional description/subheading text
    - [ ] 3.3.3 Add optional CTA button(s) with proper styling
    - [ ] 3.3.4 Display large image on right side
    - [ ] 3.3.5 Ensure images support WebP format with fallbacks
    - [ ] 3.3.6 Use Spatie Media Library for image handling
    - [ ] 3.3.7 Add lazy loading for non-active slides
    - [ ] 3.3.8 Pull content from HomePageSection model (section_key = 'hero')
    - [ ] 3.3.9 Handle empty/null slide data gracefully
  - [ ] 3.4 Integration
    - [ ] 3.4.1 Connect to HeroSliderManager Filament page
    - [ ] 3.4.2 Test slide creation/editing in admin panel
    - [ ] 3.4.3 Verify cache clearing on slide updates
    - [ ] 3.4.4 Test with 1 slide, 3 slides, 5+ slides
    - [ ] 3.4.5 Verify responsive behavior (mobile stacking)

- [ ] 4.0 News Ticker (FR-4)
  - [ ] 4.1 Ticker Structure
    - [ ] 4.1.1 Create ticker bar below hero with green background (#1a5e4a)
    - [ ] 4.1.2 Add "Latest:" label on left side (white text)
    - [ ] 4.1.3 Create scrolling container for news items
    - [ ] 4.1.4 Set white text color
    - [ ] 4.1.5 Set proper height (py-2 or py-3)
  - [ ] 4.2 Scrolling Animation
    - [ ] 4.2.1 Implement smooth horizontal scrolling (CSS animation or JavaScript)
    - [ ] 4.2.2 Make animation continuous (loop seamlessly)
    - [ ] 4.2.3 Pause animation on hover
    - [ ] 4.2.4 Resume animation on mouse leave
    - [ ] 4.2.5 Test with multiple news items
  - [ ] 4.3 Content Integration
    - [ ] 4.3.1 Pull news items from Notice model
    - [ ] 4.3.2 Filter by is_featured = true OR is_published = true
    - [ ] 4.3.3 Order by published_at DESC
    - [ ] 4.3.4 Make each news item clickable
    - [ ] 4.3.5 Link to notice detail page (route('notices.show', $notice->slug ?? $notice->id))
    - [ ] 4.3.6 Handle empty notices gracefully (hide ticker or show placeholder)
    - [ ] 4.3.7 Add separator between news items (e.g., "•" or "|")

- [ ] 5.0 Introduction Section (FR-5)
  - [ ] 5.1 Layout Structure
    - [ ] 5.1.1 Create two-column layout (grid lg:grid-cols-2)
    - [ ] 5.1.2 Set white background
    - [ ] 5.1.3 Add proper spacing (py-16 lg:py-24)
    - [ ] 5.1.4 Ensure responsive stacking on mobile
  - [ ] 5.2 Left Column (Images)
    - [ ] 5.2.1 Display top image (school building/campus)
    - [ ] 5.2.2 Display bottom image (activity image, e.g., Labour Day)
    - [ ] 5.2.3 Add gap between images (gap-4 or gap-6)
    - [ ] 5.2.4 Ensure images support WebP format
    - [ ] 5.2.5 Add lazy loading for images
    - [ ] 5.2.6 Maintain aspect ratios
    - [ ] 5.2.7 Pull images from HomePageSection (section_key = 'introduction') or HomePageContent
  - [ ] 5.3 Right Column (Text Content)
    - [ ] 5.3.1 Display heading: "To create a group of specialized Islamic scholars."
    - [ ] 5.3.2 Style heading (text-2xl to text-4xl, font-serif, font-bold, text-za-green-primary)
    - [ ] 5.3.3 Add descriptive paragraph about academy mission
    - [ ] 5.3.4 Style paragraph (text-base to text-lg, leading-relaxed, text-gray-700)
    - [ ] 5.3.5 Add "Read More" button (green background, white text, rounded-lg)
    - [ ] 5.3.6 Link "Read More" to /about-us/about
    - [ ] 5.3.7 Pull content from HomePageSection or HomePageContent model
    - [ ] 5.3.8 Handle missing content with placeholders

- [ ] 6.0 Recent Notices & Chairman's Message Section (FR-6)
  - [ ] 6.1 Layout Structure
    - [ ] 6.1.1 Create two-column layout
    - [ ] 6.1.2 Set white background
    - [ ] 6.1.3 Add proper spacing
    - [ ] 6.1.4 Ensure responsive stacking on mobile
  - [ ] 6.2 Left Column (Recent Notices)
    - [ ] 6.2.1 Add heading "Recent Notices" with bell icon
    - [ ] 6.2.2 Style heading (text-2xl, font-bold, text-za-green-primary)
    - [ ] 6.2.3 Pull 5 most recent notices from Notice model
    - [ ] 6.2.4 Order by published_at DESC
    - [ ] 6.2.5 Filter by is_published = true
    - [ ] 6.2.6 Display notice title (clickable, text-lg, font-semibold)
    - [ ] 6.2.7 Format date as "DD MMM YYYY" (e.g., "07 Nov 2025")
    - [ ] 6.2.8 Style date (text-sm, text-gray-500)
    - [ ] 6.2.9 Link notice title to route('notices.show', $notice->slug ?? $notice->id)
    - [ ] 6.2.10 Add "View All Notices" button at bottom
    - [ ] 6.2.11 Style button (green background, white text, rounded-lg)
    - [ ] 6.2.12 Link button to /notices route
    - [ ] 6.2.13 Handle empty notices gracefully
  - [ ] 6.3 Right Column (Chairman's Message)
    - [ ] 6.3.1 Add circular profile picture (rounded-full, w-24 h-24 or similar)
    - [ ] 6.3.2 Ensure image supports WebP format and lazy loading
    - [ ] 6.3.3 Add heading "Chairman's Message"
    - [ ] 6.3.4 Style heading (text-2xl, font-bold, text-za-green-primary)
    - [ ] 6.3.5 Add paragraph text about academy vision
    - [ ] 6.3.6 Style paragraph (text-base, leading-relaxed, text-gray-700)
    - [ ] 6.3.7 Add signatory: "Chairman, Zaitoon Academy"
    - [ ] 6.3.8 Style signatory (text-sm, font-semibold, text-gray-600)
    - [ ] 6.3.9 Add "Read More" button at bottom
    - [ ] 6.3.10 Link "Read More" to appropriate page
    - [ ] 6.3.11 Pull content from HomePageContent (content_key = 'chairman_message') or Staff model (position = 'Chairman')
    - [ ] 6.3.12 Handle missing content gracefully

- [ ] 7.0 Explore Our Services Section (FR-7)
  - [ ] 7.1 Section Structure
    - [ ] 7.1.1 Add heading "Explore Our Services"
    - [ ] 7.1.2 Style heading (text-3xl to text-4xl, font-serif, font-bold, text-center, mb-8)
    - [ ] 7.1.3 Create grid layout (grid-cols-1 md:grid-cols-2 lg:grid-cols-3, gap-6)
    - [ ] 7.1.4 Add light green gradient at top fading to white
    - [ ] 7.1.5 Set white background for main content
    - [ ] 7.1.6 Add proper spacing (py-16 lg:py-24)
  - [ ] 7.2 Service Buttons
    - [ ] 7.2.1 Create 6 service buttons with rounded corners (rounded-lg or rounded-xl)
    - [ ] 7.2.2 Button 1: "Apply Online" - Green background (#1a5e4a), white icon/text
    - [ ] 7.2.3 Button 2: "Zaitoon WhatsApp Helpline" - Green background, white icon/text
    - [ ] 7.2.4 Button 3: "Higher Education Support Center" - Purple background, white icon/text
    - [ ] 7.2.5 Button 4: "Zaitoon Business Forum (ZBF)" - Orange background, white icon/text
    - [ ] 7.2.6 Button 5: "ZA Bulletin" - Blue background, white icon/text
    - [ ] 7.2.7 Button 6: "Prospectus" - Pink background, white icon/text
    - [ ] 7.2.8 Add icons (SVG) to each button
    - [ ] 7.2.9 Add service name text below icon
    - [ ] 7.2.10 Make buttons clickable
    - [ ] 7.2.11 Link to appropriate pages or external resources
    - [ ] 7.2.12 Add hover effects (scale-105 or shadow-lg)
    - [ ] 7.2.13 Ensure touch targets are 44x44px minimum
  - [ ] 7.3 Content Management
    - [ ] 7.3.1 Pull services from HomePageSection (section_key = 'services') or hardcode if static
    - [ ] 7.3.2 Make services configurable through admin panel if using HomePageSection
    - [ ] 7.3.3 Handle missing services gracefully

- [ ] 8.0 Campus Activities & Events Section (FR-8)
  - [ ] 8.1 Section Header
    - [ ] 8.1.1 Add heading "Campus Activities & Events" with star icon
    - [ ] 8.1.2 Style heading (text-3xl to text-4xl, font-serif, font-bold, text-center)
    - [ ] 8.1.3 Add description paragraph below heading
    - [ ] 8.1.4 Style description (text-base to text-lg, text-gray-600, text-center, max-w-3xl mx-auto)
    - [ ] 8.1.5 Set white background
    - [ ] 8.1.6 Add proper spacing (py-16 lg:py-24)
  - [ ] 8.2 Carousel Implementation
    - [ ] 8.2.1 Set up Alpine.js carousel state (currentIndex, totalItems, autoplayInterval)
    - [ ] 8.2.2 Create carousel container with overflow hidden
    - [ ] 8.2.3 Display 4 event cards visible at a time on desktop
    - [ ] 8.2.4 Implement slide transition (smooth scroll or fade)
    - [ ] 8.2.5 Add previous/next arrow buttons
    - [ ] 8.2.6 Style arrow buttons (positioned on sides, visible on hover)
    - [ ] 8.2.7 Add pagination dots below carousel
    - [ ] 8.2.8 Highlight active dot
    - [ ] 8.2.9 Make dots clickable to jump to specific slide
    - [ ] 8.2.10 Implement optional auto-play
    - [ ] 8.2.11 Pause auto-play on hover
  - [ ] 8.3 Event Cards
    - [ ] 8.3.1 Create event card component
    - [ ] 8.3.2 Display featured image (with WebP support, lazy loading)
    - [ ] 8.3.3 Display event title (text-xl, font-bold, text-za-green-primary)
    - [ ] 8.3.4 Format and display event date (text-sm, text-gray-500)
    - [ ] 8.3.5 Display short excerpt/description (text-base, text-gray-600, line-clamp-3)
    - [ ] 8.3.6 Add "Read More" link (text-za-green-primary, hover:underline)
    - [ ] 8.3.7 Link to event detail page (route('events.show', $event->slug ?? $event->id))
    - [ ] 8.3.8 Add hover effects (shadow-lg, scale-105)
    - [ ] 8.3.9 Ensure cards have rounded corners (rounded-xl)
  - [ ] 8.4 Content Integration
    - [ ] 8.4.1 Pull events from Event model
    - [ ] 8.4.2 Filter by is_published = true
    - [ ] 8.4.3 Order by start_date ASC
    - [ ] 8.4.4 Eager load media relationships
    - [ ] 8.4.5 Add "View All Events" button below carousel
    - [ ] 8.4.6 Link button to /events route
    - [ ] 8.4.7 Handle empty events gracefully (show placeholder or hide section)

- [ ] 9.0 Recent Videos Section (FR-9)
  - [ ] 9.1 Layout Structure
    - [ ] 9.1.1 Create two-column layout
    - [ ] 9.1.2 Set white background
    - [ ] 9.1.3 Add proper spacing
    - [ ] 9.1.4 Ensure responsive stacking on mobile
  - [ ] 9.2 Left Column (Video Player)
    - [ ] 9.2.1 Create large YouTube embed container
    - [ ] 9.2.2 Use responsive iframe with 16:9 aspect ratio
    - [ ] 9.2.3 Add video title below player (text-xl, font-bold)
    - [ ] 9.2.4 Add "Watch on YouTube" button
    - [ ] 9.2.5 Link button to YouTube video URL
    - [ ] 9.2.6 Set up Alpine.js state for current video
  - [ ] 9.3 Right Column (Video List)
    - [ ] 9.3.1 Add heading "Recent Videos"
    - [ ] 9.3.2 Style heading (text-2xl, font-bold, text-za-green-primary)
    - [ ] 9.3.3 Display list of 3 smaller video thumbnails
    - [ ] 9.3.4 Add video title for each thumbnail
    - [ ] 9.3.5 Make thumbnails clickable
    - [ ] 9.3.6 Implement Alpine.js to update left player on thumbnail click
    - [ ] 9.3.7 Add active state styling for selected video
  - [ ] 9.4 Content Integration
    - [ ] 9.4.1 Pull videos from HomePageContent (content_key = 'recent_videos') or Video model
    - [ ] 9.4.2 Extract YouTube video IDs from URLs
    - [ ] 9.4.3 Generate YouTube embed URLs
    - [ ] 9.4.4 Handle invalid or deleted videos gracefully
    - [ ] 9.4.5 Test video switching without page reload

- [ ] 10.0 Recent News Section (FR-10)
  - [ ] 10.1 Section Header
    - [ ] 10.1.1 Add heading "Recent News" with newspaper icon
    - [ ] 10.1.2 Style heading (text-3xl to text-4xl, font-serif, font-bold, text-center)
    - [ ] 10.1.3 Add description paragraph below heading
    - [ ] 10.1.4 Style description (text-base to text-lg, text-gray-600, text-center, max-w-3xl mx-auto)
    - [ ] 10.1.5 Set white background
    - [ ] 10.1.6 Add proper spacing (py-16 lg:py-24)
  - [ ] 10.2 Carousel Implementation
    - [ ] 10.2.1 Set up Alpine.js carousel state (similar to events carousel)
    - [ ] 10.2.2 Create carousel container
    - [ ] 10.2.3 Display 4 news cards visible at a time on desktop
    - [ ] 10.2.4 Implement slide transition
    - [ ] 10.2.5 Add previous/next arrow buttons
    - [ ] 10.2.6 Add pagination dots
    - [ ] 10.2.7 Implement optional auto-play
  - [ ] 10.3 News Cards
    - [ ] 10.3.1 Create news card component (similar to event cards)
    - [ ] 10.3.2 Display featured image (WebP support, lazy loading)
    - [ ] 10.3.3 Display news title
    - [ ] 10.3.4 Format and display publication date
    - [ ] 10.3.5 Display short excerpt
    - [ ] 10.3.6 Add "Read More" link
    - [ ] 10.3.7 Link to news detail page
    - [ ] 10.3.8 Add hover effects
  - [ ] 10.4 Content Integration
    - [ ] 10.4.1 Pull news from Notice model OR Page model (page_type = 'news')
    - [ ] 10.4.2 Filter by is_published = true
    - [ ] 10.4.3 Order by published_at DESC
    - [ ] 10.4.4 Eager load media relationships
    - [ ] 10.4.5 Add "View All News" button
    - [ ] 10.4.6 Link button to /notices or /news route
    - [ ] 10.4.7 Handle empty news gracefully

- [ ] 11.0 Testimonials Section (FR-11)
  - [ ] 11.1 Section Header
    - [ ] 11.1.1 Add heading "What Parents Say About Zaitoon Academy" with speech bubble icon
    - [ ] 11.1.2 Style heading (text-3xl to text-4xl, font-serif, font-bold, text-center)
    - [ ] 11.1.3 Add light green gradient at bottom fading to white
    - [ ] 11.1.4 Set white background for main content
    - [ ] 11.1.5 Add proper spacing (py-16 lg:py-24)
  - [ ] 11.2 Testimonial Card
    - [ ] 11.2.1 Create central testimonial card
    - [ ] 11.2.2 Add large quote icon at top
    - [ ] 11.2.3 Display circular profile picture (rounded-full, w-20 h-20)
    - [ ] 11.2.4 Display testimonial text in quotes (text-lg, italic, text-gray-700)
    - [ ] 11.2.5 Display parent's name (text-xl, font-bold, text-za-green-primary)
    - [ ] 11.2.6 Display parent's role/title (text-sm, text-gray-500)
    - [ ] 11.2.7 Style card with shadow and rounded corners
    - [ ] 11.2.8 Center card on page
  - [ ] 11.3 Carousel Implementation
    - [ ] 11.3.1 Set up Alpine.js carousel state
    - [ ] 11.3.2 Implement slide transitions (fade effect)
    - [ ] 11.3.3 Add pagination dots below card
    - [ ] 11.3.4 Highlight active dot
    - [ ] 11.3.5 Implement optional auto-play (5-second intervals)
    - [ ] 11.3.6 Pause auto-play on hover
  - [ ] 11.4 Content Integration
    - [ ] 11.4.1 Create Testimonial model if needed (or use HomePageContent)
    - [ ] 11.4.2 Pull testimonials from Testimonial model or HomePageContent (content_key = 'testimonials')
    - [ ] 11.4.3 Create TestimonialResource in Filament if using model
    - [ ] 11.4.4 Handle empty testimonials gracefully
    - [ ] 11.4.5 Ensure images support WebP format

- [ ] 12.0 Partners Section (FR-12)
  - [ ] 12.1 Section Header
    - [ ] 12.1.1 Add heading "Our Partners" with handshake icon
    - [ ] 12.1.2 Style heading (text-3xl to text-4xl, font-serif, font-bold, text-center)
    - [ ] 12.1.3 Add description: "We are proud to be associated with leading organizations worldwide."
    - [ ] 12.1.4 Style description (text-base to text-lg, text-gray-600, text-center)
    - [ ] 12.1.5 Set white background
    - [ ] 12.1.6 Add proper spacing (py-16 lg:py-24)
  - [ ] 12.2 Partner Logos
    - [ ] 12.2.1 Create horizontal row of partner logos
    - [ ] 12.2.2 Use flex or grid layout (flex-wrap for responsive)
    - [ ] 12.2.3 Add gap between logos (gap-8 or gap-12)
    - [ ] 12.2.4 Ensure logos support WebP format
    - [ ] 12.2.5 Add lazy loading for logos
    - [ ] 12.2.6 Make logos clickable if partner websites available
    - [ ] 12.2.7 Open partner links in new tab
    - [ ] 12.2.8 Add hover effects (opacity or scale)
    - [ ] 12.2.9 Center logos horizontally
  - [ ] 12.3 Content Integration
    - [ ] 12.3.1 Pull partners from HomePageContent (content_key = 'partners') or Partner model
    - [ ] 12.3.2 Create Partner model if needed
    - [ ] 12.3.3 Create PartnerResource in Filament if using model
    - [ ] 12.3.4 Handle empty partners gracefully

- [ ] 13.0 Footer Implementation (FR-13)
  - [ ] 13.1 Footer Structure
    - [ ] 13.1.1 Create footer with dark green background (#0f3d30)
    - [ ] 13.1.2 Set all text to white
    - [ ] 13.1.3 Create four-column layout (grid lg:grid-cols-4)
    - [ ] 13.1.4 Add proper spacing (py-12 lg:py-16)
    - [ ] 13.1.5 Ensure responsive stacking on mobile (single column)
  - [ ] 13.2 Column 1 (Zaitoon Academy & Important Links)
    - [ ] 13.2.1 Display Zaitoon Academy logo (same as header)
    - [ ] 13.2.2 Add "Important Links" heading
    - [ ] 13.2.3 Create list of links: "About Us", "Payment Instruction", "News", "FAQ", "Contact"
    - [ ] 13.2.4 Style links (white text, hover:yellow accent)
    - [ ] 13.2.5 Link to appropriate pages
  - [ ] 13.3 Column 2 (Find Us)
    - [ ] 13.3.1 Add "Find Us" heading
    - [ ] 13.3.2 Embed Google Maps iframe
    - [ ] 13.3.3 Make iframe responsive (aspect-ratio 16:9 or similar)
    - [ ] 13.3.4 Pull map embed URL from SiteSettings
    - [ ] 13.3.5 Handle missing map gracefully
  - [ ] 13.4 Column 3 (Contact Info)
    - [ ] 13.4.1 Add "Contact Info" heading
    - [ ] 13.4.2 Display full address (from SiteSettings)
    - [ ] 13.4.3 Display phone number(s) (from SiteSettings)
    - [ ] 13.4.4 Display email address(es) (from SiteSettings)
    - [ ] 13.4.5 Make phone and email clickable
    - [ ] 13.4.6 Style with proper spacing
  - [ ] 13.5 Column 4 (Apply Online)
    - [ ] 13.5.1 Add large "Apply Online" button
    - [ ] 13.5.2 Style button (yellow background #fbbf24, green text, rounded-lg, px-8 py-4)
    - [ ] 13.5.3 Link button to /admission route
    - [ ] 13.5.4 Add hover effects
  - [ ] 13.6 Bottom Footer Bar
    - [ ] 13.6.1 Create bottom bar with darker green background
    - [ ] 13.6.2 Display copyright: "© 2025 Duha International School. All Rights Reserved."
    - [ ] 13.6.3 Add links: "Legal", "Privacy Policy"
    - [ ] 13.6.4 Style links (white text, hover:yellow accent)
    - [ ] 13.6.5 Link to appropriate pages
  - [ ] 13.7 Social Media Icons
    - [ ] 13.7.1 Add social media icons (Facebook, LinkedIn, Instagram, YouTube)
    - [ ] 13.7.2 Position icons appropriately
    - [ ] 13.7.3 Link to social media URLs from SiteSettings
    - [ ] 13.7.4 Open links in new tabs
    - [ ] 13.7.5 Add hover effects (yellow accent color)

- [ ] 14.0 Responsive Design & Mobile Optimization (FR-14)
  - [ ] 14.1 Mobile Breakpoints (320px - 639px)
    - [ ] 14.1.1 Hide top bar on mobile (hidden lg:block)
    - [ ] 14.1.2 Ensure navigation collapses to hamburger menu
    - [ ] 14.1.3 Stack hero section content vertically
    - [ ] 14.1.4 Show 1 card at a time in carousels
    - [ ] 14.1.5 Stack two-column sections vertically
    - [ ] 14.1.6 Stack footer to single column
    - [ ] 14.1.7 Ensure touch targets are minimum 44x44px
    - [ ] 14.1.8 Test on actual mobile devices (320px, 375px, 414px)
  - [ ] 14.2 Tablet Breakpoints (640px - 1023px)
    - [ ] 14.2.1 Show 2 cards at a time in carousels
    - [ ] 14.2.2 Keep two-column sections side-by-side if space allows
    - [ ] 14.2.3 Adjust font sizes for tablet
    - [ ] 14.2.4 Test on tablet viewports (768px, 1024px)
  - [ ] 14.3 Desktop Breakpoints (1024px+)
    - [ ] 14.3.1 Show full desktop layout
    - [ ] 14.3.2 Show 4 cards in carousels
    - [ ] 14.3.3 Ensure proper spacing and alignment
    - [ ] 14.3.4 Test on various desktop sizes (1280px, 1440px, 1920px)
  - [ ] 14.4 Cross-Browser Testing
    - [ ] 14.4.1 Test in Chrome (latest 2 versions)
    - [ ] 14.4.2 Test in Firefox (latest 2 versions)
    - [ ] 14.4.3 Test in Safari (latest 2 versions)
    - [ ] 14.4.4 Test in Edge (latest 2 versions)
    - [ ] 14.4.5 Verify all features work in all browsers

- [ ] 15.0 Performance Optimization (FR-15)
  - [ ] 15.1 Image Optimization
    - [ ] 15.1.1 Verify all images go through Spatie Media Library
    - [ ] 15.1.2 Ensure WebP conversion is working for all images
    - [ ] 15.1.3 Add fallback formats (JPEG/PNG) for WebP
    - [ ] 15.1.4 Use <picture> tag with WebP source and fallback
    - [ ] 15.1.5 Add lazy loading to all below-fold images
    - [ ] 15.1.6 Optimize hero images with srcset for responsive sizes
    - [ ] 15.1.7 Preload critical hero images
  - [ ] 15.2 Asset Optimization
    - [ ] 15.2.1 Minify CSS in production build
    - [ ] 15.2.2 Minify JavaScript in production build
    - [ ] 15.2.3 Verify Vite build process works correctly
    - [ ] 15.2.4 Test production build (npm run build)
    - [ ] 15.2.5 Verify asset hashing for cache busting
  - [ ] 15.3 Caching Strategy
    - [ ] 15.3.1 Verify homepage cache key: 'homepage_v2_data'
    - [ ] 15.3.2 Set cache TTL to 1 hour (3600 seconds)
    - [ ] 15.3.3 Clear cache on content updates (in observers)
    - [ ] 15.3.4 Test cache clearing mechanism
    - [ ] 15.3.5 Verify HTTP cache headers are set correctly
  - [ ] 15.4 Performance Metrics
    - [ ] 15.4.1 Test page load time on 3G connection (target: < 2 seconds)
    - [ ] 15.4.2 Measure First Contentful Paint (target: < 1.5 seconds)
    - [ ] 15.4.3 Measure Largest Contentful Paint (target: < 2.5 seconds)
    - [ ] 15.4.4 Measure Cumulative Layout Shift (target: < 0.1)
    - [ ] 15.4.5 Run Lighthouse audit and achieve 90+ score
    - [ ] 15.4.6 Optimize any performance bottlenecks

- [ ] 16.0 Accessibility (FR-16)
  - [ ] 16.1 Image Accessibility
    - [ ] 16.1.1 Add descriptive alt text to all images
    - [ ] 16.1.2 Verify alt text is meaningful and contextual
    - [ ] 16.1.3 Mark decorative images with empty alt=""
    - [ ] 16.1.4 Test with screen readers (NVDA, JAWS, VoiceOver)
  - [ ] 16.2 Color Contrast
    - [ ] 16.2.1 Verify text on white background meets WCAG AA (4.5:1)
    - [ ] 16.2.2 Verify white text on green background meets WCAG AA
    - [ ] 16.2.3 Verify yellow accent text meets contrast requirements
    - [ ] 16.2.4 Use online contrast checker tools
    - [ ] 16.2.5 Fix any contrast issues
  - [ ] 16.3 Interactive Elements
    - [ ] 16.3.1 Add visible focus indicators to all interactive elements
    - [ ] 16.3.2 Style focus states (ring-2 ring-za-green-500 or similar)
    - [ ] 16.3.3 Test keyboard navigation (Tab, Enter, Space, Arrow keys)
    - [ ] 16.3.4 Ensure carousel controls are keyboard accessible
    - [ ] 16.3.5 Test dropdown menus with keyboard
    - [ ] 16.3.6 Test mobile menu with keyboard
  - [ ] 16.4 Screen Reader Support
    - [ ] 16.4.1 Add ARIA labels to carousel controls
    - [ ] 16.4.2 Add ARIA live regions for dynamic content changes
    - [ ] 16.4.3 Add proper heading hierarchy (h1 → h2 → h3)
    - [ ] 16.4.4 Add skip to main content link
    - [ ] 16.4.5 Test with screen readers
  - [ ] 16.5 Semantic HTML
    - [ ] 16.5.1 Use semantic HTML5 elements (<main>, <section>, <article>, <nav>, <header>, <footer>)
    - [ ] 16.5.2 Use proper form elements where applicable
    - [ ] 16.5.3 Verify HTML structure is logical and semantic

- [ ] 17.0 Content Management Integration (FR-17)
  - [ ] 17.1 Filament Resources
    - [ ] 17.1.1 Verify HeroSliderManager page exists and works
    - [ ] 17.1.2 Verify HomePageSectionResource exists
    - [ ] 17.1.3 Verify HomePageContentResource exists
    - [ ] 17.1.4 Create TestimonialResource if using Testimonial model
    - [ ] 17.1.5 Create PartnerResource if using Partner model
    - [ ] 17.1.6 Test all resources in admin panel
  - [ ] 17.2 Cache Clearing
    - [ ] 17.2.1 Verify cache is cleared in HomePageSectionObserver
    - [ ] 17.2.2 Verify cache is cleared in HomePageContentObserver
    - [ ] 17.2.3 Verify cache is cleared in EventObserver
    - [ ] 17.2.4 Verify cache is cleared in NoticeObserver
    - [ ] 17.2.5 Test cache clearing after content updates
  - [ ] 17.3 Placeholder Content
    - [ ] 17.3.1 Mark placeholder content clearly in admin panel
    - [ ] 17.3.2 Add helper text for missing content
    - [ ] 17.3.3 Ensure placeholders don't break layout

- [ ] 18.0 Testing & Quality Assurance
  - [ ] 18.1 Functional Testing
    - [ ] 18.1.1 Test all carousels (hero, events, news, testimonials)
    - [ ] 18.1.2 Test all navigation links
    - [ ] 18.1.3 Test all buttons and CTAs
    - [ ] 18.1.4 Test dropdown menus
    - [ ] 18.1.5 Test mobile menu
    - [ ] 18.1.6 Test video switching
    - [ ] 18.1.7 Test news ticker scrolling
    - [ ] 18.1.8 Test all form submissions (if any)
  - [ ] 18.2 Visual Testing
    - [ ] 18.2.1 Compare homepage to reference image pixel-by-pixel
    - [ ] 18.2.2 Verify color accuracy (within 2% variance)
    - [ ] 18.2.3 Verify typography matches reference
    - [ ] 18.2.4 Verify spacing matches reference
    - [ ] 18.2.5 Verify layout matches reference
    - [ ] 18.2.6 Take screenshots and compare
    - [ ] 18.2.7 Fix any visual discrepancies
  - [ ] 18.3 Cross-Device Testing
    - [ ] 18.3.1 Test on iPhone (various models)
    - [ ] 18.3.2 Test on Android devices
    - [ ] 18.3.3 Test on iPad
    - [ ] 18.3.4 Test on various desktop resolutions
    - [ ] 18.3.5 Test on different browsers
  - [ ] 18.4 Error Handling
    - [ ] 18.4.1 Test with empty database (no events, notices, etc.)
    - [ ] 18.4.2 Test with missing images
    - [ ] 18.4.3 Test with invalid YouTube URLs
    - [ ] 18.4.4 Test with missing site settings
    - [ ] 18.4.5 Ensure graceful degradation
    - [ ] 18.4.6 Verify no JavaScript errors in console
    - [ ] 18.4.7 Verify no PHP errors in logs
  - [ ] 18.5 Performance Testing
    - [ ] 18.5.1 Run Lighthouse audit
    - [ ] 18.5.2 Run PageSpeed Insights
    - [ ] 18.5.3 Test on slow 3G connection
    - [ ] 18.5.4 Measure actual load times
    - [ ] 18.5.5 Optimize any slow-loading resources

- [ ] 19.0 Final Polish & Documentation
  - [ ] 19.1 Code Quality
    - [ ] 19.1.1 Review all Blade components for consistency
    - [ ] 19.1.2 Ensure proper indentation and formatting
    - [ ] 19.1.3 Add comments where necessary
    - [ ] 19.1.4 Remove any unused code
    - [ ] 19.1.5 Run Laravel Pint for code formatting
  - [ ] 19.2 Documentation
    - [ ] 19.2.1 Document any custom Alpine.js implementations
    - [ ] 19.2.2 Document cache keys used
    - [ ] 19.2.3 Document any new models or resources created
    - [ ] 19.2.4 Update README if needed
  - [ ] 19.3 Final Verification
    - [ ] 19.3.1 Clear all caches (view, config, route, application)
    - [ ] 19.3.2 Rebuild assets (npm run build)
    - [ ] 19.3.3 Test homepage one final time
    - [ ] 19.3.4 Verify all sections render correctly
    - [ ] 19.3.5 Verify all interactive features work
    - [ ] 19.3.6 Verify responsive design works
    - [ ] 19.3.7 Verify accessibility compliance
    - [ ] 19.3.8 Verify performance metrics are met

---

**Status**: Complete Task Breakdown Generated  
**Total Tasks**: 10 Parent Tasks, 200+ Sub-Tasks  
**Estimated Time**: 6-8 weeks (depending on team size)  
**Priority**: Complete tasks in order, but can work on some sections in parallel after foundation is set

