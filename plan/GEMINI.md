# Project: Al-Maghrib International School Website

## Project Overview

This is a modern, production-ready Laravel 12 website for Al-Maghrib International School. The application provides a comprehensive content management system (CMS) for school administrators and a public-facing website. It's built with a focus on performance, security, and ease of use for non-technical staff.

## Tech Stack

*   **Framework:** Laravel 12
*   **PHP:** 8.2+
*   **Database:** MySQL 8.0 / MariaDB 10.6 (PostgreSQL supported)
*   **Frontend:** Blade Templates, Tailwind CSS 3.1, Alpine.js 3.4, Vite
*   **Admin Panel:** Filament PHP 4.2
*   **Authentication:** Laravel Breeze
*   **Queue Management:** Laravel Horizon
*   **Media Library:** Spatie Media Library 11.17
*   **Permissions:** Spatie Permission 6.23
*   **Search:** Laravel Scout 10.21 (Meilisearch/Algolia optional)
*   **Caching:** Redis (fallback to file/database)
*   **Storage:** Local (dev) / S3 (production)

## Building and Running

### Prerequisites

*   PHP 8.2+
*   Composer
*   Node.js 18+ and NPM
*   MySQL 8.0+ or PostgreSQL
*   Redis (optional, for queues/cache)

### Local Development (Manual)

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd almaghrib-school
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Environment setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Then, configure your database credentials in the `.env` file.*

4.  **Run migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Create storage link:**
    ```bash
    php artisan storage:link
    ```

6.  **Build assets:**
    ```bash
    npm run build
    ```

7.  **Start the development server:**
    ```bash
    php artisan serve
    ```

### Local Development (Docker)

1.  **Start services:**
    ```bash
    docker-compose up -d
    ```

2.  **Install dependencies and set up the application:**
    ```bash
    docker-compose exec app composer install
    docker-compose exec app npm install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate --seed
    docker-compose exec app php artisan storage:link
    ```

### Running Tests

To run the full test suite:

```bash
php artisan test
```

## Development Conventions

*   **Code Style:** The project uses Laravel Pint for code style enforcement. Run `vendor/bin/pint` to format your code.
*   **Branching:** Create feature branches from `main` (e.g., `feature/new-feature` or `fix/bug-fix`).
*   **Commits:** Write clear and concise commit messages.

## Backend

The backend is a standard Laravel application.

*   **Core Dependencies:**
    *   `laravel/framework`: ^12.0
    *   `filament/filament`: ^4.2
    *   `spatie/laravel-medialibrary`: ^11.17
    *   `spatie/laravel-permission`: ^6.23
    *   `laravel/scout`: ^10.21
*   **Middleware:**
    *   `EnsureUserHasRole`: Custom middleware for role-based access control.
    *   `SecurityHeaders`: Custom middleware for adding security headers to responses.
    *   `SetLocale`: Custom middleware for setting the application's locale based on the user's preference.
*   **Service Providers:** The application uses the default Laravel service providers, with no custom logic in `AppServiceProvider`.

## Frontend

The frontend is built with Blade templates, Tailwind CSS, and Alpine.js. Assets are compiled with Vite.

*   **Key Dependencies:**
    *   `@tailwindcss/forms`: ^0.5.2
    *   `alpinejs`: ^3.4.2
    *   `axios`: ^1.11.0
    *   `laravel-vite-plugin`: ^2.0.0
    *   `postcss`: ^8.4.31
    *   `tailwindcss`: ^3.1.0
    *   `vite`: ^7.0.7
*   **Build Process:**
    *   `npm run dev`: Compiles assets for development and watches for changes.
    *   `npm run build`: Compiles and minifies assets for production.

## Database Schema

The database schema is managed through Laravel migrations. Here's a summary of the main tables:

*   **`pages`:** Stores dynamic pages like "About Us" and "Privacy Policy".
*   **`events`:** Stores information about school events.
*   **`notices`:** Stores school notices and announcements.
*   **`staff`:** Stores information about staff members.
*   **`admission_applications`:** Stores admission applications submitted through the website.
*   **`career_applications`:** Stores career applications submitted through the website.
*   **`users`:** Stores user accounts for the admin panel.
*   **`subscribers`:** Stores newsletter subscribers.
*   **`site_settings`:** Stores global site settings.

## Filament Admin Panel

The admin panel is built with Filament and provides a comprehensive interface for managing the website's content and applications.

*   **Resources:**
    *   **Content Management:** `EventResource`, `NoticeResource`, `PageResource`, `StaffResource`
    *   **Applications:** `AdmissionApplicationResource`, `CareerApplicationResource`
*   **Widgets:**
    *   `StatsOverview`: Displays key metrics on the dashboard.
    *   `RecentApplications`: Shows a list of the latest admission applications.
    *   `UpcomingEvents`: Shows a list of upcoming events.
    *   `QuickActions`: Provides quick links to common administrative tasks.

## Public-Facing Website

The public-facing website is built with Blade templates and Tailwind CSS.

*   **Main Pages:**
    *   Home
    *   About (Principal's Message, Vision & Mission)
    *   Academics (Curriculum, Policies)
    *   Admission
    *   News & Media (Events, Notices)
    *   Career
    *   Contact
*   **Key Components:**
    *   `header`: Main navigation bar with dropdown menus and search.
    *   `footer`: Website footer with contact information, quick links, and newsletter signup.
    *   `newsletter-signup`: A self-contained component for handling newsletter signups.
    *   `language-switcher`: A dropdown menu for switching between languages.
