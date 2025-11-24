# Technology Stack

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
