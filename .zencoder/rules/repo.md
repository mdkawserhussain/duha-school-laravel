---
description: Repository Information Overview
alwaysApply: true
---

# Al-Maghrib International School Website Information

## Summary

A production-ready Laravel 12 website for Al-Maghrib International School featuring a comprehensive CMS admin panel built with Filament PHP, public-facing website with Blade templates and Tailwind CSS, and support for dynamic content management, applications, and newsletter integration. The application includes event management, notices, staff directory, admission/career applications, and media library capabilities.

## Structure

- **app/**: Laravel application core with controllers, models, services, and repositories
  - `Http/Controllers/`: Web controllers (HomeController, EventController, PageController, etc.)
  - `Models/`: Eloquent models (Event, Notice, Page, Staff, User, AdmissionApplication, CareerApplication, SiteSettings)
  - `Services/`: Business logic services (EventService, NoticeService, PageService, StaffService)
  - `Filament/`: Admin panel resources and pages (EventResource, NoticeResource, PageResource, StaffResource, etc.)
  - `Mail/`: Mailable classes for email notifications
  - `Repositories/`: Data access layer abstractions
- **resources/**: Frontend assets
  - `views/`: Blade templates organized by page/component type
  - `css/`: Tailwind CSS stylesheets
  - `js/`: Alpine.js scripts
- **database/**: Database migrations, factories, and seeders
- **config/**: Laravel configuration files (app, database, cache, mail, queue, etc.)
- **routes/**: Web and API route definitions (web.php, auth.php)
- **docker/**: Docker configuration (nginx, PHP)
- **tests/**: Test suites (Unit and Feature tests with PHPUnit)
- **public/**: Web root with compiled assets and index.php entry point
- **scripts/**: Utility scripts for deployment and setup

## Language & Runtime

**Language**: PHP  
**Version**: 8.2+  
**Framework**: Laravel 12  
**Build System**: Composer (PHP), Vite (Frontend)  
**Package Managers**: Composer, npm

## Dependencies

**Main Dependencies**:
- `laravel/framework`: ^12.0 - Core Laravel framework
- `filament/filament`: ^4.2 - Admin panel UI framework
- `spatie/laravel-medialibrary`: ^11.17 - Media management
- `spatie/laravel-permission`: ^6.23 - Role and permission management
- `spatie/laravel-newsletter`: ^5.3 - Newsletter integration
- `spatie/laravel-sitemap`: ^7.3 - Sitemap generation
- `laravel/scout`: ^10.21 - Search indexing (Meilisearch/Algolia)
- `laravel/horizon`: ^5.39 - Queue monitoring
- `intervention/image`: ^3.11 - Image manipulation
- `sentry/sentry-laravel`: ^4.18 - Error tracking
- `laravel/tinker`: ^2.10.1 - Interactive shell

**Development Dependencies**:
- `phpunit/phpunit`: ^11.5.3 - Testing framework
- `fakerphp/faker`: ^1.23 - Fake data generation
- `laravel/pint`: ^1.24 - Code style formatting
- `laravel/breeze`: ^2.3 - Authentication scaffolding
- `laravel/sail`: ^1.41 - Docker development environment
- `laravel/pail`: ^1.2.2 - Log viewer
- `mockery/mockery`: ^1.6 - Mocking library

**Frontend Dependencies**:
- `tailwindcss`: ^3.1.0 - CSS framework
- `alpinejs`: ^3.4.2 - JavaScript framework
- `vite`: ^7.0.7 - Frontend build tool
- `laravel-vite-plugin`: ^2.0.0 - Laravel integration
- `axios`: ^1.11.0 - HTTP client
- `lightbox2`: ^2.11.5 - Image gallery
- `@tailwindcss/forms`: ^0.5.2 - Form styling
- `postcss`: ^8.4.31 - CSS transformation
- `autoprefixer`: ^10.4.2 - CSS vendor prefixes

## Build & Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL 8.0+ (or MariaDB 10.6 / PostgreSQL)
- Redis (optional, for queues)

### Development Setup
```bash
# Clone and dependencies
git clone <repository-url>
cd almaghrib-school
composer install
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed
php artisan storage:link

# Asset compilation
npm run build

# Development server
php artisan serve
```

### Composer Scripts
```bash
composer setup          # Full setup (install, migrate, seeders)
composer dev           # Concurrent dev server, queue, logs, vite
composer test          # Run test suite
```

### Frontend Build
```bash
npm run dev            # Development with watch
npm run build          # Production build
```

## Docker

**Dockerfile**: `Dockerfile`  
**Image**: `almaghrib-school-app` (PHP 8.2-FPM)  
**Services**: App (PHP-FPM), Nginx, MySQL 8.0, Redis 7, Meilisearch v1.5

**Docker Compose Configuration**:
```bash
docker-compose up -d                           # Start all services
docker-compose exec app composer install       # Install PHP dependencies
docker-compose exec app npm install            # Install frontend dependencies
docker-compose exec app php artisan migrate    # Run migrations
```

**Services**:
- **app**: PHP-FPM container (port 9000)
- **nginx**: Web server (port 8080)
- **mysql**: Database (port 3306, volumes: mysql_data)
- **redis**: Caching/queues (port 6379, volumes: redis_data)
- **meilisearch**: Search engine (port 7700, volumes: meilisearch_data)

## Main Files & Resources

**Application Entry Points**:
- `public/index.php` - Web application entry point
- `artisan` - Command-line interface

**Key Configuration Files**:
- `.env.example` - Environment template
- `config/app.php` - Application configuration
- `config/database.php` - Database configuration
- `config/filesystems.php` - Storage configuration
- `config/mail.php` - Mail configuration
- `tailwind.config.js` - Tailwind CSS configuration
- `vite.config.js` - Vite build configuration
- `postcss.config.js` - PostCSS configuration

**Route Files**:
- `routes/web.php` - Public web routes
- `routes/auth.php` - Authentication routes
- `routes/console.php` - Artisan commands

**Database Models**:
- Event, Notice, Page, Staff, User
- AdmissionApplication, CareerApplication
- SiteSettings, Subscriber, HomePageContent
- HomePageSection

## Testing

**Framework**: PHPUnit ^11.5.3  
**Test Location**: `tests/` directory  
**Test Suites**:
- `tests/Unit/` - Unit tests (EventServiceTest, PageServiceTest, NoticeServiceTest, ExampleTest)
- `tests/Feature/` - Feature tests (EventTest, PageTest, ContactTest, NewsletterTest, ProfileTest)

**Configuration**: `phpunit.xml`  
**Database**: In-memory SQLite for testing  
**Run Tests**:
```bash
composer test              # Via Composer script
php artisan test          # Direct Artisan command
php artisan test --filter TestName  # Specific test
```

**Test Setup**: Uses Laravel's testing utilities with database migrations and seeders for test isolation. Tests include feature tests for HTTP endpoints and unit tests for services.
