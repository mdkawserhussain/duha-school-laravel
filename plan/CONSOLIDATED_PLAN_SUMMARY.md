# Al-Maghrib International School - Consolidated Plan Summary

## Project Overview

**Goal**: Build a production-ready Laravel 12 website for Al-Maghrib International School that replicates https://almaghribschool.com/ with a modern, maintainable codebase featuring Filament admin panel, public site, tests, CI/CD, and deployment documentation.

**Tech Stack**:
- PHP 8.2+
- Laravel 12
- MySQL/MariaDB (PostgreSQL supported)
- Filament PHP 4.2 (Admin Panel)
- Blade + Tailwind CSS 4.0 (Frontend)
- Spatie packages (Media Library, Permission, Sitemap, Newsletter)
- Laravel Horizon (Queue Management)
- Redis (Queues/Cache, fallback to database)
- S3 Storage (Production) + Cloudflare CDN

## Core Features

### Public-Facing Features
1. **Homepage**: Hero section with CTA, featured events, latest notices, staff highlights
2. **Events**: List with filters (category, upcoming/past), detail pages, ICS calendar export
3. **Notices**: News/announcements board with categories and detail pages
4. **Staff Directory**: Staff profiles with bios, photos, contact info
5. **Admissions**: Information page + online application form with file attachments
6. **Careers**: Job listings + application form with resume upload
7. **Contact Form**: With spam protection (honeypot + rate limiting)
8. **Newsletter**: Subscription endpoint (DB + Mailchimp integration)
9. **Media Gallery**: Responsive image gallery with lazy loading
10. **Dynamic Pages**: About, Academics, Policies (managed via CMS)
11. **SEO**: Sitemap, JSON-LD structured data, meta tags, canonical URLs
12. **Analytics**: Google Analytics 4 + Tag Manager integration

### Admin Panel (Filament)
1. **Content Management**: CRUD for Pages, Events, Notices, Staff
2. **Application Management**: View/manage Admission and Career applications
3. **Media Library**: Image uploads with automatic optimization (WebP, responsive sizes)
4. **Role-Based Access**: Admin, Editor, Admissions Officer roles
5. **Dashboard**: Statistics widgets (pending applications, upcoming events)
6. **WYSIWYG Editor**: Rich text editing with image uploads
7. **Scheduling**: Draft/publish workflow with scheduled publishing
8. **SEO Fields**: Meta title, description, OG image per page/post

## Database Models (8 Core Models)

1. **Page**: Static content (About, Academics, Legal)
   - Fields: id, slug, title, content, seo_title, seo_description, og_image, status, published_at

2. **Event**: Dynamic event listings
   - Fields: id, title, slug, start_at, end_at, excerpt, content, location, category, status, created_by

3. **Notice**: News/announcements
   - Fields: id, title, slug, content, category, published_at, status

4. **Staff**: Staff directory
   - Fields: id, name, role_title, bio, email, phone, social_links (json), order

5. **AdmissionApplication**: Admission inquiries
   - Fields: id, parent_name, child_name, child_dob, grade_applied, phone, email, documents (json), status

6. **CareerApplication**: Job applications
   - Fields: id, job_id, name, email, phone, resume_path, cover_letter, status

7. **Subscriber**: Newsletter signups
   - Fields: id, email, subscribed_at, verified_at

8. **User/Role**: Authentication (via Spatie Permission)
   - Roles: admin, editor, admissions_officer

## Public Routes Structure

```
/                           → Homepage
/about/{slug}               → About pages (principal, vision)
/academic/{slug}            → Academics (curriculum, policies)
/events                     → Events listing (with filters)
/events/{event}             → Event detail + ICS export
/notices                    → Notices listing
/notices/{notice}           → Notice detail
/admission                  → Admission info + form
/careers                   → Careers page + application form
/contact-us                 → Contact form
/campus                     → Campus visit info
/media/gallery              → Image gallery
/privacy-policy            → Legal page
/terms-of-service          → Legal page
/newsletter/subscribe      → Newsletter subscription (POST)
/sitemap.xml               → Generated sitemap
/feed/events.atom          → Events Atom feed
```

## Architecture Patterns

### Controller → Service → Repository Pattern
- **Controllers**: Handle HTTP requests, validate via Form Requests, call Services, return views/responses
- **Services**: Orchestrate business logic, call Repositories, dispatch Jobs/Events
- **Repositories**: Data access layer (Eloquent queries, eager loading)
- **Dependency Injection**: Services and Repositories injected via constructors

### Key Principles
- Thin controllers, fat services
- Unit test services and repositories
- Use Form Requests for validation
- Queue heavy operations (emails, image processing)
- Cache frequently accessed data
- Follow SOLID principles

## Required Packages

### Core Packages
```bash
composer require filament/filament:^4.2
composer require spatie/laravel-permission:^6.23
composer require spatie/laravel-medialibrary:^11.17
composer require spatie/laravel-sitemap:^7.3
composer require spatie/laravel-newsletter:^5.3
composer require laravel/horizon:^5.39
composer require laravel/scout:^10.21
composer require intervention/image:^3.11
composer require laravel/breeze:^2.3
```

### Development Packages
```bash
composer require --dev laravel/pint
composer require --dev phpunit/phpunit:^11.5
composer require --dev laravel/sail
```

## Testing Requirements

### Unit Tests
- Model scopes and accessors
- Repository methods
- Service business logic
- Form Request validation

### Feature Tests
- Admission form submission (DB + queued email)
- Career application submission
- Contact form submission
- Events listing and detail pages
- Newsletter subscription
- Filament resource access (role-based)

### Minimum Coverage
- At least 10 automated tests
- 80% code coverage target
- Critical flows must be tested

## CI/CD Setup

### GitHub Actions Workflow
- Run tests on push/PR
- Code style checking (Laravel Pint)
- Build assets
- Deploy to staging/production (optional)

## Deployment Checklist

### Pre-Deployment
- [ ] Server meets requirements (PHP 8.2+, MySQL 8.0+, Redis)
- [ ] Domain configured and DNS pointing to server
- [ ] SSL certificate ready (Let's Encrypt)
- [ ] Database created
- [ ] Email service configured
- [ ] S3 bucket created (if using S3)
- [ ] Environment variables documented

### Deployment Steps
1. Clone repository
2. Install dependencies (`composer install --no-dev --optimize`)
3. Configure `.env` with production values
4. Run migrations (`php artisan migrate --force`)
5. Seed database (optional: `php artisan db:seed --force`)
6. Build assets (`npm run build`)
7. Cache configuration (`php artisan config:cache`)
8. Cache routes (`php artisan route:cache`)
9. Cache views (`php artisan view:cache`)
10. Set up queue workers (Supervisor/systemd)
11. Configure scheduled tasks (cron)
12. Set up SSL certificate
13. Configure backups
14. Set up monitoring

### Post-Deployment
- [ ] Verify public site loads
- [ ] Verify admin panel accessible
- [ ] Test form submissions
- [ ] Verify email sending
- [ ] Check queue processing
- [ ] Verify scheduled tasks running
- [ ] Test SSL certificate
- [ ] Monitor error logs

## Security Measures

1. **Authentication**: Laravel Breeze + Spatie Permission
2. **Authorization**: Role-based access control
3. **CSRF Protection**: Built-in Laravel CSRF tokens
4. **Rate Limiting**: On forms (admission, contact, newsletter)
5. **Input Validation**: Form Requests for all user input
6. **File Upload Security**: MIME type validation, size limits (10MB)
7. **SQL Injection**: Eloquent ORM (parameterized queries)
8. **XSS Protection**: Blade escaping, HTML sanitization
9. **Security Headers**: X-Frame-Options, X-Content-Type-Options
10. **HTTPS**: SSL/TLS encryption

## Performance Optimizations

1. **Caching**: Redis for queries, views, HTTP cache headers
2. **Image Optimization**: WebP conversion, responsive sizes, lazy loading
3. **Database**: Indexes on frequently queried columns, eager loading
4. **Queue**: Background processing for emails and heavy tasks
5. **CDN**: Cloudflare for static assets and media
6. **Asset Optimization**: Minified CSS/JS, optimized images
7. **HTTP Caching**: Cache-Control headers, ETags

## SEO Features

1. **Meta Tags**: Title, description per page/post
2. **Open Graph**: OG tags for social sharing
3. **Structured Data**: JSON-LD for Organization and Events
4. **Sitemap**: Auto-generated XML sitemap (weekly)
5. **Canonical URLs**: Prevent duplicate content
6. **Robots.txt**: Properly configured
7. **Analytics**: Google Analytics 4 + Tag Manager

## Email Configuration

### Mailables Required
1. **AdmissionApplicationReceived**: Sent to admin on new admission
2. **CareerApplicationReceived**: Sent to admin on new career application
3. **ContactMessageReceived**: Sent to admin on contact form submission
4. **NewsletterSubscriptionConfirmation**: Sent to subscriber

### Queue Configuration
- All emails queued (Redis preferred, database fallback)
- Horizon dashboard for monitoring
- Retry logic for failed jobs

## File Structure

```
app/
├── Console/Commands/          # Artisan commands (sitemap generation)
├── Filament/
│   ├── Resources/            # CRUD resources (Page, Event, Notice, Staff, etc.)
│   └── Widgets/              # Dashboard widgets
├── Http/
│   ├── Controllers/           # Public & admin controllers
│   ├── Middleware/            # Custom middleware (SecurityHeaders, Role)
│   └── Requests/              # Form request validation
├── Mail/                      # Mailable classes
├── Models/                    # Eloquent models (8 core models)
├── Providers/                 # Service providers
├── Repositories/              # Data access layer
└── Services/                  # Business logic layer

database/
├── factories/                 # Model factories
├── migrations/                # Database migrations
└── seeders/                   # Database seeders (with sample data)

resources/
├── views/
│   ├── components/            # Blade components (Header, Footer, EventCard)
│   ├── emails/                # Email templates
│   ├── feeds/                 # RSS/Atom feeds
│   ├── layouts/               # Layout templates
│   └── pages/                 # Page templates
├── css/                       # Tailwind CSS
└── js/                        # JavaScript

routes/
├── web.php                    # Web routes
└── auth.php                   # Authentication routes (Breeze)

scripts/
├── setup.sh                   # Initial setup script
├── deploy.sh                  # Production deployment script
└── backup.sh                  # Database backup script

tests/
├── Feature/                   # Feature tests
└── Unit/                      # Unit tests

.github/
└── workflows/
    └── ci.yml                 # GitHub Actions CI workflow
```

## Development Phases

### Phase 1: Project Setup (Week 1)
- Laravel 12 installation
- Package installation
- Database setup
- Models and migrations
- Filament admin installation
- Basic authentication

### Phase 2: Backend Development (Week 2-3)
- Controllers, Services, Repositories
- Filament resources for all models
- Form validation (Form Requests)
- Email Mailables
- Queue configuration

### Phase 3: Frontend Development (Week 3-4)
- Blade templates
- Tailwind CSS styling
- Responsive layouts
- Component creation
- Form implementations

### Phase 4: Integration & Testing (Week 4-5)
- Connect admin and public
- Unit tests
- Feature tests
- Email testing
- Queue testing

### Phase 5: SEO & Performance (Week 5)
- SEO meta tags
- Sitemap generation
- Structured data (JSON-LD)
- Image optimization
- Caching implementation

### Phase 6: Deployment (Week 6)
- Staging deployment
- Production deployment
- CI/CD setup
- Monitoring setup
- Documentation

## Future Enhancements (Post-MVP)

1. **Student Portal / LMS**: Course management, lessons, student progress
2. **Payment Integration**: Stripe for fees/course payments
3. **Advanced Search**: Laravel Scout + Meilisearch
4. **Multi-language**: Bangla + English support
5. **Two-Factor Authentication**: For admin accounts
6. **Analytics Dashboard**: Custom reporting
7. **Mobile App**: PWA for events/notices

## Acceptance Criteria

- [ ] `composer install` and `npm install` run without errors
- [ ] `php artisan migrate --seed` creates tables and seeds sample data
- [ ] Filament admin accessible with seeded admin user
- [ ] Public pages render with seeded content
- [ ] Forms persist data and send queued emails
- [ ] Mail sending works with queue fallback
- [ ] Tests pass (`php artisan test`)
- [ ] README includes setup, env variables, deploy checklist
- [ ] CI workflow runs tests on push/PR
- [ ] Deployment scripts functional
- [ ] All routes accessible and working
- [ ] Image optimization working (WebP, responsive)
- [ ] Sitemap generates correctly
- [ ] SEO meta tags present on all pages
- [ ] Security headers configured
- [ ] Rate limiting active on forms

## Deliverables

1. ✅ Complete Laravel 12 repository
2. ✅ All models, migrations, factories, seeders
3. ✅ Filament admin resources for all content types
4. ✅ Public routes and Blade templates
5. ✅ Validation, Requests, Mailables, queued emails
6. ✅ Tests (unit + feature, minimum 10 tests)
7. ✅ CI: GitHub Actions workflow
8. ✅ README with setup and deployment
9. ✅ Deployment checklist and scripts
10. ✅ Seeders with example content
11. ✅ Environment configuration guide
12. ✅ Docker/Sail setup

---

**Last Updated**: Based on consolidated review of all plan documents
**Laravel Version**: 12
**PHP Version**: 8.2+
**Status**: Ready for Implementation

