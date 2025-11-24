---
inclusion: always
---

# Product Context: Duha International School Website

Bilingual (English/Bengali) school information and management platform for an Islamic international school in Chattogram, Bangladesh.

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

## Common Pitfalls

- ❌ Hardcoding English text instead of using `__('common.key')`
- ❌ Rendering media without fallback to placeholder
- ❌ Forgetting to check `is_active` on homepage sections (not `is_visible`)
- ❌ Missing eager loading causing N+1 queries
- ❌ Forgetting role checks in admin controllers (use `EnsureUserHasRole` middleware)
- ❌ Direct model queries in controllers (use repositories)
- ❌ Missing cache invalidation in observers
- ❌ Not clearing `homepage_v2_data` cache when updating content
- ❌ Putting slug generation in observers instead of model boot() method
