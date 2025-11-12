# Laravel Scout Search Setup Guide

This guide explains how to set up and use Laravel Scout for full-text search functionality in the Al-Maghrib International School application.

## Overview

Laravel Scout provides full-text search capabilities for Eloquent models. The application supports multiple search drivers:
- **Collection** (default) - In-memory search for development
- **Database** - Uses database LIKE queries
- **Meilisearch** - Fast, typo-tolerant search engine
- **Algolia** - Cloud-hosted search service
- **Typesense** - Open-source search engine

## Current Implementation

### Models with Search Support

The following models are configured for search:
- `Event` - Searchable fields: title, excerpt, description, location, category
- `Notice` - Searchable fields: title, excerpt, content, category
- `Page` - Searchable fields: title, content, slug, meta_description
- `Staff` - Searchable fields: name, position, bio

### Search Controller

The `SearchController` automatically:
- Uses Scout if a proper driver is configured
- Falls back to database search if Scout is not available
- Filters results to show only published/active content
- Handles errors gracefully

## Setup Instructions

### Option 1: Collection Driver (Default - Development)

No setup required. Works out of the box for development:

```env
SCOUT_DRIVER=collection
```

### Option 2: Database Driver

Uses database LIKE queries. No additional setup:

```env
SCOUT_DRIVER=database
```

Then run:
```bash
php artisan migrate
```

### Option 3: Meilisearch (Recommended for Production)

1. **Install Meilisearch** (using Docker):
   ```bash
   docker run -d -p 7700:7700 getmeili/meilisearch:latest
   ```

2. **Configure in `.env`**:
   ```env
   SCOUT_DRIVER=meilisearch
   MEILISEARCH_HOST=http://127.0.0.1:7700
   MEILISEARCH_KEY=your_master_key_here
   ```

3. **Import models to search index**:
   ```bash
   php artisan scout:import "App\Models\Event"
   php artisan scout:import "App\Models\Notice"
   php artisan scout:import "App\Models\Page"
   php artisan scout:import "App\Models\Staff"
   ```

4. **Or import all at once**:
   ```bash
   php artisan scout:import "App\Models\Event"
   php artisan scout:import "App\Models\Notice"
   php artisan scout:import "App\Models\Page"
   php artisan scout:import "App\Models\Staff"
   ```

### Option 4: Algolia

1. **Sign up** at [algolia.com](https://www.algolia.com)

2. **Configure in `.env`**:
   ```env
   SCOUT_DRIVER=algolia
   ALGOLIA_APP_ID=your_app_id
   ALGOLIA_SECRET=your_secret_key
   ```

3. **Import models**:
   ```bash
   php artisan scout:import "App\Models\Event"
   php artisan scout:import "App\Models\Notice"
   php artisan scout:import "App\Models\Page"
   php artisan scout:import "App\Models\Staff"
   ```

## Importing Data

After setting up a search driver, import your models:

```bash
# Import individual models
php artisan scout:import "App\Models\Event"
php artisan scout:import "App\Models\Notice"
php artisan scout:import "App\Models\Page"
php artisan scout:import "App\Models\Staff"

# Or use a script to import all
php artisan scout:import "App\Models\Event" && \
php artisan scout:import "App\Models\Notice" && \
php artisan scout:import "App\Models\Page" && \
php artisan scout:import "App\Models\Staff"
```

## Auto-Syncing

Models are automatically synced to the search index when:
- A model is created
- A model is updated
- A model is deleted (if soft deletes are enabled)

This behavior is controlled by the `shouldBeSearchable()` method in each model, which ensures only published/active content is indexed.

## Manual Syncing

To manually sync all models:

```bash
php artisan scout:import "App\Models\Event"
php artisan scout:import "App\Models\Notice"
php artisan scout:import "App\Models\Page"
php artisan scout:import "App\Models\Staff"
```

To flush all search indexes:

```bash
php artisan scout:flush "App\Models\Event"
php artisan scout:flush "App\Models\Notice"
php artisan scout:flush "App\Models\Page"
php artisan scout:flush "App\Models\Staff"
```

## Queue Configuration

For better performance, you can queue search index updates:

```env
SCOUT_QUEUE=true
```

This requires a queue worker to be running:
```bash
php artisan queue:work
```

## Search Usage

### In Controllers

The `SearchController` handles all search requests:

```php
// Search is automatically handled via the /search route
Route::get('/search', [SearchController::class, 'search'])->name('search');
```

### In Views

Search is accessible via:
- Search modal in the header (desktop and mobile)
- Direct search page at `/search?q=query`

### Programmatic Search

You can also search programmatically:

```php
use App\Models\Event;

// Basic search
$events = Event::search('sports day')->get();

// With filters
$events = Event::search('sports day')
    ->where('is_published', true)
    ->get();

// Paginated results
$events = Event::search('sports day')->paginate(10);
```

## Troubleshooting

### Search Not Working

1. **Check driver configuration**:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

2. **Verify models are indexed**:
   - Check if data exists in your search index
   - Re-import models if needed

3. **Check logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Meilisearch Connection Issues

1. **Verify Meilisearch is running**:
   ```bash
   curl http://127.0.0.1:7700/health
   ```

2. **Check firewall/port**:
   - Ensure port 7700 is accessible
   - Check Docker container status

### Performance Issues

1. **Enable queueing**:
   ```env
   SCOUT_QUEUE=true
   ```

2. **Use proper search driver**:
   - Collection driver is slow for large datasets
   - Use Meilisearch or Algolia for production

## Best Practices

1. **Index only published content**: The `shouldBeSearchable()` method ensures only published content is indexed
2. **Use queueing in production**: Set `SCOUT_QUEUE=true` for better performance
3. **Regular re-indexing**: Re-import models after bulk updates
4. **Monitor search performance**: Use search analytics if available (Algolia dashboard, Meilisearch analytics)

## Production Deployment

For production, recommended setup:

1. **Use Meilisearch or Algolia** (not collection driver)
2. **Enable queueing**: `SCOUT_QUEUE=true`
3. **Set up queue workers**: Use Supervisor or Laravel Horizon
4. **Import all models** after deployment
5. **Monitor search performance** and adjust as needed

## Additional Resources

- [Laravel Scout Documentation](https://laravel.com/docs/scout)
- [Meilisearch Documentation](https://www.meilisearch.com/docs)
- [Algolia Documentation](https://www.algolia.com/doc/)

