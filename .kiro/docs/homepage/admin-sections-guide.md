# Admin Dashboard - Homepage Sections Management

## Overview

All homepage sections are fully editable through the Filament admin panel. The admin automatically discovers all section pages in `app/Filament/Pages/`.

## Accessing Homepage Sections

1. Login to admin panel: `/admin`
2. Navigate to **Homepage Settings** group in the sidebar
3. Select any section to edit

## Available Homepage Sections

### 📋 Complete List (19 Sections)

| Section Name | Navigation Label | Icon | Description |
|-------------|------------------|------|-------------|
| **AchievementsSection** | Achievements | Trophy | Student achievements and recognitions |
| **AdvisorsSection** | Advisors & Board | Users | School advisors and board members |
| **BoardMembersSection** | Board Members | User Group | Board of directors/trustees |
| **VisionMissionSection** | Vision & Mission | Eye | School vision, mission & values |
| **CallToActionSection** | Call to Action | Megaphone | CTA banners and prompts |
| **ChildrenResponsibilitySection** | Children Responsibility | Heart | School responsibility statement |
| **CompetitionSection** | Competitions | Trophy | Competition achievements |
| **EnrollmentNewsSection** | Enrollment News | Newspaper | Enrollment information |
| **HeroSliderManager** | Hero Slider | Photo | Homepage hero carousel |
| **NoticeBoardSection** | Notice Board | Bell | Notice board highlights |
| **OurValuesSection** | Our Values | Star | Core institutional values |
| **ParallaxSection** | Parallax Experience | Sparkles | Parallax visual section |
| **ProgramsSection** | Academic Programs | Academic Cap | Academic program offerings |
| **RegularEventsSection** | Regular Events | Calendar | Regular event highlights |
| **StatHighlightsSection** | Stat Highlights | Chart Bar | Statistical highlights |
| **StatsHeadingSection** | Stats Heading | Presentation | Stats section heading |
| **StatsSection** | Statistics | Chart | School statistics |
| **UpcomingEventsSection** | Upcoming Events | Calendar Days | Upcoming events preview |
| **WhyChooseUsSection** | Why Choose Us | Check Badge | Why choose our school |

## Vision & Mission Section - Detailed Fields

### Section Badge & Heading
- **Badge Text**: Small text in the badge (e.g., "Our Islamic Charter")
- **Heading Line 1**: First line of heading (e.g., "Nurturing Faith,")
- **Heading Line 2**: Second line highlighted (e.g., "Inspiring Excellence")
- **Section Description**: Brief description below heading

### Vision Card
- **Vision Title**: Title for vision card (default: "Our Vision")
- **Vision Statement**: Your school's vision statement (max 500 chars)

### Mission Card
- **Mission Title**: Title for mission card (default: "Our Mission")
- **Mission Statement**: Your school's mission statement (max 500 chars)

### Feature Pills
- **Features**: Repeater field for feature highlights (0-6 items)
  - Each feature has a text field (max 100 chars)
  - Displayed as pills below the cards

### Campus Image Section
- **Campus Image**: Upload campus photo (JPEG, PNG, WebP, SVG)
  - Max size: 5MB
  - Stored in `storage/app/public/vision-section/`
  - Includes image editor
- **Image Overlay Title**: Title on image (e.g., "Our Islamic Campus")
- **Image Overlay Subtitle**: Subtitle on image (e.g., "Where Iman meets Innovation")

### Core Values Card
- **Values Card Title**: Title for values card (default: "Islamic Core Values")
- **Core Values**: Repeater field for values (1-10 items)
  - Each value has a text field (max 100 chars)
  - Displayed in floating card on image

### Section Settings
- **Sort Order**: Numeric order for section positioning
- **Active**: Toggle to show/hide section on homepage

## Common Features Across All Sections

### Standard Fields (via ManagesHomePageSection trait)
- Title
- Subtitle
- Description
- Content (Rich Text Editor)
- Button Text
- Button Link
- Icon (for info blocks)
- Sort Order
- Active Toggle
- Image Upload

### Media Management
- All sections support image uploads via Spatie Media Library
- Images automatically converted to WebP format
- Responsive conversions: thumb (300x300), medium (600x400), large (1920x1080)
- Stored in `storage/app/public/homepage-sections/`

### Cache Management
- Homepage data cached for 1 hour (`homepage_v2_data`)
- Cache automatically cleared when saving any section
- Manual cache clear: `php artisan cache:forget homepage_v2_data`

## Navigation Groups

Sections are organized in the admin sidebar:

### Homepage Settings
- All 19 homepage section pages
- Grouped together for easy access
- Alphabetically sorted by default

### Other Groups
- **Dashboard**: Overview widgets
- **Content**: Pages, Events, Notices
- **Site Settings**: General settings
- **People**: Staff, Users
- **Applications**: Admissions, Careers

## Permissions

Access controlled by roles:
- **Admin**: Full access to all sections
- **Editor**: Can edit content sections
- **Admissions Officer**: Limited to application-related content

## Seeding Homepage Sections

### Run All Seeders
```bash
php artisan db:seed
```

This will seed:
1. Site Settings
2. Roles & Permissions
3. Announcements
4. Homepage Sections (general)
5. Vision & Mission Section (Islamic content)
6. Pages
7. Events
8. Notices
9. Staff

### Run Specific Seeder
```bash
php artisan db:seed --class=VisionMissionSectionSeeder
```

### Using Custom Command
```bash
php artisan homepage:update-vision
```

## Tips for Managing Sections

### 1. Reordering Sections
- Edit the `sort_order` field in each section
- Lower numbers appear first
- Homepage template order:
  1. Hero (1)
  2. Achievements (4)
  3. Stats (5)
  4. News & Events (6)
  5. Parallax (8)
  6. Competitions (9)
  7. Advisors (2)
  8. Vision & Mission (3) ← Positioned here
  9. Board Members (3)
  10. Programs (12)

### 2. Hiding Sections
- Toggle `Active` to OFF
- Section won't appear on homepage
- Data is preserved

### 3. Image Best Practices
- Use high-quality images (min 1920x1080)
- Preferred formats: WebP, PNG, JPEG
- Keep file size under 2MB for faster loading
- Use descriptive filenames

### 4. Content Guidelines
- **Vision**: 1-2 sentences, aspirational
- **Mission**: 2-3 sentences, actionable
- **Values**: Short phrases (3-5 words each)
- **Features**: Concise highlights (5-10 words)

### 5. Testing Changes
1. Save section in admin
2. Clear browser cache (Ctrl+Shift+R)
3. Visit homepage
4. Check responsive design on mobile

## Troubleshooting

### Section Not Appearing
- Check `is_active` is TRUE
- Verify `sort_order` is set
- Clear cache: `php artisan cache:forget homepage_v2_data`
- Check browser console for errors

### Image Not Uploading
- Check file size (max 5MB)
- Verify file format (JPEG, PNG, WebP, SVG)
- Ensure storage is writable: `php artisan storage:link`
- Check logs: `storage/logs/laravel.log`

### Changes Not Showing
- Clear Laravel cache: `php artisan cache:clear`
- Clear view cache: `php artisan view:clear`
- Hard refresh browser: Ctrl+Shift+R
- Check if section is active

## API for Developers

### Accessing Section Data in Code
```php
use App\Models\HomePageSection;

// Get specific section
$vision = HomePageSection::where('section_key', 'vision')->first();

// Get all active sections
$sections = HomePageSection::active()->ordered()->get();

// Get section data
$visionText = $vision->data['vision_text'] ?? 'Default vision';

// Get section image
$imageUrl = $vision->getFirstMediaUrl('images');
```

### Creating New Section Page
1. Create file: `app/Filament/Pages/YourSection.php`
2. Extend `Page` and implement `HasForms`
3. Use `ManagesHomePageSection` trait
4. Define `getSectionKey()`, `getSectionType()`, `getSectionTitle()`
5. Customize `form()` method for specific fields
6. Auto-discovered by Filament

## Related Files

- **Models**: `app/Models/HomePageSection.php`
- **Trait**: `app/Filament/Pages/Concerns/ManagesHomePageSection.php`
- **Controller**: `app/Http/Controllers/HomeController.php`
- **View**: `resources/views/pages/home.blade.php`
- **Components**: `resources/views/components/homepage/*.blade.php`
- **Seeders**: `database/seeders/HomePageSectionSeeder.php`, `VisionMissionSectionSeeder.php`
- **Migration**: `database/migrations/*_create_home_page_sections_table.php`

## Related Documentation

- [Quick Start Guide](./quick-start-vision-mission.md) - Quick setup
- [Vision & Mission Update](./vision-mission-update.md) - Detailed update info
- [Project Structure](./../../steering/structure.md) - Architecture overview
