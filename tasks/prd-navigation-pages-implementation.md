# Product Requirements Document: Navigation Pages Implementation for Duha International School

## Introduction/Overview

This PRD outlines the requirements for ensuring all navigation menu items in the Duha International School website have working routes, views, controllers, and data. Currently, some navigation items (like `/principal-message`) return 404 errors, and many navigation items lack corresponding views or data. This implementation will create or update routes, views, controllers, models, migrations, and seeders to ensure every navigation item displays properly with actual content, matching the existing design style (similar to `/about` view).

**Problem Statement:** Navigation menu items are defined in the database, but many lack corresponding routes, views, or data. When users click on navigation items, they encounter 404 errors or empty pages. The `/principal-message` route exists in seeders but doesn't work, and many other pages need to be created.

**Goal:** Ensure every navigation menu item has a working route, a properly styled view matching the existing design system, and actual content data (either from existing seeders or generated from the admission book reference document).

---

## Goals

1. **Create Missing Routes**: Ensure every navigation item has a corresponding route registered in `routes/web.php` or handled through a catch-all route system.

2. **Create/Update Views**: Create or update Blade views for all navigation pages, ensuring they match the existing design style (similar to `/about` view with hero sections, content areas, animations, etc.).

3. **Populate Data**: Ensure all pages have actual content data, either from existing seeders (like `PagesSeeder`) or by creating new seeders based on content from `plan/adbook.md`.

4. **Fix Existing Issues**: Resolve 404 errors for pages like `/principal-message` that have data but broken routes.

5. **Maintain Design Consistency**: All new views must match the existing design system (colors, typography, animations, layout structure).

6. **Support Dynamic Content**: Ensure the Page model and PageController can handle all navigation items dynamically.

---

## User Stories

### US-1: As a website visitor, I want to click on any navigation menu item and see a properly styled page with actual content
**Acceptance Criteria:**
- Every navigation item in the menu has a working route
- Every route displays a view with proper styling matching the site design
- Every page shows actual content (not placeholder text)
- Pages load without 404 errors

### US-2: As a website visitor, I want to read leadership messages (Principal, Chairman, etc.) with proper formatting
**Acceptance Criteria:**
- `/principal-message` route works and displays Principal's message
- `/chairman-message` route works and displays Chairman's message
- Leadership pages use the `leadership.blade.php` template
- Content is properly formatted with hero sections, badges, and styled text

### US-3: As a website visitor, I want to access academic information pages with detailed content
**Acceptance Criteria:**
- All academic dropdown items (Academic Program, Calendar, Subjects, etc.) have working routes
- Pages display relevant content from the admission book or generated content
- Academic pages maintain consistent styling with the rest of the site

### US-4: As a website visitor, I want to view admission-related pages with complete information
**Acceptance Criteria:**
- Admission dropdown items (Procedure, Why Us, Fees, Year Groups) have working routes
- Pages display detailed admission information
- Fee information is clearly presented in tables or structured format
- Year group and age range information is easy to understand

### US-5: As a website visitor, I want to explore facilities and faculty information
**Acceptance Criteria:**
- Facilities pages display information about campus facilities
- Faculty pages (Male/Female) show faculty listings or information
- All pages maintain consistent design and navigation

---

## Functional Requirements

### FR-1: Route Creation and Management

**FR-1.1**: The system MUST support two route handling approaches:
- **Explicit Routes**: Create named routes in `routes/web.php` for specific pages (e.g., `Route::get('/principal-message', ...)`)
- **Dynamic Routes**: Use a catch-all route system that handles slug-based URLs (e.g., `/pages/{slug}`)

**FR-1.2**: All navigation items MUST be accessible via their slug-based URLs:
- `/about` → About Duha page
- `/principal-message` → Principal's Message page
- `/chairman-message` → Chairman's Message page
- `/admission-process` → Admission Procedure page
- `/fees` → Fees information page
- `/academic-program` → Academic Program page
- And all other navigation items as defined in `NavigationSeeder`

**FR-1.3**: Routes MUST be registered in `routes/web.php` in the following order:
1. Specific named routes (if needed for special handling)
2. Category-based routes (about-us, academics, etc.)
3. Generic page routes (catch-all for slug-based pages)

**FR-1.4**: The `PageController` MUST handle all page requests, either through:
- Category-based routing (`/about-us/{slug}`)
- Direct slug-based routing (`/pages/{slug}`)
- Or a combination of both

**FR-1.5**: Routes MUST return 404 only when:
- The page doesn't exist in the database
- The page exists but is not published (`is_published = false`)
- The page exists but `published_at` is in the future

### FR-2: View Creation and Styling

**FR-2.1**: All page views MUST use one of the following templates:
- `pages/page.blade.php` - Standard content pages
- `pages/leadership.blade.php` - Leadership message pages (Principal, Chairman, etc.)
- `pages/category.blade.php` - Category landing pages with child pages
- `pages/about.blade.php` - Special about page (if different styling needed)

**FR-2.2**: All views MUST match the existing design system:
- Use primary color `#008236` for headings, links, and accents
- Use secondary color `#1E3A8A` for secondary elements
- Use accent color `#F4C430` for highlights
- Include hero sections with proper styling
- Use Alpine.js for animations and interactions
- Follow Tailwind CSS 4.0 utility classes
- Include responsive design (mobile-first)

**FR-2.3**: Leadership pages (Principal Message, Chairman Message) MUST:
- Display hero section with badge (person name and title)
- Display subtitle/quote prominently
- Format content with proper typography
- Use the `pages/leadership.blade.php` template

**FR-2.4**: Content pages MUST include:
- Breadcrumb navigation
- Hero section (if `hero_image` or `hero_badge` exists)
- Featured image (if `featured_image` exists)
- Main content area with proper prose styling
- Print and Share buttons at the bottom
- Last updated date

**FR-2.5**: All views MUST be responsive:
- Mobile viewports (< 768px): Stacked layout, full-width content
- Tablet viewports (768px - 1024px): Adjusted spacing, readable columns
- Desktop viewports (> 1024px): Full layout with proper spacing

### FR-3: Data Population

**FR-3.1**: The `PagesSeeder` MUST be updated to include all navigation items:
- About section pages (About Duha, Chairman Message, Principal Message, Governing Body, Academic Committee, Campus Facilities, School Uniform, FAQ)
- Admission section pages (Admission Procedure, Why Us, Fees, Year Groups)
- Academic section pages (Academic Program, Calendar, Subjects, Tahfeez Program, Tahili Program, Future Progression, Curriculum, Exam System, Policies, Class Routine, Sports, Events & Activities)
- Faculty section pages (Male Faculty, Female Faculty)
- Facilities section pages (Residential Facilities, Support for Learning, Parent Teacher Association)
- Tahfeez page (single page)

**FR-3.2**: Content for pages MUST be sourced from:
- Existing seeders (if data already exists)
- `plan/adbook.md` document (extract relevant content)
- Generated placeholder content based on `adbook.md` structure (if exact content not available)

**FR-3.3**: Principal Message page MUST use content from:
- `PagesSeeder` (if exists) - slug: `principal-message`
- Or create new seeder entry with content from `adbook.md` (Principal's Message section)

**FR-3.4**: Chairman Message page MUST be created with:
- Content from `adbook.md` (Founder & President's Message section)
- Proper slug: `chairman-message` or `founder-director-message`
- Hero badge: "Hasan Mahmud - Founder & President"

**FR-3.5**: Fees page MUST include:
- Structured fee information from `adbook.md`
- Tables showing fees by grade/curriculum
- Clear formatting for different fee types (Admission Fee, Session Fee, Monthly Tuition Fee, etc.)

**FR-3.6**: Academic Program pages MUST include:
- Content from `adbook.md` academic sections
- Information about Hifzul Quran Program, Islamic Curriculum, National Curriculum, Cambridge Curriculum
- Proper formatting with headings, lists, and structured content

**FR-3.7**: All pages MUST have proper SEO metadata:
- `meta_title` - Descriptive page title
- `meta_description` - SEO description
- `seo_keywords` - Relevant keywords array
- `hero_badge` - For leadership pages
- `hero_subtitle` - For emphasis/quotes

### FR-4: Controller and Service Updates

**FR-4.1**: `PageController` MUST handle all page requests correctly:
- Check if page exists by slug
- Check if page is published
- Return appropriate view based on page type
- Handle 404 errors gracefully

**FR-4.2**: `PageService` MUST provide methods for:
- Finding pages by slug
- Finding category pages
- Finding child pages within a category
- Filtering published pages only

**FR-4.3**: The system MUST support both routing approaches:
- Direct slug access: `/principal-message` → finds page with slug `principal-message`
- Category-based access: `/about-us/principal-message` → finds page in `about-us` category with slug `principal-message`

### FR-5: Model and Database

**FR-5.1**: The `Page` model MUST support:
- Slug-based routing (`getRouteKeyName()` returns `slug`)
- Parent-child relationships
- Category-based organization
- Media attachments (hero_image, featured_image, gallery)
- SEO fields (meta_title, meta_description, seo_keywords)

**FR-5.2**: Database migrations MUST ensure:
- `pages` table has all required fields
- Indexes on `slug`, `page_category`, `parent_id`, `is_published`
- Foreign key constraints for `parent_id`

**FR-5.3**: Seeders MUST:
- Use `updateOrCreate()` to avoid duplicates
- Set proper `parent_id` relationships
- Set proper `page_category` values
- Set `is_published = true` and `published_at = now()` for all pages
- Include proper content from `adbook.md` or generated content

### FR-6: Content Structure

**FR-6.1**: Page content MUST be stored as HTML in the `content` field:
- Use semantic HTML (`<h2>`, `<h3>`, `<p>`, `<ul>`, `<ol>`, etc.)
- Include proper formatting for readability
- Use Tailwind prose classes for styling
- Include structured data where appropriate

**FR-6.2**: Leadership pages MUST include:
- Person's name and title in hero badge
- Quote or subtitle in hero section
- Formatted message content
- Proper typography hierarchy

**FR-6.3**: Information pages (Fees, Academic Program, etc.) MUST include:
- Clear headings and subheadings
- Structured lists or tables
- Proper spacing and readability
- Visual hierarchy

---

## Non-Goals (Out of Scope)

1. **Admin Panel Updates**: This PRD does not include updates to Filament admin panel for managing these pages (assumes existing admin functionality works).

2. **Advanced Features**: This PRD does not include:
   - Comments system
   - Related pages suggestions
   - Page versioning
   - Advanced search functionality
   - Multi-language support (beyond existing structure)

3. **Content Migration**: This PRD does not include migrating content from external sources beyond `adbook.md`.

4. **Design System Changes**: This PRD does not include changes to the overall design system, only ensuring new pages match existing styles.

5. **Performance Optimization**: This PRD focuses on functionality, not performance optimization (caching, lazy loading, etc.) - though existing optimizations should be maintained.

---

## Design Considerations

### Visual Design

1. **Hero Sections**: All pages should have hero sections similar to `/about` page:
   - Gradient backgrounds (`from-[#E8F5E9] via-white to-[#E8F5E9]`)
   - Large headings with primary color (`#008236`)
   - Optional hero images or badges
   - Smooth animations on load

2. **Content Sections**: 
   - White or light gray backgrounds
   - Proper spacing (`py-16`, `py-20`)
   - Max-width containers (`max-w-4xl`, `max-w-7xl`)
   - Responsive padding (`px-4 sm:px-6 lg:px-8`)

3. **Typography**:
   - Headings: Bold, primary color, proper hierarchy
   - Body text: Gray (`text-gray-700`), readable line-height
   - Links: Primary color with hover effects

4. **Animations**:
   - Fade-in on scroll (Alpine.js)
   - Hover effects on cards/buttons
   - Smooth transitions

### Component Reusability

1. **Reuse Existing Components**:
   - `<x-page-hero>` for hero sections
   - `<x-breadcrumbs>` for navigation
   - Existing layout structure

2. **Consistent Patterns**:
   - Card-based layouts for lists
   - Grid layouts for multiple items
   - Consistent button styles

---

## Technical Considerations

### Routing Strategy

1. **Primary Approach**: Use the existing `PageController@show` method with slug-based routing via `Route::get('/pages/{page:slug}', ...)`

2. **Category Routes**: Maintain existing category routes (`/about-us/{page}`, `/academics/{page}`, etc.) for backward compatibility

3. **Direct Routes**: For commonly accessed pages, consider adding direct routes:
   ```php
   Route::get('/principal-message', [PageController::class, 'show'])->defaults('slug', 'principal-message');
   ```

### Data Seeding

1. **Seeder Organization**: Update `PagesSeeder` to include all navigation items organized by category

2. **Content Sources**:
   - Extract content from `plan/adbook.md`
   - Use existing seeder data where available
   - Generate structured content based on `adbook.md` sections

3. **Relationships**: Ensure proper parent-child relationships in seeders:
   - About Us → Principal Message (parent_id)
   - About Us → Chairman Message (parent_id)
   - Academic → Academic Program (parent_id)
   - etc.

### View Templates

1. **Template Selection**: `PageController` should determine which template to use:
   - Leadership pages → `pages/leadership.blade.php`
   - Category pages with children → `pages/category.blade.php`
   - Standard pages → `pages/page.blade.php`

2. **Template Logic**: Can be determined by:
   - Page slug (e.g., `principal-message`, `chairman-message`)
   - Page category
   - Custom field in Page model

### Error Handling

1. **404 Handling**: Return proper 404 page when:
   - Page doesn't exist
   - Page is not published
   - Page is scheduled for future publication

2. **Fallback Content**: If content is missing, show a friendly message rather than empty page

---

## Success Metrics

1. **Route Coverage**: 100% of navigation items have working routes (no 404 errors)

2. **View Coverage**: 100% of navigation items have corresponding views

3. **Data Coverage**: 100% of pages have actual content (not placeholder text)

4. **Design Consistency**: All pages match existing design system (verified visually)

5. **User Experience**: Navigation is intuitive and all links work as expected

6. **Performance**: Page load times remain acceptable (< 2 seconds)

---

## Open Questions

1. **Content Priority**: Should we prioritize exact content from `adbook.md` or is generated/structured content acceptable for some pages?

2. **Template Customization**: Do any pages need custom templates beyond the three standard templates (page, leadership, category)?

3. **Media Assets**: Should we include placeholder images for pages that don't have hero/featured images, or leave them without images?

4. **Breadcrumb Strategy**: Should breadcrumbs show the full navigation hierarchy or simplified paths?

5. **SEO Optimization**: Should we implement additional SEO features (structured data, Open Graph tags) beyond basic meta tags?

---

## Implementation Notes

### Key Files to Update/Create

1. **Routes**: `routes/web.php`
2. **Controllers**: `app/Http/Controllers/PageController.php`
3. **Services**: `app/Services/PageService.php`
4. **Models**: `app/Models/Page.php` (verify structure)
5. **Seeders**: `database/seeders/PagesSeeder.php`
6. **Views**: 
   - `resources/views/pages/page.blade.php` (update if needed)
   - `resources/views/pages/leadership.blade.php` (verify/update)
   - `resources/views/pages/category.blade.php` (verify/update)
   - Create new views if needed for specific page types

### Content Reference

- Primary source: `plan/adbook.md`
- Existing seeders: `database/seeders/PagesSeeder.php`
- Design reference: `resources/views/pages/about.blade.php`

### Testing Checklist

- [ ] All navigation items have working routes
- [ ] All routes display proper views
- [ ] All views match design system
- [ ] All pages have actual content
- [ ] Leadership pages use correct template
- [ ] Category pages show child pages correctly
- [ ] 404 errors are handled properly
- [ ] Mobile responsiveness works
- [ ] SEO metadata is present
- [ ] Breadcrumbs work correctly

---

**Document Version**: 1.0  
**Last Updated**: 2025-01-XX  
**Status**: Draft - Awaiting Approval

