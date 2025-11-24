# Product Requirements Document: Navigation Update for Duha International School

## Introduction/Overview

This PRD outlines the requirements for updating the header/navigation structure of the Duha International School Laravel website to match a comprehensive navigation menu with dropdowns, top bar elements, and responsive behavior. The current navigation structure needs to be replaced with a new structure that includes:

- Main navigation menu with dropdown submenus
- Top bar with social media links, contact information, and action buttons
- Responsive behavior for mobile and desktop viewports
- Integration with existing routing system

**Problem Statement:** The current navigation structure does not match the desired menu hierarchy and lacks the top bar utility elements (social links, contact info, quick action buttons) that are essential for user engagement and quick access to important pages.

**Goal:** Implement a complete navigation system that provides intuitive access to all school information, maintains consistency across devices, and enhances user experience through quick access to key resources.

---

## Goals

1. **Update Navigation Structure**: Replace existing navigation items with the new menu structure including Home, About, Admission, Academic, Faculty, Facilities, Tahfeez, and Contact with their respective dropdown submenus.

2. **Implement Top Bar**: Add a top bar above the main navigation that displays social media links, contact information (phone and email), and action buttons (Notice, News, Career, FAQ, Apply Online) with responsive behavior.

3. **Ensure Route Compatibility**: Support both route-based navigation (using Laravel route names) and slug-based URLs, with intelligent fallback when routes don't exist.

4. **Create Missing Routes**: Automatically create routes and pages for navigation items that don't currently exist in the system.

5. **Maintain Responsive Design**: Ensure the navigation works seamlessly on mobile, tablet, and desktop viewports with appropriate UI adaptations.

6. **Add Login Link**: Include login functionality in the main navigation menu.

---

## User Stories

### US-1: As a website visitor, I want to see social media links and contact information at the top of the page
**Acceptance Criteria:**
- Top bar displays social media icons (Facebook, YouTube, LinkedIn, Instagram) with links
- Contact phone number and email are visible and clickable
- Top bar is visible on desktop and accessible on mobile (collapsible)

### US-2: As a website visitor, I want quick access to important pages from the top bar
**Acceptance Criteria:**
- Desktop shows: Notice, News, Career, FAQ, Apply Online buttons
- Mobile shows: Notice, News, Apply buttons
- All buttons link to correct pages
- Buttons have consistent styling and hover effects

### US-3: As a website visitor, I want to navigate through the main menu with dropdown submenus
**Acceptance Criteria:**
- Main menu items (Home, About, Admission, Academic, Faculty, Facilities, Tahfeez, Contact) are visible
- Dropdown menus appear on hover (desktop) or click (mobile)
- All submenu items are accessible and link to correct pages
- Active page is highlighted in navigation

### US-4: As a website visitor, I want to access the login page from the navigation
**Acceptance Criteria:**
- Login link is visible in the main navigation menu
- Login link points to https://duhais.com/login
- Link opens in same window (not external)

### US-5: As a mobile user, I want to access all navigation features in a mobile-friendly way
**Acceptance Criteria:**
- Mobile menu (hamburger) is functional
- Top bar elements are accessible via collapsible section
- Dropdown menus work with touch interactions
- All navigation items are easily tappable

---

## Functional Requirements

### FR-1: Navigation Menu Structure

**FR-1.1**: The main navigation MUST include the following top-level items in order:
1. Home (route: `/` or `home`)
2. About (dropdown parent)
3. Admission (dropdown parent)
4. Academic (dropdown parent)
5. Faculty (dropdown parent)
6. Facilities (dropdown parent)
7. Tahfeez (single link)
8. Contact (single link)

**FR-1.2**: The About dropdown MUST include:
- About Duha  (`/about`)
- Chairman Message (`/chairman-message`)
- Principal Message (`/principal-message`)
- Governing Body (`/governing-body`)
- Academic Committee (`/academic-committee`)
- Campus Facilities (`/campus-facilities`)
- School Uniform (`/school-uniform`)
- FAQ (`/faq`)

**FR-1.3**: The Admission dropdown MUST include:
- Admission Procedure (`/admission-process`)
- Why Us? (`/why-us`)
- Enroll Online (`/choose-apply`)
- Fees (`/fees`)
- Student Year Group and Age Range (`/year-group`)

**FR-1.4**: The Academic dropdown MUST include:
- Academic Program (`/academic-program`)
- Academic Calendar (`/academic-calendar`)
- Subjects We Teach (`/subjects`)
- Tahfeez Program (`/tahfeez-program`)
- Tahili Program (`/tahili-program`)
- Future Progression (`/future-progression`)
- Duha Curriculum (`/curriculum`)
- Exam System (`/exam-system`)
- ZA Policies (`/policies`)
- Class Routine (`/class-routine`)
- Sports & Recreation (`/sports`)
- Events & Activities (`/events-activities`)

**FR-1.5**: The Faculty dropdown MUST include:
- Male Faculty (`/male-faculty`)
- Female Faculty (`/female-faculty`)

**FR-1.6**: The Facilities dropdown MUST include:
- Residential Facilities (`/residential-facilities`)
- Support for learning and spiritual development (`/support-learning`)
- Parent Teacher Association (`/parent-association`)

**FR-1.7**: Navigation items MUST support both route-based URLs (using Laravel `route()` helper) and slug-based URLs, with intelligent fallback:
- If `route_name` exists and route is registered, use `route($route_name)`
- If `route_name` doesn't exist or route is not registered, use slug-based URL (`/slug`)
- If neither exists, use the `url` field if provided

**FR-1.8**: Dropdown menus MUST open on hover for desktop and click for mobile/tablet.

**FR-1.9**: If a parent menu item has children, clicking the parent on desktop MUST open the dropdown. If the parent also has its own URL, clicking the parent text/link MUST navigate to that URL.

**FR-1.10**: The Login link MUST be included in the main navigation menu and point to `https://duhais.com/login`.

### FR-2: Top Bar Elements

**FR-2.1**: A top bar MUST be displayed above the main navigation with the following sections:
- Left: Social media icons
- Right: Contact information and action buttons

**FR-2.2**: Social media links MUST include:
- Facebook: `https://www.facebook.com/Duhactg/`
- YouTube: `https://www.youtube.com/@DuhaAcademy`
- LinkedIn: `#` (placeholder)
- Instagram: `#` (placeholder)

**FR-2.3**: Contact information MUST display:
- Phone: `+880 1748806492` (clickable, opens phone dialer)
- Email: `Duhaacademy.bd@gmail.com` (clickable, opens email client)

**FR-2.4**: Desktop top bar action buttons MUST include (in order):
- Notice (`/all-notice`)
- News (`/all-news`)
- Career (`/career`)
- FAQ (`/faq`)
- Apply Online (`/choose-apply`)

**FR-2.5**: Mobile top bar action buttons MUST include (in order):
- Notice (`/all-notice`)
- News (`/all-news`)
- Apply (`/choose-apply`)

**FR-2.6**: On mobile viewports, the top bar social/contact section MUST be collapsible (can be expanded/collapsed).

**FR-2.7**: Top bar MUST have background color matching the primary brand color (`#008236`).

**FR-2.8**: Action buttons MUST have yellow background (`#fbbf24`) with green text (`#008236`) and hover effects.

### FR-3: Route Creation

**FR-3.1**: The system MUST automatically create routes for navigation items that don't have existing routes.

**FR-3.2**: Routes MUST be created using slug-based naming convention (e.g., `/chairman-message`).

**FR-3.3**: Routes that don't exist MUST be handled gracefully with a fallback to slug-based URLs.

**FR-3.4**: All routes MUST be registered in `routes/web.php` or dynamically handled through a catch-all route for pages.

### FR-4: Responsive Behavior

**FR-4.1**: On desktop (≥1024px):
- Top bar is fully visible with all elements
- Main navigation is horizontal
- Dropdowns open on hover
- All action buttons are visible

**FR-4.2**: On tablet (768px - 1023px):
- Top bar is visible but may stack elements
- Main navigation uses hamburger menu
- Dropdowns open on click
- Action buttons may be reduced

**FR-4.3**: On mobile (<768px):
- Top bar social/contact section is collapsible
- Main navigation uses hamburger menu
- Dropdowns open on click/tap
- Only essential action buttons are shown (Notice, News, Apply)

**FR-4.4**: Mobile menu MUST slide in from the side (right) when opened.

**FR-4.5**: Mobile menu MUST close when clicking outside or pressing Escape key.

### FR-5: Navigation Data Management

**FR-5.1**: Navigation items MUST be stored in the `navigation_items` database table.

**FR-5.2**: Navigation structure MUST be seeded via `NavigationSeeder`.

**FR-5.3**: Navigation items MUST support:
- `title`: Display text
- `slug`: URL slug (e.g., `chairman-message`)
- `route_name`: Laravel route name (optional)
- `url`: Direct URL (optional, for external links)
- `parent_id`: For hierarchical structure
- `sort_order`: For ordering
- `is_active`: To enable/disable items
- `section`: 'main' for main navigation

**FR-5.4**: Navigation cache MUST be cleared when navigation items are updated.

---

## Non-Goals (Out of Scope)

1. **Admin Interface for Navigation**: This PRD does not include building an admin interface to manage navigation items (though one may exist). Navigation will be updated via seeder.

2. **Multi-language Support**: This PRD does not include implementing multi-language navigation menus.

3. **User Role-Based Navigation**: This PRD does not include showing different navigation items based on user roles (except login link visibility).

4. **Search Functionality**: This PRD does not include adding a search bar to the navigation.

5. **Mega Menu Design**: This PRD does not include implementing mega menu layouts with images or rich content.

6. **Breadcrumb Navigation**: This PRD does not include implementing breadcrumb navigation.

7. **Analytics Integration**: This PRD does not include tracking navigation clicks or user behavior.

---

## Design Considerations

### Visual Design

1. **Top Bar**:
   - Background: Primary green (`#008236`)
   - Text: White (`#ffffff`)
   - Height: ~40px on desktop
   - Font size: 12px (text-xs)

2. **Action Buttons**:
   - Background: Yellow (`#fbbf24`)
   - Text: Green (`#008236`)
   - Hover: Darker yellow (`#f59e0b`)
   - Padding: 8px 12px
   - Border radius: 4px
   - Font weight: Medium

3. **Main Navigation**:
   - Background: White
   - Text: Dark gray (`#1f2937`)
   - Active state: Primary green (`#008236`)
   - Hover: Light gray background
   - Font size: 14px (text-sm)

4. **Dropdown Menus**:
   - Background: White
   - Shadow: Medium shadow for depth
   - Border: Light gray border
   - Min width: 220px
   - Padding: 8px 0

5. **Mobile Menu**:
   - Full-screen overlay or slide-in panel
   - Background: White
   - Close button: Top right
   - Menu items: Full width, touch-friendly (min 44px height)

### Component Structure

The navigation should use the existing `header-zaitoon` component structure with:
- Top bar section (new)
- Main navigation bar (existing, updated)
- Mobile menu (existing, updated)

### Accessibility

- All navigation links MUST have proper ARIA labels
- Keyboard navigation MUST work (Tab, Enter, Escape)
- Focus states MUST be visible
- Screen reader announcements for dropdown state changes

---

## Technical Considerations

### Dependencies

1. **Existing Components**: 
   - `resources/views/components/header-zaitoon.blade.php` - Main header component
   - `app/View/Components/Navbar.php` - Navbar component class
   - `app/Services/NavigationService.php` - Navigation service
   - `app/Repositories/NavigationRepository.php` - Navigation repository

2. **Database**:
   - `navigation_items` table (already exists)
   - Migration may need updates if new fields are required

3. **Routes**:
   - Existing route structure in `routes/web.php`
   - May need to add catch-all route for dynamic pages

### Implementation Approach

1. **Update NavigationSeeder**: 
   - Replace existing navigation structure with new menu items
   - Create all parent and child navigation items
   - Set proper sort_order and parent_id relationships

2. **Update Header Component**:
   - Add top bar section with social links, contact info, and buttons
   - Update main navigation to use new structure
   - Add responsive behavior for mobile
   - Implement collapsible top bar section for mobile

3. **Route Handling**:
   - Check if routes exist before using `route()` helper
   - Fallback to slug-based URLs when routes don't exist
   - Create catch-all route for dynamic pages if needed

4. **Cache Management**:
   - Clear navigation cache when seeder runs
   - Ensure cache is cleared on navigation updates

### Files to Modify

1. `database/seeders/NavigationSeeder.php` - Update navigation structure
2. `resources/views/components/header-zaitoon.blade.php` - Add top bar and update navigation
3. `routes/web.php` - Add missing routes or catch-all route
4. `app/Models/NavigationItem.php` - Verify model supports all required fields
5. `app/Services/NavigationService.php` - May need updates for route fallback logic

### Potential Challenges

1. **Route Existence Checking**: Need to safely check if routes exist before using `route()` helper to avoid errors.

2. **Mobile Top Bar Collapsible**: Implementing collapsible section that works well on mobile without cluttering the interface.

3. **External Login Link**: The login link points to external URL (`https://duhais.com/login`), need to handle this appropriately.

4. **Button Responsive Behavior**: Different buttons on mobile vs desktop requires conditional rendering.

---

## Success Metrics

1. **Navigation Completeness**: All navigation items from the specification are present and functional (100% coverage).

2. **Route Functionality**: All navigation links work correctly (either via route or slug-based URL).

3. **Responsive Behavior**: Navigation works correctly on mobile, tablet, and desktop viewports.

4. **Top Bar Functionality**: All top bar elements (social links, contact info, buttons) are functional and accessible.

5. **Performance**: Navigation loads quickly and doesn't impact page load time significantly.

6. **Accessibility**: Navigation passes basic accessibility checks (keyboard navigation, screen reader compatibility).

---

## Open Questions

1. **Login Link Visibility**: Should the login link be visible to all users or only when logged out? (Assumed: visible to all for now)

2. **External Links**: Should external links (like login URL) open in the same window or new tab? (Assumed: same window)

3. **Top Bar Visibility**: Should the top bar be sticky/fixed or scroll with the page? (Assumed: fixed at top)

4. **Missing Page Content**: What should happen when a user clicks a navigation item that doesn't have a corresponding page yet? (Assumed: Show 404 or placeholder page)

5. **Social Media Links**: Should placeholder links (#) for LinkedIn and Instagram be updated later, or should they be hidden until real URLs are available? (Assumed: Show with # for now)

---

## Appendix

### Navigation Structure Summary

```
Home (/)
About (dropdown)
  ├─ About Duha  (/about)
  ├─ Chairman Message (/chairman-message)
  ├─ Principal Message (/principal-message)
  ├─ Governing Body (/governing-body)
  ├─ Academic Committee (/academic-committee)
  ├─ Campus Facilities (/campus-facilities)
  ├─ School Uniform (/school-uniform)
  └─ FAQ (/faq)
Admission (dropdown)
  ├─ Admission Procedure (/admission-process)
  ├─ Why Us? (/why-us)
  ├─ Enrol Online (/choose-apply)
  ├─ Fees (/fees)
  └─ Student Year Group and Age Range (/year-group)
Academic (dropdown)
  ├─ Academic Program (/academic-program)
  ├─ Academic Calendar (/academic-calendar)
  ├─ Subjects We Teach (/subjects)
  ├─ Tahfeez Program (/tahfeez-program)
  ├─ Tahili Program (/tahili-program)
  ├─ Future Progression (/future-progression)
  ├─ Duha Curriculum (/curriculum)
  ├─ Exam System (/exam-system)
  ├─ ZA Policies (/policies)
  ├─ Class Routine (/class-routine)
  ├─ Sports & Recreation (/sports)
  └─ Events & Activities (/events-activities)
Faculty (dropdown)
  ├─ Male Faculty (/male-faculty)
  └─ Female Faculty (/female-faculty)
Facilities (dropdown)
  ├─ Residential Facilities (/residential-facilities)
  ├─ Support for learning and spiritual development (/support-learning)
  └─ Parent Teacher Association (/parent-association)
Tahfeez (/tahfeez)
Contact (/contact)
Login (https://duhais.com/login)
```

### Top Bar Elements Summary

**Social Media:**
- Facebook: https://www.facebook.com/Duhactg/
- YouTube: https://www.youtube.com/@DuhaAcademy
- LinkedIn: # (placeholder)
- Instagram: # (placeholder)

**Contact:**
- Phone: +880 1748806492
- Email: Duhaacademy.bd@gmail.com

**Action Buttons (Desktop):**
- Notice (/all-notice)
- News (/all-news)
- Career (/career)
- FAQ (/faq)
- Apply Online (/choose-apply)

**Action Buttons (Mobile):**
- Notice (/all-notice)
- News (/all-news)
- Apply (/choose-apply)

---

**Document Version:** 1.0  
**Created:** 2025-01-XX  
**Last Updated:** 2025-01-XX  
**Status:** Ready for Implementation

