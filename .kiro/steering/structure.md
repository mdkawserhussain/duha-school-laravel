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


## Recent Structural Changes (Nov 26, 2025)

### Homepage Redesign Architecture

**Complete visual overhaul** to match beta.zaitoonacademy.com reference design.

**Key Architectural Changes:**
1. **Color System**: Migrated to exact hex values (#0d5a47, #fbbf24)
2. **Animation System**: Implemented native Intersection Observer
3. **Component Standardization**: All sections follow consistent pattern
4. **Performance**: Hardware-accelerated animations, optimized queries

### Homepage Component Pattern

All homepage sections now follow this standardized structure:

```html
<section class="py-16 lg:py-24" 
         style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl lg:text-4xl font-bold" 
                style="color: #0d5a47;">
                {{ $section->data['title'] ?? 'Section Title' }}
            </h2>
            @if(!empty($section->data['subtitle']))
            <p class="mt-4 text-lg text-gray-600">
                {{ $section->data['subtitle'] }}
            </p>
            @endif
        </div>
        
        <!-- Section Content with Animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($items as $item)
            <div class="stagger-item">
                <!-- Card content -->
            </div>
            @endforeach
        </div>
    </div>
</section>
```

### Animation Implementation Strategy

**Animation Classes by Use Case:**
- **Section headers**: `fade-in` - Subtle entrance
- **Images/left content**: `slide-left` - Directional flow
- **Text/right content**: `slide-right` - Balanced layout
- **Cards in grids**: `stagger-item` - Auto-cascading effect (100ms delay per item)
- **Featured content**: `zoom-in` - Draw attention
- **List items**: `slide-up` - Bottom-to-top reveal

**Implementation Example:**
```html
<!-- Hero Section -->
<div class="fade-in">
    <h1>Welcome to Zaitoon Academy</h1>
</div>

<!-- Two-column Layout -->
<div class="grid grid-cols-2 gap-8">
    <div class="slide-left">
        <img src="..." alt="...">
    </div>
    <div class="slide-right">
        <p>Content text...</p>
    </div>
</div>

<!-- Card Grid -->
<div class="grid grid-cols-3 gap-6">
    <div class="stagger-item">Card 1</div>
    <div class="stagger-item">Card 2</div>
    <div class="stagger-item">Card 3</div>
</div>
```

### Header Structure (Updated)

**File:** `resources/views/components/header-zaitoon.blade.php`

**Two-tier structure:**

1. **Top Bar** (`h-10`, background: `#0d5a47`):
   - Left: Contact info (phone, email with icons)
   - Right: 5 action buttons (Notice, News, Careers, FAQ, Apply Online)
   - All buttons: Yellow background (#fbbf24) with green text

2. **Main Navigation** (`h-16 lg:h-18`, background: white):
   - Logo: `h-10 lg:h-12`
   - Nav links: Dark gray (#1f2937), hover to green (#0d5a47)
   - CTA button: Yellow "Apply Online"
   - Mobile: Hamburger menu with Alpine.js

**Removed Elements:**
- Announcement ticker bar
- Social media icons in top bar
- Multiple redundant action buttons

### Footer Structure (Updated)

**File:** `resources/views/components/footer-zaitoon.blade.php`

**Structure:**
- Wave SVG decoration (fill: #0d5a47)
- Background: #0d5a47 (green)
- Newsletter signup: Yellow button with green text
- Links: White with 90% opacity
- Back-to-top button: Yellow with green text
- Social media icons: White

### Data Flow Architecture

**Homepage Data Loading:**
```php
// HomeController.php
public function index() {
    $data = Cache::remember('homepage_v2_data', 3600, function() {
        return [
            'sections' => HomePageSection::active()
                ->ordered()
                ->with('media')
                ->get(),
            'events' => Event::published()
                ->with('media')
                ->latest()
                ->take(6)
                ->get(),
            'notices' => Notice::published()
                ->with('media')
                ->latest()
                ->take(5)
                ->get(),
            // ... other data
        ];
    });
    
    return view('pages.home', $data);
}
```

**Cache Invalidation:**
```php
// EventObserver.php, NoticeObserver.php, etc.
public function saved($model): void {
    Cache::forget('homepage_v2_data');
    Cache::tags(['events'])->flush();
}

public function deleted($model): void {
    Cache::forget('homepage_v2_data');
    Cache::tags(['events'])->flush();
}
```

### Component Visibility Control

**CRITICAL:** Always check `is_active` (not `is_visible`):

```php
// ✅ CORRECT
@if($section?->is_active)
    <x-homepage.section-name :section="$section" />
@endif

// ❌ WRONG
@if($section?->is_visible)
    <x-homepage.section-name :section="$section" />
@endif
```

**Reason:** `HomePageSection` model uses `is_active` field for visibility control.

### Media Handling Pattern

**Always provide fallbacks:**

```php
// ✅ CORRECT - With fallback
$imageUrl = $event->getFirstMediaUrl('featured_image', 'medium') 
    ?: asset('images/placeholder.svg');

// ✅ CORRECT - In Blade
<img src="{{ $event->getFirstMediaUrl('featured_image', 'medium') ?: asset('images/placeholder.svg') }}" 
     alt="{{ $event->title }}"
     loading="lazy">

// ❌ WRONG - No fallback
<img src="{{ $event->getFirstMediaUrl('featured_image', 'medium') }}" 
     alt="{{ $event->title }}">
```

### Query Optimization Patterns

**N+1 Prevention:**

```php
// ✅ GOOD - Eager loading
$events = Event::with(['media', 'author'])
    ->published()
    ->latest()
    ->get();

// ✅ GOOD - Nested eager loading
$sections = HomePageSection::with([
    'media',
    'contents' => function($query) {
        $query->ordered();
    }
])->active()->ordered()->get();

// ❌ BAD - N+1 queries
$events = Event::published()->get();
foreach ($events as $event) {
    $event->media; // Separate query!
    $event->author; // Another query!
}
```

**Repository Caching:**

```php
// EventRepository.php
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

public function getFeatured(int $limit = 6) {
    return Cache::remember(
        "events.featured.{$limit}",
        1800,
        fn() => $this->model
            ->with('media')
            ->published()
            ->where('is_featured', true)
            ->latest()
            ->take($limit)
            ->get()
    );
}
```

### Slug Generation Pattern (CRITICAL)

**Slug generation MUST be in model's `boot()` method, NOT in observers:**

```php
// ✅ CORRECT - In Model boot()
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

// ❌ WRONG - In Observer
// Observers should only normalize existing slugs, not generate them
```

**Observer Role (Slug Normalization Only):**

```php
// EventObserver.php
public function saving(Event $event): void {
    // Only normalize if slug already exists
    if (!empty($event->slug)) {
        $slug = Str::slug(trim($event->slug));
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $count = 1;
        
        while (Event::where('slug', $slug)
            ->where('id', '!=', $event->id ?? 0)
            ->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        $event->slug = $slug;
    }
}
```

### Admin Interface Patterns

**Controller Structure:**

```php
// app/Http/Controllers/Admin/EventController.php
class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService,
        protected EventRepository $eventRepository
    ) {
        $this->middleware(['auth', 'role:admin|editor']);
    }
    
    public function index() {
        $events = $this->eventRepository->paginate(15);
        return view('admin.events.index', compact('events'));
    }
    
    public function store(StoreEventRequest $request) {
        $event = $this->eventService->create($request->validated());
        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }
    
    public function update(UpdateEventRequest $request, Event $event) {
        $this->eventService->update($event, $request->validated());
        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }
}
```

**View Structure:**

```php
// resources/views/admin/events/index.blade.php
@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Events</h1>
        <a href="{{ route('admin.events.create') }}" 
           class="btn btn-primary">
            Create Event
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>
                        <span class="badge {{ $event->is_published ? 'badge-success' : 'badge-warning' }}">
                            {{ $event->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td>{{ $event->start_date->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event) }}" 
                              method="POST" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
```

### Testing Patterns

**Feature Test Example:**

```php
// tests/Feature/EventTest.php
public function test_user_can_view_published_event()
{
    $event = Event::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);
    
    $response = $this->get(route('events.show', $event));
    
    $response->assertOk();
    $response->assertSee($event->title);
    $response->assertSee($event->excerpt);
}

public function test_user_cannot_view_unpublished_event()
{
    $event = Event::factory()->create([
        'is_published' => false,
    ]);
    
    $response = $this->get(route('events.show', $event));
    
    $response->assertNotFound();
}
```

**Unit Test Example:**

```php
// tests/Unit/EventTest.php
public function test_event_generates_unique_slug()
{
    $event1 = Event::factory()->create(['title' => 'Test Event']);
    $event2 = Event::factory()->create(['title' => 'Test Event']);
    
    $this->assertEquals('test-event', $event1->slug);
    $this->assertEquals('test-event-1', $event2->slug);
}

public function test_event_scope_published_only_returns_published_events()
{
    Event::factory()->create(['is_published' => true]);
    Event::factory()->create(['is_published' => false]);
    
    $publishedEvents = Event::published()->get();
    
    $this->assertCount(1, $publishedEvents);
    $this->assertTrue($publishedEvents->first()->is_published);
}
```

### File Organization Best Practices

**Component Organization:**
```
resources/views/components/
├── homepage/              # Homepage-specific sections
│   ├── zaitoon-*.blade.php
│   ├── advisors-section.blade.php
│   └── board-members-section.blade.php
├── layouts/              # Layout wrappers
│   ├── app.blade.php
│   └── guest.blade.php
├── molecules/            # Small reusable components
│   ├── card.blade.php
│   └── button.blade.php
├── organisms/            # Complex components
│   ├── event-grid.blade.php
│   └── staff-list.blade.php
└── utilities/            # Helper components
    ├── loading.blade.php
    └── error.blade.php
```

**Service Organization:**
```
app/Services/
├── EventService.php      # Event business logic
├── NoticeService.php     # Notice business logic
├── PageService.php       # Page business logic
├── SearchService.php     # Search functionality
└── MediaService.php      # Media processing
```

**Repository Organization:**
```
app/Repositories/
├── EventRepository.php   # Event data access
├── NoticeRepository.php  # Notice data access
├── PageRepository.php    # Page data access
└── BaseRepository.php    # Shared repository logic
```

### Common Pitfalls (UPDATED)

- ❌ N+1 queries - Always eager load relationships with `->with()`
- ❌ Hardcoded text - Use `__('common.key')` for all user-facing text
- ❌ Missing cache invalidation - Add to observers' `saved()` and `deleted()` methods
- ❌ Direct model queries in controllers - Use repositories
- ❌ Slug generation in observers - Should be in model's `boot()` method
- ❌ Forgetting media fallbacks - Always provide placeholder: `?: asset('images/placeholder.svg')`
- ❌ Skipping role checks in admin controllers - Use `EnsureUserHasRole` middleware
- ❌ Using `is_visible` instead of `is_active` for HomePageSection
- ❌ Forgetting to clear `homepage_v2_data` cache when updating content
- ❌ Not using animation classes on new sections
- ❌ Using Tailwind colors instead of exact hex values for brand colors
- ❌ Forgetting to include scroll-animations.js in new layouts
- ❌ Not testing scroll animations on mobile devices
- ❌ Missing `loading="lazy"` on images below the fold