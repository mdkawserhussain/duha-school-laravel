---
inclusion: always
---

# Project Structure & Architecture

## Architecture Pattern

**Service-Repository Pattern** - Strict separation of concerns:

```
Controller → Service → Repository → Model → Database
    ↓
  View
```

- **Controllers**: Handle HTTP, validate via Request classes, delegate to services
- **Services**: Business logic, orchestration, transaction management
- **Repositories**: Data access, query building, caching
- **Models**: Eloquent ORM, relationships, scopes, accessors/mutators, slug generation in boot()
- **Observers**: Model lifecycle hooks (slug normalization, cache invalidation)

**IMPORTANT**: This project does NOT use Filament. All admin functionality is custom-built.

## Critical Conventions

### Naming Standards
- Models: Singular PascalCase (`Event`, `Notice`, `Staff`)
- Controllers: `{Model}Controller` (`EventController`)
- Services: `{Model}Service` (`EventService`)
- Repositories: `{Model}Repository` (`EventRepository`)
- Blade components: Kebab-case (`event-card.blade.php`)
- Routes: Kebab-case (`/events/{slug}`, `/contact-us`)
- Database tables: Plural snake_case (`events`, `admission_applications`)

### Model Requirements
Always implement these patterns:

```php
// Route model binding by slug
public function getRouteKeyName() {
    return 'slug';
}

// Query scopes for filtering
public function scopePublished($query) {
    return $query->where('is_published', true)
                ->where('published_at', '<=', now());
}

// Slug generation in boot() method
protected static function boot() {
    parent::boot();
    
    static::creating(function ($model) {
        if (empty($model->slug) && !empty($model->title)) {
            $model->slug = static::generateUniqueSlug($model->title);
        }
    });
    
    static::updating(function ($model) {
        if ($model->isDirty('title') && (empty($model->slug) || is_null($model->slug))) {
            $model->slug = static::generateUniqueSlug($model->title);
        }
    });
}

protected static function generateUniqueSlug(string $title): string {
    $title = trim($title);
    if (empty($title)) {
        $title = 'model-' . time();
    }
    
    $slug = Str::slug($title);
    if (empty($slug)) {
        $slug = 'model-' . time();
    }
    
    $originalSlug = $slug;
    $counter = 1;
    
    while (static::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    
    return $slug;
}

// Media collections (Spatie)
public function registerMediaCollections(): void {
    $this->addMediaCollection('featured_image')->singleFile();
    $this->addMediaCollection('gallery');
}

// Media conversions with WebP
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
    
    $this->addMediaConversion('medium')
        ->width(600)
        ->height(400)
        ->format('webp')
        ->quality(85);
}

// Search configuration (Scout)
public function toSearchableArray() {
    return [
        'title' => $this->title,
        'content' => $this->content,
        'excerpt' => $this->excerpt,
        'is_published' => $this->is_published,
        'published_at' => $this->published_at?->toIso8601String(),
    ];
}

public function shouldBeSearchable() {
    return $this->is_published && $this->published_at && $this->published_at <= now();
}
```

### Observer Pattern
All models with cached data MUST have observers for cache invalidation:

```php
// app/Observers/{Model}Observer.php
public function saving(Model $model): void {
    // Normalize slug if needed (slug generation is in model boot)
    if (!empty($model->slug)) {
        $slug = Str::slug(trim($model->slug));
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $count = 1;
        
        while (Model::where('slug', $slug)
            ->where('id', '!=', $model->id ?? 0)
            ->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        $model->slug = $slug;
    }
}

public function saved(Model $model): void {
    $this->clearModelCaches();
}

public function deleted(Model $model): void {
    $this->clearModelCaches();
}

protected function clearModelCaches(): void {
    Cache::forget('homepage_v2_data');
    // Clear model-specific caches
}
```

Register in `AppServiceProvider::boot()`:
```php
Model::observe(ModelObserver::class);
```

### Admin Interface Structure

**IMPORTANT**: This project uses a custom admin interface, NOT Filament.

Admin controllers are located in `app/Http/Controllers/Admin/`:
- Handle CRUD operations
- Validate via Request classes in `app/Http/Requests/Admin/`
- Delegate to services for business logic
- Return views from `resources/views/admin/`

Admin views follow this structure:
- `resources/views/admin/layouts/` - Admin layout templates
- `resources/views/admin/{model}/` - Model-specific views (index, create, edit, show)
- `resources/views/admin/partials/` - Reusable admin components

### Frontend Component Rules

**Blade Components** (`resources/views/components/`):
- Use Tailwind utilities only (no custom CSS)
- Mobile-first responsive design
- Alpine.js for interactivity (x-data, x-show, x-on)
- Always provide fallback images: `getFirstMediaUrl('collection', 'conversion') ?: asset('images/placeholder.svg')`

**Homepage sections** (`resources/views/components/homepage/`):
- Check visibility: `@if($section?->is_active)`
- Use section data: `$section->data['key']`
- Eager load relationships to avoid N+1 queries
- Access media: `$section->getMediaUrl('images', 'medium') ?: asset('images/placeholder.svg')`

### Repository Pattern

```php
// app/Repositories/{Model}Repository.php
public function getPublished(int $perPage = 10) {
    return Cache::remember("models.published.{$perPage}", 1800, function() use ($perPage) {
        return $this->model
            ->with('media') // Eager load
            ->published()
            ->latest()
            ->paginate($perPage);
    });
}
```

Always use eager loading for relationships to prevent N+1 queries.

### Request Flow Examples

**Public page request:**
```
Route → Controller → Service → Repository → Model
                  ↓
    View (with cached data)
```

**Filament admin action:**
```
Resource → Form Schema → Model → Observer
                              ↓
                        Cache invalidation
```

## Directory Structure

```
app/
├── Console/Commands/        # Artisan commands
│   ├── BackfillEventSlugs.php
│   ├── GenerateSitemap.php
│   ├── SanitizeAnnouncements.php
│   └── UpdateVisionMission.php
├── Helpers/                # Global helper functions
│   ├── SiteSettingsHelper.php
│   ├── PageHelper.php
│   ├── SiteHelper.php
│   └── AnnouncementHelper.php
├── Http/
│   ├── Controllers/        # Request handlers
│   │   ├── Admin/         # Admin CRUD controllers
│   │   ├── Auth/          # Authentication controllers
│   │   └── *.php          # Public controllers
│   ├── Middleware/         # SetLocale, SecurityHeaders, CheckMaintenanceMode, EnsureUserHasRole
│   └── Requests/           # Form validation
│       ├── Admin/         # Admin request validation
│       └── *.php          # Public request validation
├── Mail/                   # Mailable classes
│   ├── AdmissionApplicationReceived.php
│   ├── CareerApplicationReceived.php
│   ├── ContactMessageReceived.php
│   └── NewsletterSubscriptionConfirmation.php
├── Models/                 # Eloquent models
│   ├── Event.php
│   ├── Notice.php
│   ├── Page.php
│   ├── Staff.php
│   ├── HomePageSection.php
│   ├── HomePageContent.php
│   ├── NavigationItem.php
│   ├── SiteSettings.php
│   ├── Announcement.php
│   ├── AdmissionApplication.php
│   ├── CareerApplication.php
│   ├── Subscriber.php
│   └── User.php
├── Observers/              # Model lifecycle hooks
│   ├── EventObserver.php
│   ├── NoticeObserver.php
│   ├── PageObserver.php
│   ├── HomePageSectionObserver.php
│   ├── HomePageContentObserver.php
│   ├── NavigationItemObserver.php
│   └── MediaObserver.php
├── Repositories/           # Data access layer
│   ├── EventRepository.php
│   ├── NoticeRepository.php
│   ├── PageRepository.php
│   ├── StaffRepository.php
│   ├── NavigationRepository.php
│   ├── AdmissionRepository.php
│   ├── CareerRepository.php
│   └── ContactRepository.php
├── Services/               # Business logic layer
│   ├── EventService.php
│   ├── NoticeService.php
│   ├── PageService.php
│   ├── StaffService.php
│   ├── NavigationService.php
│   ├── SearchService.php
│   ├── AdmissionService.php
│   ├── CareerService.php
│   └── ContactService.php
├── Traits/                 # HasWebPMedia
└── View/
    └── Components/         # Blade component classes
        ├── AppLayout.php
        ├── GuestLayout.php
        └── Navbar.php

resources/views/
├── admin/                 # Admin interface views
│   ├── layouts/          # Admin layout templates
│   ├── partials/         # Admin components
│   ├── events/           # Event management
│   ├── notices/          # Notice management
│   ├── pages/            # Page management
│   ├── staff/            # Staff management
│   ├── homepage-sections/ # Homepage section management
│   ├── navigation-items/ # Navigation management
│   ├── settings/         # Site settings
│   ├── admission-applications/
│   ├── career-applications/
│   └── announcements/
├── components/
│   ├── homepage/          # Homepage section components
│   │   ├── advisors-section.blade.php
│   │   ├── board-members-section.blade.php
│   │   ├── competitions-section.blade.php
│   │   └── news-events-section.blade.php
│   ├── home/             # Home page specific components
│   ├── layouts/          # Base layouts (app, guest)
│   ├── molecules/        # Small reusable components
│   ├── organisms/        # Complex components
│   ├── templates/        # Page templates
│   ├── utilities/        # Utility components
│   └── *.blade.php       # Reusable components
├── emails/               # Email templates
│   ├── newsletter/
│   ├── admission-application-received.blade.php
│   ├── career-application-received.blade.php
│   └── contact-message-received.blade.php
├── layouts/              # Main layouts
│   ├── app.blade.php
│   ├── guest.blade.php
│   └── navigation.blade.php
└── pages/                # Public page templates
    ├── events/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── notices/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── staff/
    │   └── index.blade.php
    ├── home.blade.php
    ├── about.blade.php
    ├── academics.blade.php
    ├── admission.blade.php
    ├── careers.blade.php
    ├── contact.blade.php
    ├── leadership.blade.php
    ├── page.blade.php
    └── search.blade.php
```

## Code Style Rules

### Blade Templates
- Use `@props()` for component properties
- Extract repeated markup to components
- Use `{{ }}` for escaped output, `{!! !!}` only for trusted HTML
- Localize all user-facing text: `{{ __('common.key') }}`
- Check section visibility: `@if($section?->is_visible)`

### Controllers
- Keep thin - delegate to services
- Return views or JSON responses
- Use type hints for dependencies
- Validate via Request classes

```php
public function store(StoreEventRequest $request) {
    $event = $this->eventService->create($request->validated());
    return redirect()->route('events.show', $event);
}
```

### Services
- Handle business logic and transactions
- Return models or collections
- Throw exceptions for errors

```php
public function create(array $data): Event {
    DB::beginTransaction();
    try {
        $event = $this->repository->create($data);
        // Additional logic
        DB::commit();
        return $event;
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}
```

### Caching Strategy
- Repository layer: 30-minute cache for listings
- Cache tags: `['events']`, `['notices']`, `['pages']`
- Invalidate in observers on model save/delete
- Use `Cache::remember()` for queries
- Production only: `config:cache`, `route:cache`, `view:cache`

## Bilingual Implementation

All public content supports English (default) and Bengali:
- Translation files: `lang/en/common.php`, `lang/bn/common.php`
- Use `__('common.key')` in Blade templates
- Database fields: Store both languages where applicable
- Middleware: `SetLocale` reads from session/cookie
- Language switcher: `LanguageController` sets session

## Media Handling

Spatie Media Library with WebP conversion:
- Collections: `featured_image`, `gallery`, `profile_photo`, `documents`
- Conversions: `thumb`, `medium`, `large` (auto-generated)
- Always use: `$model->getFirstMediaUrl('collection', 'conversion') ?: asset('images/placeholder.svg')`
- Observer: `MediaObserver` handles WebP conversion

## Security & Permissions

- Middleware: `EnsureUserHasRole` for admin routes
- Filament: Implement `canViewAny()`, `canCreate()`, `canEdit()`, `canDelete()`
- Roles: `admin`, `editor`, `admissions_officer`
- CSRF protection on all forms
- Security headers via `SecurityHeaders` middleware

## Testing Patterns

```php
// Feature tests: Full request/response cycle
public function test_user_can_view_event() {
    $event = Event::factory()->create(['is_published' => true]);
    $response = $this->get(route('events.show', $event));
    $response->assertOk();
}

// Unit tests: Isolated logic
public function test_event_generates_slug() {
    $event = Event::factory()->create(['title' => 'Test Event']);
    $this->assertEquals('test-event', $event->slug);
}
```

## Common Pitfalls to Avoid

- ❌ N+1 queries - Always eager load relationships with `->with()`
- ❌ Hardcoded text - Use `__('common.key')` for all user-facing text
- ❌ Missing cache invalidation - Add to observers' `saved()` and `deleted()` methods
- ❌ Direct model queries in controllers - Use repositories
- ❌ Slug generation in observers - Should be in model's `boot()` method
- ❌ Forgetting media fallbacks - Always provide placeholder: `?: asset('images/placeholder.svg')`
- ❌ Skipping role checks in admin controllers - Use `EnsureUserHasRole` middleware
- ❌ Using `is_visible` instead of `is_active` for HomePageSection
- ❌ Forgetting to clear `homepage_v2_data` cache when updating content
