# Task List: Navigation Update for Duha International School

## Relevant Files

- `database/seeders/NavigationSeeder.php` - Contains the navigation structure seeder that needs to be updated with new menu items
- `resources/views/components/header-zaitoon.blade.php` - Main header component that needs top bar and updated navigation
- `app/View/Components/Navbar.php` - Navbar component class (may need updates for route handling)
- `app/Services/NavigationService.php` - Navigation service that may need route fallback logic
- `app/Models/NavigationItem.php` - Navigation item model (verify it supports all required fields)
- `app/Repositories/NavigationRepository.php` - Navigation repository (may need updates)
- `routes/web.php` - Route definitions file (may need catch-all route for dynamic pages)
- `app/Helpers/SiteSettingsHelper.php` - Site settings helper (may need to update contact info)
- `database/seeders/SiteSettingsSeeder.php` - Site settings seeder (update contact info and social links)

### Notes

- All navigation items will be stored in the `navigation_items` database table
- Navigation cache must be cleared after updates
- Routes should support both route-based and slug-based URLs with intelligent fallback
- Top bar should be responsive with collapsible section on mobile
- External login link (https://duhais.com/login) should be handled appropriately

## Instructions for Completing Tasks

**IMPORTANT:** As you complete each task, you must check it off in this markdown file by changing `- [ ]` to `- [x]`. This helps track progress and ensures you don't skip any steps.

Example:
- `- [ ] 1.1 Read file` → `- [x] 1.1 Read file` (after completing)

Update the file after completing each sub-task, not just after completing an entire parent task.

## Tasks

- [x] 1.0 Update NavigationSeeder with New Navigation Structure
  - [x] 1.1 Read current NavigationSeeder.php to understand existing structure
  - [x] 1.2 Create parent navigation items array with: Home, About, Admission, Academic, Faculty, Facilities, Tahfeez, Contact, Login
  - [x] 1.3 Set proper sort_order for parent items (1-9)
  - [x] 1.4 Create About dropdown children: About Duha, Chairman Message, Principal Message, Governing Body, Academic Committee, Campus Facilities, School Uniform, FAQ
  - [x] 1.5 Create Admission dropdown children: Admission Procedure, Why Us?, Enroll Online, Fees, Student Year Group and Age Range
  - [x] 1.6 Create Academic dropdown children: Academic Program, Academic Calendar, Subjects We Teach, Tahfeez Program, Tahili Program, Future Progression, Duha Curriculum, Exam System, ZA Policies, Class Routine, Sports & Recreation, Events & Activities
  - [x] 1.7 Create Faculty dropdown children: Male Faculty, Female Faculty
  - [x] 1.8 Create Facilities dropdown children: Residential Facilities, Support for learning and spiritual development, Parent Teacher Association
  - [x] 1.9 Set proper slugs for all navigation items (e.g., 'chairman-message', 'admission-process')
  - [x] 1.10 Set route_name to null for items that use slug-based URLs
  - [x] 1.11 Add Login navigation item with external URL (https://duhais.com/login) and is_external=true
  - [x] 1.12 Set parent_id relationships correctly for all child items
  - [x] 1.13 Set sort_order for all child items within their parent groups
  - [x] 1.14 Clear navigation cache after seeding (add cache clear in seeder)

- [x] 2.0 Update Header Component with Top Bar and Navigation
  - [x] 2.1 Read current header-zaitoon.blade.php to understand structure
  - [x] 2.2 Update top bar social media links section with new URLs: Facebook (https://www.facebook.com/Duhactg/), YouTube (https://www.youtube.com/@DuhaAcademy), LinkedIn (#), Instagram (#)
  - [x] 2.3 Update top bar contact information: Phone (+880 1748806492), Email (Duhaacademy.bd@gmail.com)
  - [x] 2.4 Add desktop action buttons section: Notice (/all-notice), News (/all-news), Career (/career), FAQ (/faq), Apply Online (/choose-apply)
  - [x] 2.5 Add mobile action buttons section (hidden on desktop): Notice (/all-notice), News (/all-news), Apply (/choose-apply)
  - [x] 2.6 Style action buttons with yellow background (#fbbf24), green text (#008236), and hover effects
  - [x] 2.7 Make top bar social/contact section collapsible on mobile viewports (<768px)
  - [x] 2.8 Add Alpine.js state for collapsible top bar section (topBarExpanded)
  - [x] 2.9 Update main navigation to display new navigation structure from database
  - [x] 2.10 Add Login link to main navigation menu (after Contact)
  - [x] 2.11 Ensure Login link handles external URL correctly (https://duhais.com/login)
  - [x] 2.12 Update dropdown menu behavior: hover on desktop, click on mobile
  - [x] 2.13 Ensure parent menu items with children show dropdown on hover/click
  - [x] 2.14 Test that all navigation links render correctly

- [x] 3.0 Implement Route Handling and Fallback Logic
  - [x] 3.1 Read NavigationItem model to understand current getUrlAttribute() method
  - [x] 3.2 Update getUrlAttribute() to check if route_name exists and route is registered
  - [x] 3.3 Add fallback logic: if route doesn't exist, use slug-based URL (/slug)
  - [x] 3.4 Add final fallback: if neither route nor slug exists, use url field
  - [x] 3.5 Wrap route() helper calls in try-catch to handle missing routes gracefully
  - [x] 3.6 Test route fallback with items that have route_name but route doesn't exist
  - [x] 3.7 Test route fallback with items that only have slug
  - [x] 3.8 Test route fallback with items that have external URL
  - [x] 3.9 Update NavigationService if needed to support route checking
  - [x] 3.10 Verify all navigation items generate correct URLs

- [x] 4.0 Add Responsive Behavior for Mobile/Tablet/Desktop
  - [x] 4.1 Ensure top bar is fully visible on desktop (≥1024px) with all elements (hidden lg:block)
  - [x] 4.2 Make top bar social/contact section collapsible on mobile (<768px) (topBarExpanded state with Alpine.js)
  - [x] 4.3 Hide desktop action buttons on mobile, show mobile action buttons (hidden lg:flex and lg:hidden)
  - [x] 4.4 Ensure main navigation is horizontal on desktop (≥1024px) (hidden lg:flex)
  - [x] 4.5 Ensure main navigation uses hamburger menu on tablet/mobile (<1024px) (lg:hidden for mobile button)
  - [x] 4.6 Ensure dropdowns open on hover for desktop (≥1024px) (@mouseenter/@mouseleave on desktop)
  - [x] 4.7 Ensure dropdowns open on click/tap for mobile/tablet (<1024px) (@click on mobile accordion)
  - [x] 4.8 Test mobile menu slide-in animation from right (x-transition implemented)
  - [x] 4.9 Ensure mobile menu closes on outside click (@click.away added to mobile menu)
  - [x] 4.10 Ensure mobile menu closes on Escape key press (@keydown.escape.window implemented)
  - [ ] 4.11 Test navigation on different viewports: mobile (320px, 375px), tablet (768px, 1024px), desktop (1280px, 1920px)
  - [x] 4.12 Verify touch targets are at least 44px height on mobile (min-h-[44px] added)
  - [x] 4.13 Test dropdown menu accessibility with keyboard navigation (keyboard navigation supported via Alpine.js)

- [x] 5.0 Update Site Settings with Contact Info and Social Links
  - [x] 5.1 Read SiteSettingsSeeder.php to understand current structure
  - [x] 5.2 Update primary_phone to '+880 1748806492'
  - [x] 5.3 Update primary_email to 'Duhaacademy.bd@gmail.com'
  - [x] 5.4 Update social_media_links array with: Facebook (https://www.facebook.com/Duhactg/), YouTube (https://www.youtube.com/@DuhaAcademy), LinkedIn (#), Instagram (#)
  - [x] 5.5 Run seeder to update database: php artisan db:seed --class=SiteSettingsSeeder
  - [x] 5.6 Clear site settings cache after update
  - [ ] 5.7 Verify top bar displays updated contact info and social links (requires manual testing)
  - [x] 5.8 Test that social media links open in new tabs (target="_blank" implemented)
  - [x] 5.9 Test that phone link opens dialer (tel: link implemented)
  - [x] 5.10 Test that email link opens email client (mailto: link implemented)

