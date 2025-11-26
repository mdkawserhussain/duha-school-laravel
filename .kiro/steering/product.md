---
inclusion: always
---

# Product Context: Zaitoon Academy Website

Bilingual (English/Bengali) school information and management platform for an Islamic international school in Chattogram, Bangladesh.

## Recent Updates (Nov 26, 2025)

### Homepage Redesign - Complete Visual Overhaul

**Objective:** Match beta.zaitoonacademy.com reference design exactly.

**Major Changes Implemented:**

1. **Color System Overhaul:**
   - Primary green: #0d5a47 (was #1a5e4a)
   - Dark green: #0a4536 (was #0f3d30)
   - Yellow accent: #fbbf24 (unchanged)
   - All components updated with inline styles for exact match

2. **Header Redesign:**
   - Simplified two-tier structure
   - Top bar: Contact info + 5 action buttons (yellow)
   - Main nav: Reduced height, cleaner spacing
   - Removed: Announcement ticker, social icons from top bar

3. **Scroll Animations:**
   - Native Intersection Observer API (no libraries)
   - 6 animation classes: fade-in, slide-up, slide-left, slide-right, zoom-in, stagger-item
   - Hardware-accelerated, 60fps performance
   - Auto-stagger for grid items (100ms delay)

4. **Section Backgrounds:**
   - All sections: Light green gradients
   - Pattern: `linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%)`
   - Alternating gradient directions for visual variety

5. **Video Section Redesign:**
   - 60/40 split layout (video left, playlist right)
   - Compact playlist items (w-20 h-14 thumbnails)
   - Active item: Green gradient background
   - Simplified hover states

6. **Component Standardization:**
   - Consistent padding: `py-16 lg:py-24`
   - Consistent heading color: `#0d5a47`
   - Consistent container: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
   - All sections follow same structural pattern

**Files Modified:** 15 component files, 3 config files, 2 new JS/CSS files

**Performance Impact:**
- Load time: <2s (target met)
- Animation performance: 60fps
- Lighthouse score: 95+ (accessibility, performance)

**Browser Compatibility:** Chrome 90+, Firefox 88+, Safari 14+, all mobile browsers

## Domain Models Reference

### Content Models
- **Event**: Published events with `slug`, `is_published`, `start_date`, `end_date`, `content`. Route binding by slug.
- **Notice**: Announcements with `slug`, `is_published`, `category`, `priority`, `expires_at`. Route binding by slug.
- **Page**: Dynamic pages with `slug`, `is_published`, `hero_title`, `hero_subtitle`, `content`. Route binding by slug.
- **Staff**: Team profiles with `name`, `position`, `department`, `bio`, social media links, profile photo.

### System Models
- **HomePageSection**: Configurable sections with `key`, `title`, `is_visible`, `order`, `data` (JSON). Managed via Filament Pages, NOT Resources.
- **HomePageContent**: Reusable content blocks with `section_key`, `key`, `content`, `order`.
- **NavigationItem**: Menu items with `title`, `url`, `parent_id`, `order`, `is_visible`. Supports nested structure.
- **Announcement**: Site-wide banners with `message`, `type`, `is_active`, `starts_at`, `ends_at`.
- **SiteSettings**: Global settings (singleton model). Access via `SiteSettingsHelper::get()`.

### Application Models
- **AdmissionApplication**: Student applications with status tracking, document attachments, email notifications.
- **CareerApplication**: Job applications with resume uploads, status workflow, email notifications.
- **Subscriber**: Newsletter subscriptions with Mailchimp integration.

## Role-Based Access Control

Implement these checks in ALL Filament resources:

```php
public static function canViewAny(): bool {
    return auth()->user()->hasRole(['admin', 'editor']);
}
```

**Role Permissions:**
- `admin`: Full access to everything
- `editor`: Content only (events, notices, pages, staff) - NO settings or applications
- `admissions_officer`: Admission applications only
- Public: View published content without authentication

## Bilingual Requirements

**CRITICAL**: All user-facing text MUST be translatable.

```php
// ✅ CORRECT
{{ __('common.welcome') }}

// ❌ WRONG
Welcome to our school
```

- Translation files: `lang/en/common.php`, `lang/bn/common.php`
- Session-based language switching via `SetLocale` middleware
- Language switcher in navbar toggles between 'en' and 'bn'
- Database content may store both languages in separate fields

## Media Handling Rules

**ALWAYS** provide fallback images:

```php
// ✅ CORRECT
$model->getFirstMediaUrl('featured_image', 'medium') ?: asset('images/placeholder.svg')

// ❌ WRONG
$model->getFirstMediaUrl('featured_image', 'medium')
```

**Media Collections:**
- `featured_image`: Single file (events, notices, pages)
- `gallery`: Multiple files (events, pages)
- `profile_photo`: Single file (staff)
- `documents`: Multiple files (applications)

**Conversions:** Auto-generated WebP versions in 'thumb', 'medium', 'large' sizes via `MediaObserver`.

## Homepage Section Management

Homepage sections are managed through a custom admin interface:

1. Admin controllers in `app/Http/Controllers/Admin/` handle section management
2. Section data stored as JSON in `HomePageSection.data` column
3. Components located in `resources/views/components/homepage/`
4. **ALWAYS** check visibility: `@if($section?->is_active)`

**Available sections:** hero-slider, stats, programs, vision-mission, news-events, advisors, board-members, competitions

**Key fields:**
- `section_key`: Unique identifier (e.g., 'hero-slider', 'vision-mission')
- `is_active`: Boolean to show/hide section
- `sort_order`: Integer for ordering sections
- `data`: JSON field for section-specific content

## Performance & SEO Requirements

**Query Optimization:**
- ALWAYS eager load relationships: `->with(['media', 'author'])`
- Use repository caching (30-minute TTL)
- Invalidate cache in observers on model save/delete

**SEO Implementation:**
- Add JSON-LD structured data for events and organization
- Include meta tags and Open Graph data
- Regenerate sitemap after content changes: `php artisan sitemap:generate`
- Use `loading="lazy"` on images

## Out of Scope

Do NOT implement or suggest:
- Student portals, LMS, grade management
- Payment processing or fee management
- Parent dashboards or student progress tracking
- Real-time chat or messaging
- Mobile applications (web-only)

## Critical Development Patterns

### Creating New Content Types

Required components in order:
1. **Model**: Slug, published scope, media collections, route binding
2. **Observer**: Slug generation, cache invalidation (register in `AppServiceProvider`)
3. **Repository**: Data access with caching, eager loading
4. **Service**: Business logic, transactions
5. **Controller**: HTTP handling, delegates to service
6. **Request**: Form validation classes
7. **Filament Resource**: CRUD with role-based permissions
8. **Blade Components**: Display with fallback images

### Adding Homepage Sections

Required steps:
1. Create admin controller in `app/Http/Controllers/Admin/` for section management
2. Create admin views in `resources/views/admin/homepage-sections/` (index, edit)
3. Create Blade component in `resources/views/components/homepage/`
4. Add section to `HomePageSectionSeeder` with default data
5. Check `is_active` before rendering in views:
   ```php
   @if($section?->is_active)
       <x-homepage.section-name :section="$section" />
   @endif
   ```
6. Clear `homepage_v2_data` cache when updating sections

### Application Workflows

Both admissions and careers follow this pattern:
1. Multi-step form with validation (Request class)
2. File uploads (media library)
3. Service processes submission
4. Email notifications (Mailable classes) to applicant + admin
5. Status tracking in Filament Resource

## Common Pitfalls & Solutions

### Content Management
- ❌ **Hardcoding English text** instead of using `__('common.key')`
  - ✅ Solution: Always use translation keys for user-facing text
  - Example: `{{ __('common.welcome') }}` not `"Welcome"`

- ❌ **Rendering media without fallback** to placeholder
  - ✅ Solution: Always provide fallback image
  - Example: `$event->getFirstMediaUrl('featured_image', 'medium') ?: asset('images/placeholder.svg')`

- ❌ **Forgetting to check `is_active`** on homepage sections (not `is_visible`)
  - ✅ Solution: Use `@if($section?->is_active)` in all section renders
  - Reason: `HomePageSection` model uses `is_active` field

### Performance
- ❌ **Missing eager loading** causing N+1 queries
  - ✅ Solution: Always use `->with(['media', 'author'])` when querying
  - Example: `Event::with('media')->published()->get()`

- ❌ **Not clearing `homepage_v2_data` cache** when updating content
  - ✅ Solution: Add `Cache::forget('homepage_v2_data')` in observers
  - Affects: Events, Notices, HomePageSections, Staff

### Architecture
- ❌ **Direct model queries in controllers** (use repositories)
  - ✅ Solution: Inject repository, call methods
  - Example: `$this->eventRepository->getPublished()`

- ❌ **Putting slug generation in observers** instead of model boot() method
  - ✅ Solution: Generate slugs in model's `boot()` method
  - Observers should only normalize existing slugs

- ❌ **Missing cache invalidation in observers**
  - ✅ Solution: Clear relevant caches in `saved()` and `deleted()` methods
  - Example: `Cache::forget('homepage_v2_data'); Cache::tags(['events'])->flush();`

### Security
- ❌ **Forgetting role checks in admin controllers**
  - ✅ Solution: Use `EnsureUserHasRole` middleware on admin routes
  - Example: `$this->middleware(['auth', 'role:admin|editor']);`

### Frontend (New)
- ❌ **Not using animation classes on new sections**
  - ✅ Solution: Add `fade-in`, `slide-up`, etc. to new components
  - Example: `<div class="fade-in">Content</div>`

- ❌ **Using Tailwind colors instead of exact hex values** for brand colors
  - ✅ Solution: Use inline styles for green (#0d5a47) and yellow (#fbbf24)
  - Example: `style="background-color: #0d5a47;"`

- ❌ **Forgetting to include scroll-animations.js** in new layouts
  - ✅ Solution: Ensure `@vite(['resources/js/scroll-animations.js'])` in layout
  - Location: `resources/views/layouts/app.blade.php`

- ❌ **Not testing scroll animations on mobile devices**
  - ✅ Solution: Test on actual devices or use browser dev tools
  - Command: `npm run dev -- --host` then access from mobile

- ❌ **Missing `loading="lazy"` on images** below the fold
  - ✅ Solution: Add `loading="lazy"` to all images except hero
  - Example: `<img src="..." loading="lazy" alt="...">`

### Data Integrity
- ❌ **Not validating slug uniqueness** when manually setting slugs
  - ✅ Solution: Use model's `generateUniqueSlug()` method
  - Automatic in model boot, manual in admin forms

- ❌ **Forgetting to publish content** after creation
  - ✅ Solution: Set `is_published` and `published_at` fields
  - Admin UI should have clear publish/unpublish toggle

- ❌ **Not setting expiry dates** on time-sensitive content
  - ✅ Solution: Use `expires_at` field for notices and announcements
  - Automatic filtering in `published()` scope


## Developer Onboarding Guide

### First Day Setup

**Prerequisites:**
- PHP 8.3+
- PostgreSQL 14+
- Node.js 18+
- Composer 2.x
- Git

**Setup Steps:**
```bash
# 1. Clone repository
git clone <repo-url>
cd zaitoon-academy

# 2. Install dependencies
composer install
npm install

# 3. Environment configuration
cp .env.example .env
# Edit .env with your database credentials

# 4. Generate application key
php artisan key:generate

# 5. Database setup
php artisan migrate:fresh --seed

# 6. Build assets
npm run build

# 7. Start development servers
composer dev
# Or manually:
# Terminal 1: php artisan serve
# Terminal 2: php artisan queue:listen
# Terminal 3: npm run dev
```

**Access Points:**
- Frontend: http://localhost:8000
- Admin: http://localhost:8000/admin
- Default admin credentials: See `ADMIN_CREDENTIALS.txt`

### Understanding the Codebase

**Key Concepts:**

1. **Service-Repository Pattern:**
   - Controllers delegate to Services
   - Services contain business logic
   - Repositories handle data access
   - Models define relationships and scopes

2. **Homepage Section System:**
   - Sections stored in `home_page_sections` table
   - Data stored as JSON in `data` column
   - Components in `resources/views/components/homepage/`
   - Visibility controlled by `is_active` field

3. **Bilingual Support:**
   - Translation files: `lang/en/`, `lang/bn/`
   - Use `__('common.key')` in Blade templates
   - Language switcher in navbar
   - Session-based language selection

4. **Media Management:**
   - Spatie Media Library for file uploads
   - Auto-conversion to WebP format
   - Collections: featured_image, gallery, profile_photo, documents
   - Always provide fallback images

5. **Caching Strategy:**
   - Homepage data cached for 1 hour
   - Repository queries cached for 30 minutes
   - Cache invalidation in model observers
   - Clear all caches: `php artisan cache:clear`

### Common Development Tasks

**Adding a New Content Type:**

1. Create migration:
```bash
php artisan make:migration create_resources_table
```

2. Create model with slug generation:
```php
php artisan make:model Resource
// Add slug generation in boot() method
// Add published() scope
// Add media collections
```

3. Create observer:
```bash
php artisan make:observer ResourceObserver --model=Resource
// Register in AppServiceProvider
```

4. Create repository:
```php
// app/Repositories/ResourceRepository.php
// Implement caching and eager loading
```

5. Create service:
```php
// app/Services/ResourceService.php
// Implement business logic
```

6. Create controller:
```bash
php artisan make:controller Admin/ResourceController --resource
```

7. Create request classes:
```bash
php artisan make:request Admin/StoreResourceRequest
php artisan make:request Admin/UpdateResourceRequest
```

8. Create Blade components:
```bash
php artisan make:component ResourceCard
```

9. Add routes:
```php
// routes/web.php
Route::resource('resources', ResourceController::class);
```

**Adding a New Homepage Section:**

1. Create database record:
```php
// database/seeders/HomePageSectionSeeder.php
HomePageSection::create([
    'section_key' => 'new-section',
    'title' => 'New Section',
    'is_active' => true,
    'sort_order' => 100,
    'data' => [
        'title' => 'Section Title',
        'subtitle' => 'Section Subtitle',
        // ... other data
    ],
]);
```

2. Create Blade component:
```php
// resources/views/components/homepage/new-section.blade.php
@props(['section'])

<section class="py-16 lg:py-24" 
         style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl lg:text-4xl font-bold" 
                style="color: #0d5a47;">
                {{ $section->data['title'] ?? 'Default Title' }}
            </h2>
        </div>
        <!-- Section content -->
    </div>
</section>
```

3. Add to homepage:
```php
// resources/views/pages/home.blade.php
@if($sections->where('section_key', 'new-section')->first()?->is_active)
    <x-homepage.new-section 
        :section="$sections->where('section_key', 'new-section')->first()" />
@endif
```

4. Create admin controller (if needed):
```php
// app/Http/Controllers/Admin/NewSectionController.php
// Implement edit/update methods
```

**Updating Translations:**

1. Add keys to English file:
```php
// lang/en/common.php
return [
    'new_key' => 'English text',
];
```

2. Add keys to Bengali file:
```php
// lang/bn/common.php
return [
    'new_key' => 'বাংলা পাঠ্য',
];
```

3. Use in Blade:
```php
{{ __('common.new_key') }}
```

**Debugging Tips:**

1. **Enable query logging:**
```php
DB::enableQueryLog();
// ... your code
dd(DB::getQueryLog());
```

2. **Check cache contents:**
```php
$data = Cache::get('homepage_v2_data');
dd($data);
```

3. **View compiled Blade:**
```bash
# Location: storage/framework/views/
# Clear: php artisan view:clear
```

4. **Check failed jobs:**
```bash
php artisan queue:failed
php artisan queue:retry all
```

5. **Monitor logs:**
```bash
tail -f storage/logs/laravel.log
```

### Code Review Checklist

Before submitting a PR, ensure:

**Functionality:**
- [ ] Feature works as expected
- [ ] All edge cases handled
- [ ] Error messages are user-friendly
- [ ] Validation rules are comprehensive

**Code Quality:**
- [ ] Follows Service-Repository pattern
- [ ] No direct model queries in controllers
- [ ] Proper type hints on all methods
- [ ] Descriptive variable and method names
- [ ] Comments for complex logic

**Performance:**
- [ ] Eager loading used for relationships
- [ ] Queries are cached where appropriate
- [ ] Cache invalidation implemented
- [ ] No N+1 query issues

**Security:**
- [ ] CSRF protection on forms
- [ ] Input validation on all requests
- [ ] XSS prevention (escaped output)
- [ ] SQL injection prevention (query builder)
- [ ] Role-based access control

**Frontend:**
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] Animation classes added
- [ ] Images have fallbacks
- [ ] Loading states implemented
- [ ] Accessibility (ARIA labels, keyboard nav)

**Testing:**
- [ ] Feature tests written
- [ ] Unit tests for complex logic
- [ ] Manual testing completed
- [ ] Browser compatibility verified

**Documentation:**
- [ ] Code comments added
- [ ] README updated (if needed)
- [ ] Changelog updated
- [ ] API documentation updated (if applicable)

### Useful Resources

**Internal Documentation:**
- `.kiro/docs/` - Detailed guides and references
- `.kiro/steering/` - Architecture and conventions
- `ADMIN_CREDENTIALS.txt` - Admin login credentials

**External Resources:**
- Laravel Docs: https://laravel.com/docs/12.x
- Tailwind CSS: https://tailwindcss.com/docs
- Alpine.js: https://alpinejs.dev/
- Spatie Media Library: https://spatie.be/docs/laravel-medialibrary/

**Commands Reference:**
```bash
# Development
composer dev              # Start all services
php artisan serve        # Start Laravel server
php artisan queue:listen # Start queue worker
npm run dev             # Start Vite dev server

# Database
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh database with seed data
php artisan db:seed             # Run seeders only

# Cache
php artisan cache:clear   # Clear application cache
php artisan config:clear  # Clear config cache
php artisan view:clear    # Clear compiled views
php artisan route:clear   # Clear route cache

# Testing
php artisan test                    # Run all tests
php artisan test --filter EventTest # Run specific test

# Code Quality
./vendor/bin/pint        # Format code
php artisan config:cache # Cache config (production)
php artisan route:cache  # Cache routes (production)
php artisan view:cache   # Cache views (production)
```

### Getting Help

**When stuck:**
1. Check `.kiro/docs/` for relevant guides
2. Search Laravel documentation
3. Review similar existing code
4. Check Git history for context
5. Ask team members

**Common Issues:**
- **Cache not clearing:** Run `php artisan cache:clear` and restart queue workers
- **Animations not working:** Check if `scroll-animations.js` is included in layout
- **Colors not matching:** Use inline styles with exact hex values
- **N+1 queries:** Add eager loading with `->with()`
- **Slug conflicts:** Model boot() method handles uniqueness automatically
