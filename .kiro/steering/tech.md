---
inclusion: always
---

# Technology Stack & Development Guide

**Last Updated:** November 26, 2025

## Core Framework

- **Laravel 12** (PHP 8.3+)
- **PostgreSQL** database
- **Blade** templating engine
- **Tailwind CSS 4** for styling
- **Alpine.js** for lightweight interactivity
- **Vite** for asset bundling

## Key Packages

### Admin & CMS
- **Filament 4** - Admin panel with resource-based CRUD
- **Spatie Laravel Permission** - Role-based access control (admin, editor, admissions_officer)

### Media & Assets
- **Spatie Laravel Media Library** - File uploads and media management
- **Intervention Image** - Image processing and WebP conversion
- **Lightbox2** - Image gallery viewer

### Features
- **Laravel Scout** - Full-text search
- **Laravel Horizon** - Queue monitoring and management
- **Spatie Laravel Newsletter** - Mailchimp integration
- **Spatie Laravel Sitemap** - SEO sitemap generation
- **Sentry Laravel** - Error tracking and monitoring

### Development
- **Laravel Breeze** - Authentication scaffolding
- **Laravel Sail** - Docker development environment
- **PHPUnit** - Testing framework
- **Laravel Pint** - Code style fixer

## Common Commands

### Development
```bash
# Start development server (all services)
composer dev

# Individual services
php artisan serve
php artisan queue:listen
npm run dev

# Setup from scratch
composer setup
```

### Database
```bash
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
```

### Cache Management
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Queue & Jobs
```bash
php artisan queue:work
php artisan horizon
php artisan queue:failed
php artisan queue:retry all
```

### Testing
```bash
composer test
php artisan test
php artisan test --filter EventTest
```

### Code Quality
```bash
./vendor/bin/pint
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Media & Search
```bash
php artisan media-library:clean
php artisan scout:import "App\Models\Event"
php artisan scout:flush "App\Models\Event"
```

### Sitemap & SEO
```bash
php artisan sitemap:generate
```

## Build Process

### Production Build
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Asset Compilation
- Vite compiles `resources/css/app.css` and `resources/js/app.js`
- Tailwind processes utility classes from Blade templates
- HMR disabled for Blade changes (manual refresh required)

## Environment Configuration

Key environment variables:
- `APP_ENV`, `APP_DEBUG`, `APP_URL`
- `DB_CONNECTION=pgsql` (PostgreSQL)
- `QUEUE_CONNECTION=database` (or redis in production)
- `MAIL_*` for email configuration
- `SCOUT_*` for search configuration
- `MAILCHIMP_*` for newsletter integration
- `SENTRY_*` for error tracking


## Frontend Enhancements (Nov 2025)

### Scroll Animations System
**Implementation:** Native Intersection Observer API (no external libraries)

**Animation Classes Available:**
- `fade-in` - Opacity fade (0 → 1)
- `slide-up` - Slide from bottom with fade
- `slide-left` - Slide from left with fade
- `slide-right` - Slide from right with fade
- `zoom-in` - Scale up (0.95 → 1) with fade
- `stagger-item` - Auto-cascading effect for grid items

**Files:**
- `resources/js/scroll-animations.js` - Observer logic
- `resources/css/app.css` - Animation keyframes and transitions
- `resources/views/layouts/app.blade.php` - Script inclusion

**Performance:**
- Hardware-accelerated CSS transforms
- 60fps smooth animations
- 0.8s cubic-bezier easing
- Triggers at 10% viewport visibility
- Auto-stagger: 100ms delay per grid item

**Usage Example:**
```html
<div class="fade-in">Fades in on scroll</div>
<div class="slide-up">Slides up on scroll</div>
<div class="grid">
    <div class="stagger-item">Item 1 (0ms delay)</div>
    <div class="stagger-item">Item 2 (100ms delay)</div>
    <div class="stagger-item">Item 3 (200ms delay)</div>
</div>
```

### Design System (Updated Nov 26, 2025)

**Color Palette:**
```css
/* Primary Colors */
--za-green-primary: #0d5a47  /* Main brand green */
--za-green-dark: #0a4536     /* Hover states */
--za-yellow-accent: #fbbf24  /* CTA buttons, highlights */
--za-yellow-dark: #f59e0b    /* Yellow hover states */

/* Usage in Tailwind */
bg-za-green-primary
text-za-yellow-accent
hover:bg-za-green-dark
```

**Inline Style Usage (for exact color match):**
```html
<div style="background-color: #0d5a47; color: #fbbf24;">
    Exact color match
</div>
```

**Gradient Pattern:**
All homepage sections use light green gradients:
```css
/* Top to bottom fade */
background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);

/* Alternating sections */
background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 50%, #ffffff 100%);
```

**Typography:**
- Headings: Playfair Display (serif, elegant)
- Body: Plus Jakarta Sans (sans-serif, modern)
- Loaded via Google Fonts in `app.blade.php`

**Spacing System:**
- Section padding: `py-16 lg:py-24` (consistent across all sections)
- Container: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- Section headers: `mb-12` (3rem bottom margin)

### Component Architecture

**Zaitoon Homepage Components:**
Located in `resources/views/components/homepage/`:
- `zaitoon-hero.blade.php` - Hero slider with carousel
- `zaitoon-news-ticker.blade.php` - Scrolling news ticker
- `zaitoon-introduction.blade.php` - About section with image
- `zaitoon-services.blade.php` - Service cards grid
- `zaitoon-programs.blade.php` - Academic programs
- `zaitoon-events.blade.php` - Campus activities & events
- `zaitoon-videos.blade.php` - Video player with playlist
- `advisors-section.blade.php` - Advisory board profiles
- `board-members-section.blade.php` - Board member profiles
- `competitions-section.blade.php` - Student competitions
- `news-events-section.blade.php` - Latest news & events

**Layout Components:**
- `header-zaitoon.blade.php` - Top bar + main navigation
- `footer-zaitoon.blade.php` - Footer with newsletter signup
- `navbar.blade.php` - Mobile-responsive navigation

**Component Pattern:**
```php
@props([
    'section' => null,
    'title' => '',
    'data' => []
])

<section class="py-16 lg:py-24" 
         style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl lg:text-4xl font-bold" 
                style="color: #0d5a47;">
                {{ $title }}
            </h2>
        </div>
        <!-- Content with animation classes -->
    </div>
</section>
```

### Asset Compilation

**Vite Configuration:**
- Entry points: `resources/css/app.css`, `resources/js/app.js`
- Output: `public/build/`
- HMR: Enabled for CSS/JS, disabled for Blade (manual refresh required)

**Build Commands:**
```bash
# Development (watch mode)
npm run dev

# Production build
npm run build

# Preview production build
npm run preview
```

**Tailwind Processing:**
- Scans all Blade templates for utility classes
- Purges unused CSS in production
- Includes custom Zaitoon color palette
- Supports dark mode (class-based)


## Custom Artisan Commands

### Homepage Management
```bash
# Update Vision & Mission section data
php artisan homepage:update-vision-mission

# Backfill slugs for existing events
php artisan events:backfill-slugs

# Sanitize announcement data
php artisan announcements:sanitize
```

### SEO & Sitemap
```bash
# Generate sitemap.xml
php artisan sitemap:generate

# Runs automatically after content updates via observers
```

### Development Workflow

**Initial Setup:**
```bash
# Clone repository
git clone <repo-url>
cd zaitoon-academy

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start development
composer dev  # Starts all services
```

**Daily Development:**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Queue worker
php artisan queue:listen

# Terminal 3: Asset compilation
npm run dev

# Or use single command:
composer dev
```

**Before Committing:**
```bash
# Format code
./vendor/bin/pint

# Run tests
php artisan test

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Deployment Checklist

### Pre-Deployment
- [ ] Run tests: `php artisan test`
- [ ] Format code: `./vendor/bin/pint`
- [ ] Build assets: `npm run build`
- [ ] Update .env with production values
- [ ] Backup database

### Deployment Steps
```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci

# Build production assets
npm run build

# Run migrations
php artisan migrate --force

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear old caches
php artisan cache:clear

# Generate sitemap
php artisan sitemap:generate

# Restart queue workers
php artisan queue:restart

# Restart PHP-FPM/web server
sudo systemctl restart php8.3-fpm
```

### Post-Deployment
- [ ] Verify homepage loads correctly
- [ ] Test navigation links
- [ ] Check admin panel access
- [ ] Verify scroll animations work
- [ ] Test form submissions
- [ ] Check error logs

## Troubleshooting

### Common Issues

**Scroll animations not working:**
```bash
# Ensure script is included in layout
# Check resources/views/layouts/app.blade.php
# Verify resources/js/scroll-animations.js exists
npm run build
```

**Colors not matching:**
```bash
# Clear Tailwind cache
rm -rf node_modules/.cache
npm run build

# Use inline styles for exact match
style="background-color: #0d5a47;"
```

**Cache issues:**
```bash
# Nuclear option - clear everything
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload
npm run build
```

**Database connection errors:**
```bash
# Check .env file
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=zaitoon_academy
DB_USERNAME=postgres
DB_PASSWORD=your_password

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

**Queue not processing:**
```bash
# Check queue connection
php artisan queue:work --tries=3

# View failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

## Performance Optimization

### Query Optimization
```php
// ✅ GOOD - Eager loading
$events = Event::with(['media', 'author'])->published()->get();

// ❌ BAD - N+1 queries
$events = Event::published()->get();
foreach ($events as $event) {
    $event->media; // Separate query for each event
}
```

### Caching Strategy
```php
// Repository pattern with caching
public function getPublished(int $perPage = 10) {
    return Cache::remember(
        "events.published.{$perPage}", 
        1800, // 30 minutes
        fn() => $this->model
            ->with('media')
            ->published()
            ->latest()
            ->paginate($perPage)
    );
}

// Clear cache in observer
public function saved(Event $event): void {
    Cache::forget('homepage_v2_data');
    Cache::tags(['events'])->flush();
}
```

### Image Optimization
```php
// WebP conversion in MediaObserver
public function registerMediaConversions(Media $media = null): void {
    $this->addMediaConversion('webp')
        ->format('webp')
        ->quality(90)
        ->nonQueued();
    
    $this->addMediaConversion('thumb')
        ->width(300)
        ->height(300)
        ->format('webp')
        ->quality(85);
}

// Always use with fallback
$event->getFirstMediaUrl('featured_image', 'medium') 
    ?: asset('images/placeholder.svg')
```

## Browser Compatibility

**Supported Browsers:**
- Chrome/Edge 90+ ✅
- Firefox 88+ ✅
- Safari 14+ ✅
- Mobile Safari (iOS 14+) ✅
- Chrome Mobile (Android 10+) ✅

**Polyfills Required:**
- None (Intersection Observer is natively supported)

**Testing:**
```bash
# Run on different devices
npm run dev -- --host

# Access from mobile device
http://192.168.1.x:5173
```

## Security Best Practices

### CSRF Protection
```html
<!-- All forms must include CSRF token -->
<form method="POST" action="{{ route('contact.submit') }}">
    @csrf
    <!-- form fields -->
</form>
```

### XSS Prevention
```php
// ✅ GOOD - Escaped output
{{ $user->name }}

// ⚠️ CAUTION - Unescaped (only for trusted HTML)
{!! $page->content !!}
```

### SQL Injection Prevention
```php
// ✅ GOOD - Query builder (auto-escapes)
Event::where('slug', $slug)->first();

// ❌ BAD - Raw queries without bindings
DB::select("SELECT * FROM events WHERE slug = '$slug'");

// ✅ GOOD - Raw with bindings
DB::select("SELECT * FROM events WHERE slug = ?", [$slug]);
```

### File Upload Security
```php
// Validate file types
$request->validate([
    'document' => 'required|file|mimes:pdf,doc,docx|max:5120',
    'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
]);

// Store securely
$path = $request->file('document')->store('documents', 'private');
```

## Environment Variables Reference

```bash
# Application
APP_NAME="Zaitoon Academy"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://zaitoonacademy.com

# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=zaitoon_academy
DB_USERNAME=postgres
DB_PASSWORD=

# Cache & Queue
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@zaitoonacademy.com
MAIL_FROM_NAME="${APP_NAME}"

# Services
MAILCHIMP_API_KEY=
MAILCHIMP_LIST_ID=

SENTRY_LARAVEL_DSN=
SENTRY_TRACES_SAMPLE_RATE=0.1

# Scout Search
SCOUT_DRIVER=database
# Or for production:
# SCOUT_DRIVER=meilisearch
# MEILISEARCH_HOST=http://127.0.0.1:7700
# MEILISEARCH_KEY=
```
