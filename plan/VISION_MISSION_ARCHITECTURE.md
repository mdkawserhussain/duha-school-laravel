# Vision & Mission Section - Architecture

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     ADMIN DASHBOARD                          │
│  (Homepage Settings > Vision & Mission)                      │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Admin edits form
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│         VisionMissionSection.php (Filament Page)             │
│  - Defines form schema with 7 sections                       │
│  - Handles validation                                        │
│  - Processes image uploads                                   │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Saves data
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│      ManagesHomePageSection Trait (Save Logic)               │
│  - Extracts form data                                        │
│  - Saves to database                                         │
│  - Handles media uploads                                     │
│  - Clears cache                                              │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Stores in
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│              DATABASE (home_page_sections)                   │
│  ┌─────────────────────────────────────────────────────┐    │
│  │ section_key: 'vision'                                │    │
│  │ section_type: 'vision_mission'                       │    │
│  │ description: "We follow the footsteps..."            │    │
│  │ data: {                                              │    │
│  │   badge_text: "Our Charter"                          │    │
│  │   heading_line1: "Empowering Minds,"                 │    │
│  │   heading_line2: "Enriching Hearts"                  │    │
│  │   vision_text: "To cultivate..."                     │    │
│  │   mission_text: "Deliver Cambridge..."               │    │
│  │   features: [...]                                    │    │
│  │   core_values: [...]                                 │    │
│  │   ...                                                │    │
│  │ }                                                    │    │
│  │ is_active: true                                      │    │
│  └─────────────────────────────────────────────────────┘    │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Retrieved by
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│           HomeController.php (Frontend)                      │
│  - Fetches all homepage sections                             │
│  - Groups by section_key                                     │
│  - Passes to view as $homePageSections                       │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Passes data to
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│              home.blade.php (Homepage)                       │
│  @include('components.homepage.vision-section')              │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Includes
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│      vision-section.blade.php (Component)                    │
│  - Extracts data from $homePageSections['vision']            │
│  - Applies fallback values                                   │
│  - Renders HTML with dynamic content                         │
│  - Shows/hides based on is_active                            │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ Displays to
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                    END USER (Website Visitor)                │
│  Sees the Vision & Mission section with updated content      │
└─────────────────────────────────────────────────────────────┘
```

## Data Flow

### 1. Admin Input → Database
```
Admin Form Fields
    ↓
VisionMissionSection::form()
    ↓
ManagesHomePageSection::save()
    ↓
HomePageSection Model
    ↓
Database (home_page_sections table)
```

### 2. Database → Frontend Display
```
Database Query
    ↓
HomeController::index()
    ↓
$homePageSections array
    ↓
home.blade.php
    ↓
vision-section.blade.php
    ↓
Rendered HTML
```

## Key Components

### Backend (Admin)

| Component | Purpose | Location |
|-----------|---------|----------|
| VisionMissionSection | Filament page class | `app/Filament/Pages/` |
| ManagesHomePageSection | Shared logic trait | `app/Filament/Pages/Concerns/` |
| HomePageSection | Eloquent model | `app/Models/` |
| vision-mission-section.blade.php | Admin view | `resources/views/filament/pages/` |

### Frontend (Public)

| Component | Purpose | Location |
|-----------|---------|----------|
| HomeController | Fetches data | `app/Http/Controllers/` |
| home.blade.php | Homepage layout | `resources/views/pages/` |
| vision-section.blade.php | Section component | `resources/views/components/homepage/` |

### Database

| Table | Purpose | Key Fields |
|-------|---------|------------|
| home_page_sections | Stores all homepage sections | section_key, section_type, data, is_active |
| media | Stores uploaded images | model_type, model_id, collection_name |

## Form Structure

```
Vision & Mission Form
├── Section Badge & Heading
│   ├── Badge Text
│   ├── Heading Line 1
│   ├── Heading Line 2
│   └── Description
├── Vision Card
│   ├── Vision Title
│   └── Vision Statement *
├── Mission Card
│   ├── Mission Title
│   └── Mission Statement *
├── Feature Pills
│   └── Features (Repeater)
│       └── Text
├── Campus Image Section
│   ├── Campus Image (Upload)
│   ├── Image Overlay Title
│   └── Image Overlay Subtitle
├── Core Values Card
│   ├── Values Card Title
│   └── Core Values (Repeater)
│       └── Value
└── Section Settings
    ├── Sort Order
    └── Active Toggle

* = Required field
```

## Data Structure

### Database JSON Structure
```json
{
  "badge_text": "Our Charter",
  "heading_line1": "Empowering Minds,",
  "heading_line2": "Enriching Hearts",
  "vision_title": "Vision",
  "vision_text": "To cultivate God-conscious learners...",
  "mission_title": "Mission",
  "mission_text": "Deliver Cambridge excellence...",
  "features": [
    {"text": "Cambridge Primary to A-Level"},
    {"text": "Hifz & Nazira Tracks"},
    {"text": "Leadership & Service Labs"}
  ],
  "image_title": "Our Campus",
  "image_subtitle": "Where tradition meets innovation",
  "values_title": "Core Values",
  "core_values": [
    {"value": "Ihsan in every lesson"},
    {"value": "Amanah & compassion"},
    {"value": "Lifelong inquiry"}
  ]
}
```

## Security & Validation

### Admin Access
- Protected by Filament authentication
- Only authenticated admin users can access
- Role-based permissions (if configured)

### Input Validation
- Max length constraints on all text fields
- Required fields enforced
- File type validation for images
- File size limit (5MB)
- URL validation for links

### Data Sanitization
- Blade escaping for all output
- No raw HTML rendering
- XSS protection built-in

## Performance Considerations

### Caching
- Homepage data cached for performance
- Cache cleared automatically on save
- Manual cache clear available

### Image Optimization
- Automatic WebP conversion
- Multiple sizes generated (thumb, medium, large)
- Lazy loading supported
- CDN-ready URLs

### Database Queries
- Single query fetches all sections
- Eager loading of media
- Indexed by section_key

## Extensibility

### Adding New Fields
1. Add field to form in `VisionMissionSection.php`
2. Update view in `vision-section.blade.php`
3. Update seeder with default value
4. Update documentation

### Adding New Sections
1. Create new Filament page extending `ManagesHomePageSection`
2. Define form schema
3. Create corresponding Blade component
4. Include in homepage
5. Create seeder

### Customizing Styling
- All styles inline in Blade component
- Can be extracted to CSS classes
- Tailwind classes can be used
- Design system colors defined

## Troubleshooting

### Common Issues

| Issue | Cause | Solution |
|-------|-------|----------|
| Changes not showing | Cache not cleared | Save again or run `php artisan cache:clear` |
| Image not uploading | File too large | Reduce size below 5MB |
| Section not visible | is_active = false | Toggle "Active" to ON |
| Form not saving | Validation error | Check required fields |
| 404 on admin page | Route not registered | Run `php artisan route:clear` |

### Debug Commands

```bash
# Check if section exists
php artisan tinker --execute="App\Models\HomePageSection::where('section_key', 'vision')->first()"

# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Reset to defaults
php artisan db:seed --class=VisionMissionSectionSeeder

# Check logs
tail -f storage/logs/laravel.log
```
