# Admin Panel CRUD Operations Analysis

## Overview

The Duha International School admin panel is built with **Filament 4** and provides comprehensive CRUD (Create, Read, Update, Delete) operations for managing all content and applications.

## Admin Panel Access

- **URL**: `/admin`
- **Authentication**: Laravel Breeze with role-based access
- **Roles**: Admin, Editor, Admissions Officer

## CRUD Resources Summary

### 📊 Full CRUD Operations (Create, Read, Update, Delete)

| Resource | Model | Navigation Group | Icon | Permissions |
|----------|-------|------------------|------|-------------|
| **Pages** | Page | Pages | Document Text | Admin, Editor |
| **Events** | Event | Events | Calendar Days | Admin, Editor |
| **Notices** | Notice | Notices | Bell Alert | Admin, Editor |
| **Staff** | Staff | Staff | Users | Admin, Editor |
| **Announcements** | Announcement | Site Settings | Megaphone | Admin |

### 📋 View/Edit Only (No Create - User Submitted)

| Resource | Model | Navigation Group | Icon | Permissions |
|----------|-------|------------------|------|-------------|
| **Admission Applications** | AdmissionApplication | Applications | Document Plus | Admin, Admissions Officer |
| **Career Applications** | CareerApplication | Applications | Briefcase | Admin, Admissions Officer |

### ⚙️ Custom Pages (Homepage Sections - 19 Pages)

| Section | Type | Editable Fields | Media Support |
|---------|------|-----------------|---------------|
| Hero Slider | Carousel | Title, subtitle, button, images | ✅ Multiple images |
| Achievements | Content | Title, achievements list, icons | ✅ Images |
| Stats | Statistics | Stats data, heading, CTA | ❌ |
| Vision & Mission | Content | Vision, mission, values, features | ✅ Campus image |
| Advisors | People | Advisors list, bios, photos | ✅ Profile photos |
| Board Members | People | Members list, roles | ✅ Profile photos |
| Competitions | Content | Competition highlights | ✅ Images |
| Programs | Content | Academic programs, features | ✅ Images |
| Parallax | Visual | Title, description, features | ✅ Background image |
| + 10 more sections | Various | Custom fields per section | ✅ Various |

## Detailed CRUD Analysis

### 1. Pages Resource

**Full CRUD**: ✅ Create, Read, Update, Delete

#### Form Fields
- **Page Information**
  - Title (required, auto-generates slug)
  - Slug (unique, alpha-dash)
  - Content (Rich Text Editor)
  - Featured Image (with image editor, aspect ratios: 16:9, 4:3, 1:1)

- **SEO Settings**
  - Meta Title (max 60 chars)
  - Meta Description (max 160 chars)
  - OG Image URL

- **Publishing**
  - Status (draft/published)
  - Published At (datetime)

#### Table Columns
- Featured Image (circular thumbnail)
- Title (searchable, sortable)
- Slug (toggleable, hidden by default)
- Status (badge: draft=secondary, published=success)
- Published At (datetime, sortable)
- Updated At (toggleable, hidden by default)

#### Actions
- **Row Actions**: View, Edit, Delete
- **Bulk Actions**: Delete multiple
- **Filters**: Status (draft/published)

#### Permissions
- **View**: Admin, Editor
- **Create**: Admin, Editor
- **Edit**: Admin, Editor
- **Delete**: Admin only

---

### 2. Events Resource

**Full CRUD**: ✅ Create, Read, Update, Delete

#### Form Fields
- **Event Information**
  - Title (required, auto-generates slug)
  - Slug (unique, lowercase, alpha-dash)
  - Content (Rich Text Editor)
  - Location (text)
  - Featured Image (with image editor)

- **Event Schedule**
  - Start At (datetime, required)
  - End At (datetime, optional)
  - Category (text: Academic, Social, Islamic, Sports)
  - Is Featured (toggle)

- **Publishing**
  - Status (draft/published/archived)
  - Published At (datetime)

#### Table Columns
- Featured Image (circular)
- Title (searchable, sortable)
- Category (badge with color coding)
- Start Date (formatted with time)
- Location (searchable, toggleable)
- Is Featured (icon)
- Status (badge)
- Published At (toggleable)

#### Actions
- **Row Actions**: View, Edit, Delete
- **Bulk Actions**: Delete multiple
- **Filters**: Status, Category, Featured, Upcoming

#### Special Features
- **ICS Export**: Download event as calendar file
- **Slug Generation**: Automatic with uniqueness check
- **Scout Search**: Full-text search enabled

#### Permissions
- **View**: Admin, Editor
- **Create**: Admin, Editor
- **Edit**: Admin, Editor
- **Delete**: Admin only

---

### 3. Notices Resource

**Full CRUD**: ✅ Create, Read, Update, Delete

#### Form Fields
- **Notice Information**
  - Title (required, auto-generates slug)
  - Slug (unique, lowercase, regex validated)
  - Content (Rich Text Editor)
  - Featured Image (with image editor)

- **Notice Settings**
  - Category (Academic, Administrative, Events, General)
  - Is Featured (toggle for important notices)
  - Published At (datetime)

- **Publishing**
  - Status (draft/published)

#### Table Columns
- Featured Image (circular)
- Title (searchable, sortable, limited to 50 chars)
- Category (badge with color coding)
- Is Featured (icon: exclamation for important)
- Status (badge)
- Published At (datetime)
- Updated At (toggleable)

#### Actions
- **Row Actions**: View, Edit, Delete
- **Bulk Actions**: Delete multiple
- **Filters**: Status, Category, Featured

#### Permissions
- **View**: Admin, Editor
- **Create**: Admin, Editor
- **Edit**: Admin, Editor
- **Delete**: Admin only

---

### 4. Staff Resource

**Full CRUD**: ✅ Create, Read, Update, Delete

#### Form Fields
- **Staff Information**
  - Name (required)
  - Role/Title (required)
  - Bio (max 1000 chars, 4 rows)
  - Photo (image editor, aspect ratios: 1:1, 3:4)

- **Contact Information**
  - Email (email validation)
  - Phone (tel validation)
  - Social Links (repeater: platform + URL)
    - Platforms: Facebook, Twitter, LinkedIn, Instagram

- **Display Settings**
  - Order (numeric, controls display order)
  - Is Active (toggle)

#### Table Columns
- Photo (circular, 40px)
- Name (searchable, sortable)
- Role (searchable)
- Email (searchable, copyable)
- Phone (searchable, copyable, toggleable)
- Is Active (boolean icon)
- Order (sortable, toggleable)
- Updated At (toggleable)

#### Actions
- **Row Actions**: View, Edit, Delete
- **Bulk Actions**: Delete multiple
- **Filters**: Active Staff, Has Social Media

#### Permissions
- **View**: Admin, Editor
- **Create**: Admin, Editor
- **Edit**: Admin, Editor
- **Delete**: Admin only

---

### 5. Admission Applications Resource

**View/Edit Only**: ❌ No Create (User-submitted)

#### Form Fields
- **Application Details** (Read-only for most fields)
  - Parent Name
  - Child Name
  - Child DOB (date picker with age validation)
  - Grade Applied
  - Phone
  - Email
  - Message

- **Supporting Documents** (Read-only)
  - Documents repeater (name, path, type)
  - Disabled for editing

- **Application Status** (Editable)
  - Status (pending/reviewed/approved/rejected)
  - Reviewed At (datetime)
  - Review Notes (textarea)

#### Table Columns
- Child Name (searchable, sortable)
- Parent Name (searchable, sortable, toggleable)
- Grade Applied (badge, primary color)
- Email (searchable, copyable)
- Phone (searchable, copyable, toggleable)
- Status (badge with color: pending=warning, reviewed=info, approved=success, rejected=danger)
- Applied At (datetime, sortable)
- Reviewed At (toggleable)

#### Actions
- **Row Actions**: View, Edit, Download Documents
- **Bulk Actions**: Delete multiple
- **Filters**: Status, Grade Applied
- **Navigation Badge**: Shows count of pending applications

#### Special Features
- **Document Download**: Custom action to download all documents
- **Status Workflow**: Pending → Reviewed → Approved/Rejected
- **Email Notifications**: Sent on application submission

#### Permissions
- **View**: Admin, Admissions Officer
- **Create**: Disabled (public form only)
- **Edit**: Admin, Admissions Officer
- **Delete**: Admin only

---

### 6. Career Applications Resource

**View/Edit Only**: ❌ No Create (User-submitted)

#### Form Fields
- **Application Details** (Read-only for most fields)
  - Job Title
  - Applicant Name
  - Email
  - Phone
  - Cover Letter (max 2000 chars)
  - Resume/CV (PDF only, max 5MB, private storage)

- **Application Status** (Editable)
  - Status (pending/reviewed/shortlisted/rejected)
  - Reviewed At (datetime)
  - Review Notes (textarea)

#### Table Columns
- Job Title (searchable, sortable, badge)
- Applicant Name (searchable, sortable)
- Email (searchable, copyable)
- Phone (searchable, copyable, toggleable)
- Status (badge with color coding)
- Applied At (datetime, sortable)
- Reviewed At (toggleable)

#### Actions
- **Row Actions**: View, Edit, Download Resume
- **Bulk Actions**: Delete multiple
- **Filters**: Status, Position
- **Navigation Badge**: Shows count of pending applications

#### Special Features
- **Resume Download**: Custom action to download PDF resume
- **Status Workflow**: Pending → Reviewed → Shortlisted/Rejected
- **Email Notifications**: Sent on application submission

#### Permissions
- **View**: Admin, Admissions Officer
- **Create**: Disabled (public form only)
- **Edit**: Admin, Admissions Officer
- **Delete**: Admin only

---

### 7. Announcements Resource

**Full CRUD**: ✅ Create, Read, Update, Delete

#### Form Fields
- Title
- Content (Rich Text)
- Type (info/warning/success/danger)
- Is Active (toggle)
- Start Date
- End Date
- Display Location (header/footer/both)

#### Table Columns
- Title (searchable)
- Type (badge)
- Is Active (boolean)
- Start/End Dates
- Display Location

#### Actions
- **Row Actions**: Edit, Delete
- **Bulk Actions**: Delete multiple, Toggle Active
- **Filters**: Type, Active Status

#### Permissions
- **View**: Admin
- **Create**: Admin
- **Edit**: Admin
- **Delete**: Admin

---

## Homepage Sections Management

### Custom Filament Pages (19 Sections)

All homepage sections use the `ManagesHomePageSection` trait for consistent CRUD operations.

#### Common Features Across All Sections

**Standard Fields**:
- Title
- Subtitle
- Description
- Content (Rich Text)
- Button Text
- Button Link
- Sort Order (numeric)
- Is Active (toggle)

**Media Management**:
- Image Upload (via Spatie Media Library)
- Automatic WebP conversion
- Responsive image sizes: thumb (300x300), medium (600x400), large (1920x1080)
- Storage: `storage/app/public/homepage-sections/`

**Cache Management**:
- Auto-clear on save
- Cache key: `homepage_v2_data`
- Cache duration: 1 hour

#### Section-Specific Fields

**Vision & Mission Section**:
- Badge Text
- Heading Line 1 & 2
- Vision Title & Statement
- Mission Title & Statement
- Features (repeater, 0-6 items)
- Campus Image
- Image Overlay Title & Subtitle
- Core Values (repeater, 1-10 items)

**Hero Slider**:
- Multiple slides (repeater)
- Each slide: title, subtitle, description, button, image
- Academic highlights (repeater)

**Achievements Section**:
- Subtitle
- Achievements (repeater)
  - Title, copy, badge, icon

**Stats Section**:
- Stats (repeater)
  - Label, value, copy, icon
- CTA section
  - Title, buttons

**Advisors Section**:
- Advisors (repeater)
  - Name, role, bio, image, LinkedIn

**Programs Section**:
- Programs (repeater)
  - Title, grade range, description, icon, features
- Special features section

---

## Common CRUD Patterns

### Form Components Used

1. **TextInput**: Single-line text fields
2. **Textarea**: Multi-line text
3. **RichEditor**: WYSIWYG HTML editor
4. **FileUpload**: Image/file uploads with editor
5. **DatePicker**: Date selection
6. **DateTimePicker**: Date and time selection
7. **Select**: Dropdown selection
8. **Toggle**: Boolean on/off
9. **Repeater**: Dynamic list of items
10. **Section**: Grouped fields with heading

### Table Features

1. **Searchable Columns**: Quick search functionality
2. **Sortable Columns**: Click to sort
3. **Toggleable Columns**: Show/hide columns
4. **Copyable Columns**: One-click copy (emails, phones)
5. **Badge Columns**: Colored status indicators
6. **Icon Columns**: Boolean indicators
7. **Image Columns**: Thumbnail previews

### Actions Available

1. **View**: Read-only detail view
2. **Edit**: Modify existing record
3. **Delete**: Remove record (with confirmation)
4. **Bulk Delete**: Delete multiple records
5. **Custom Actions**: Download documents, export data

### Filters

1. **SelectFilter**: Dropdown filter
2. **Filter**: Custom query filter
3. **DateFilter**: Date range filter

---

## Role-Based Permissions

### Admin Role
- **Full Access**: All CRUD operations
- **Delete**: Can delete any record
- **Settings**: Access to site settings
- **Users**: Manage user accounts

### Editor Role
- **Content Management**: Pages, Events, Notices, Staff
- **No Delete**: Cannot delete records (admin only)
- **No Settings**: Cannot access site settings
- **No Applications**: Cannot view applications

### Admissions Officer Role
- **Applications Only**: Admission & Career applications
- **View/Edit**: Can review and update application status
- **No Delete**: Cannot delete applications
- **No Content**: Cannot manage pages, events, etc.

---

## Navigation Structure

### Dashboard
- Overview widgets
- Quick stats
- Recent activity

### Content
- Pages
- Events (with upcoming filter)
- Notices (with featured filter)

### Homepage Settings
- 19 custom section pages
- Grouped together
- Alphabetically sorted

### Staff
- Staff directory
- Social media management

### Applications
- Admission Applications (with badge count)
- Career Applications (with badge count)

### Site Settings
- Announcements
- General settings
- SEO configuration

---

## Special Features

### 1. Auto-Slug Generation
- Automatic slug creation from title
- Uniqueness validation
- Lowercase enforcement
- Regex validation for allowed characters

### 2. Image Management
- Spatie Media Library integration
- WebP conversion
- Responsive image sizes
- Image editor with aspect ratios
- Lazy loading support

### 3. SEO Optimization
- Meta title & description fields
- Open Graph image
- Sitemap generation
- Structured data support

### 4. Cache Management
- Automatic cache clearing on save
- Manual cache clear commands
- 1-hour cache duration
- Cache keys per section

### 5. Search Integration
- Laravel Scout for full-text search
- Searchable columns in tables
- Filter combinations

### 6. Validation
- Required field validation
- Email validation
- URL validation
- File type validation
- File size limits
- Date range validation

### 7. Notifications
- Success notifications on save
- Error notifications on failure
- Email notifications for applications
- Navigation badges for pending items

---

## API Endpoints (For Developers)

### Accessing Resources Programmatically

```php
use App\Models\Page;
use App\Models\Event;
use App\Models\HomePageSection;

// Get published pages
$pages = Page::published()->get();

// Get upcoming events
$events = Event::published()->upcoming()->get();

// Get active homepage section
$vision = HomePageSection::where('section_key', 'vision')
    ->active()
    ->first();

// Get section data
$visionText = $vision->data['vision_text'] ?? 'Default';

// Get section image
$imageUrl = $vision->getFirstMediaUrl('images');
```

---

## Related Documentation

- [Admin Sections Guide](./../docs/homepage/admin-sections-guide.md) - Homepage sections
- [Vision & Mission Update](./../docs/homepage/vision-mission-update.md) - Vision section
- [Project Structure](./../steering/structure.md) - Architecture overview
- [Tech Stack](./../steering/tech.md) - Commands and tools

---

## Summary

The admin panel provides:
- **7 Full CRUD Resources** (Pages, Events, Notices, Staff, Announcements, + 2 applications)
- **19 Custom Homepage Sections** (fully editable)
- **Role-Based Access Control** (Admin, Editor, Admissions Officer)
- **Media Management** (WebP conversion, responsive images)
- **SEO Tools** (meta tags, sitemap, structured data)
- **Search & Filters** (Laravel Scout, table filters)
- **Notifications** (success/error, email, badges)
- **Cache Management** (auto-clear, manual commands)

All resources follow consistent Filament patterns with form schemas, table configurations, and permission checks.
