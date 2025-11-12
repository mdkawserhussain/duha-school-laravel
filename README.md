# Al-Maghrib International School Website

A modern, production-ready Laravel 12 website for Al-Maghrib International School. This application provides a comprehensive content management system for school administrators and a beautiful, responsive public-facing website.

## 🎯 Project Overview

This Laravel application replicates and enhances the functionality of the Al-Maghrib International School website (https://almaghribschool.com/). It provides:

- **Public Website**: Fast, responsive, mobile-first design with SEO optimization
- **Admin Panel**: Filament-based content management system for non-technical staff
- **Dynamic Content**: Events, notices, staff directory, admissions, careers
- **Form Handling**: Contact forms, admission applications, career applications with file uploads
- **Newsletter Integration**: Mailchimp integration for email marketing
- **Media Management**: Image optimization, WebP conversion, S3-ready storage

## 🚀 Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MySQL 8.0 / MariaDB 10.6 (PostgreSQL supported)
- **Frontend**: Blade Templates + Tailwind CSS 4.0
- **Admin Panel**: Filament PHP 4.2
- **Authentication**: Laravel Breeze
- **Queue Management**: Laravel Horizon
- **Media Library**: Spatie Media Library
- **Permissions**: Spatie Permission
- **Search**: Laravel Scout (Meilisearch/Algolia optional)
- **Caching**: Redis (fallback to file/database)
- **Storage**: Local (dev) / S3 (production)

## 📋 Features

### Public Features
- Homepage with hero section, featured events, latest notices, staff highlights
- Events listing with filters (category, upcoming/past) and ICS calendar export
- Notices/News board with categories
- Staff directory with profiles
- Admissions information and online application form
- Careers listing and job application system
- Contact form with spam protection
- Newsletter subscription
- Media gallery
- Dynamic pages (About, Academics, Policies)
- Atom feed for events
- SEO optimized (sitemap, structured data, meta tags)

### Admin Features (Filament)
- Content management for Pages, Events, Notices, Staff
- Application management for Admissions and Careers
- Media library with image optimization
- Role-based access control (Admin, Editor, Admissions Officer)
- Dashboard with statistics and widgets
- WYSIWYG editor for content
- Scheduling and publishing workflow
- SEO meta fields per page/post

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0+ or PostgreSQL
- Redis (optional, for queues/cache)

### Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd almaghrib-school
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=almaghrib_school
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Public site: http://localhost:8000
   - Admin panel: http://localhost:8000/admin
   - Default admin credentials:
     - Email: `admin@almaghribschool.com`
     - Password: `password` (⚠️ Change in production!)

### Using Docker Compose

1. **Start services**
   ```bash
   docker-compose up -d
   ```

2. **Install dependencies**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

3. **Setup application**
   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   docker-compose exec app php artisan storage:link
   ```

4. **Access the application**
   - Public site: http://localhost:8080
   - Admin panel: http://localhost:8080/admin

### Using Laravel Sail

1. **Start Sail**
   ```bash
   ./vendor/bin/sail up -d
   ```

2. **Install dependencies**
   ```bash
   ./vendor/bin/sail composer install
   ./vendor/bin/sail npm install
   ```

3. **Setup application**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate --seed
   ./vendor/bin/sail artisan storage:link
   ```

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Run specific test files:

```bash
php artisan test --filter EventTest
php artisan test tests/Feature/AdmissionTest.php
```

## 🛠️ Development

### Code Style

This project uses Laravel Pint for code style:

```bash
vendor/bin/pint
```

### Queue Workers

For local development with queues:

```bash
php artisan queue:work
```

Or use Horizon dashboard:

```bash
php artisan horizon
```

Access Horizon at: http://localhost:8000/horizon

### Asset Compilation

Watch for changes:

```bash
npm run dev
```

Build for production:

```bash
npm run build
```

## 📁 Project Structure

```
app/
├── Console/Commands/        # Artisan commands
├── Filament/               # Filament admin resources
│   ├── Resources/          # CRUD resources
│   └── Widgets/           # Dashboard widgets
├── Http/
│   ├── Controllers/        # Public & admin controllers
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form request validation
├── Mail/                   # Mailable classes
├── Models/                 # Eloquent models
├── Providers/              # Service providers
├── Repositories/           # Data access layer
└── Services/               # Business logic layer

database/
├── factories/              # Model factories
├── migrations/             # Database migrations
└── seeders/               # Database seeders

resources/
├── views/
│   ├── components/         # Blade components
│   ├── emails/            # Email templates
│   ├── feeds/             # RSS/Atom feeds
│   ├── layouts/           # Layout templates
│   └── pages/             # Page templates
├── css/                   # Tailwind CSS
└── js/                    # JavaScript

routes/
├── web.php                # Web routes
└── auth.php               # Authentication routes (Breeze)

scripts/
├── setup.sh               # Initial setup script
├── deploy.sh               # Production deployment script
└── backup.sh              # Database backup script
```

## 🔐 Authentication & Roles

The application uses Laravel Breeze for authentication and Spatie Permission for role-based access control.

### Default Roles

- **admin**: Full access to all resources
- **editor**: Can manage content (Pages, Events, Notices, Staff)
- **admissions_officer**: Can manage admission and career applications

### Default Users

After seeding, these users are created:

- Admin: `admin@almaghribschool.com` / `password`
- Editor: `editor@almaghribschool.com` / `password`
- Admissions Officer: `admissions@almaghribschool.com` / `password`

⚠️ **Important**: Change these passwords in production!

## 📧 Email Configuration

Configure email in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@almaghribschool.com
MAIL_FROM_NAME="Al-Maghrib International School"
```

For local development, use Mailpit or log driver:

```env
MAIL_MAILER=log
```

## 🗄️ Database

### Migrations

Run migrations:

```bash
php artisan migrate
```

Rollback migrations:

```bash
php artisan migrate:rollback
```

### Seeders

Seed the database:

```bash
php artisan db:seed
```

Seed specific seeder:

```bash
php artisan db:seed --class=EventSeeder
```

## 🚀 Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions.

### Quick Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Generate and set `APP_KEY`
- [ ] Configure production database
- [ ] Set up Redis for queues/cache
- [ ] Configure S3 storage (optional)
- [ ] Set up queue workers (Supervisor/systemd)
- [ ] Configure scheduled tasks (cron)
- [ ] Set up SSL certificate
- [ ] Configure backups
- [ ] Set up monitoring

## 📚 Documentation

- [Environment Configuration](ENV_CONFIGURATION.md) - Complete guide to environment variables
- [Deployment Guide](DEPLOYMENT.md) - Step-by-step deployment instructions

## 🔧 Configuration

### Queue Configuration

For production, use Redis:

```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

Fallback to database:

```env
QUEUE_CONNECTION=database
```

### Cache Configuration

Use Redis for caching:

```env
CACHE_STORE=redis
```

### Storage Configuration

For production, use S3:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

## 🎨 Frontend Development

The frontend uses Tailwind CSS 4.0 with Vite for asset compilation.

### Available NPM Scripts

- `npm run dev` - Start Vite dev server with hot reload
- `npm run build` - Build assets for production

### Tailwind Configuration

Tailwind is configured in `vite.config.js`. Customize colors and utilities as needed.

## 🔍 Search (Optional)

The application supports Laravel Scout for search functionality.

### Meilisearch Setup

1. Install Meilisearch (via Docker or native)
2. Configure in `.env`:
   ```env
   SCOUT_DRIVER=meilisearch
   MEILISEARCH_HOST=http://127.0.0.1:7700
   MEILISEARCH_KEY=your_master_key
   ```
3. Import models:
   ```bash
   php artisan scout:import "App\Models\Event"
   php artisan scout:import "App\Models\Notice"
   ```

## 📊 Monitoring

### Horizon Dashboard

Monitor queue jobs at `/horizon` (requires authentication).

### Logs

Application logs are stored in `storage/logs/laravel.log`.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For issues and questions:
- Check the [Deployment Guide](DEPLOYMENT.md)
- Review [Environment Configuration](ENV_CONFIGURATION.md)
- Open an issue on GitHub

## 🙏 Acknowledgments

- Laravel Framework
- Filament PHP
- Spatie Packages
- Tailwind CSS

---

**Built with ❤️ for Al-Maghrib International School**
