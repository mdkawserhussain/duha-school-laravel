# Project: Al-Maghrib International School Website

## Project Overview

This is a modern, production-ready Laravel 12 website for Al-Maghrib International School. The application provides a comprehensive content management system (CMS) for school administrators and a public-facing website. It's built with a focus on performance, security, and ease of use for non-technical staff.

The backend is powered by PHP 8.2 and Laravel 12, with a MySQL database. The admin panel is built with Filament PHP, providing a rich and intuitive interface for managing content. The frontend uses Blade templates with Tailwind CSS and Alpine.js for a responsive and interactive user experience.

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
*   **Frontend:** The project uses Tailwind CSS for styling and Alpine.js for interactivity. Assets are compiled with Vite.
*   **Backend:** The application follows the standard Laravel MVC pattern. Business logic is organized into services and repositories.
*   **Database:** Database schema changes are managed through migrations. Seeders are used to populate the database with initial data.
*   **Admin Panel:** The admin panel is built with Filament. New resources and pages should be created within the `app/Filament` directory.