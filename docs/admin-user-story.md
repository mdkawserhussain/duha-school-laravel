# Admin Panel User Story

## User Story: Admin Content Management

**As a** school administrator  
**I want to** manage all website content through a custom admin panel  
**So that** I can update the website without technical knowledge

---

## Acceptance Criteria

### 1. Authentication & Access
- ✅ Admin can log in with email and password
- ✅ Admin sees dashboard with statistics
- ✅ Admin can navigate to all content sections
- ✅ Admin can log out securely

### 2. Dashboard
- ✅ Dashboard displays key statistics (pages, events, staff, applications)
- ✅ Dashboard shows recent activity (events, notices, applications)
- ✅ Dashboard provides quick action links
- ✅ Statistics are role-based (admin vs admissions officer)

### 3. Content Management

#### Events Management
- ✅ Admin can create new events with title, description, dates, location
- ✅ Admin can upload featured images for events
- ✅ Admin can edit existing events
- ✅ Admin can delete events
- ✅ Admin can view list of all events with filters
- ✅ Admin can set event status (draft/published/archived)

#### Notices Management
- ✅ Admin can create notices with title, content, category
- ✅ Admin can mark notices as important
- ✅ Admin can set publication date
- ✅ Admin can upload featured images
- ✅ Admin can edit and delete notices

#### Pages Management
- ✅ Admin can create dynamic pages
- ✅ Admin can use rich text editor (TinyMCE) for content
- ✅ Admin can set page categories and menu order
- ✅ Admin can manage SEO meta information
- ✅ Admin can upload featured images

#### Staff Management
- ✅ Admin can add staff members with profile information
- ✅ Admin can upload profile photos
- ✅ Admin can set staff positions and bios
- ✅ Admin can manage staff social links
- ✅ Admin can activate/deactivate staff members

### 4. Homepage Management

#### Hero Slider
- ✅ Admin can create hero slides
- ✅ Admin can upload background images/videos
- ✅ Admin can set slide content (title, subtitle, buttons)
- ✅ Admin can reorder slides
- ✅ Admin can activate/deactivate slides
- ✅ Admin can duplicate slides

#### Homepage Sections
- ✅ Admin can manage homepage sections
- ✅ Admin can upload multiple images per section
- ✅ Admin can set section content and data (JSON)
- ✅ Admin can control section visibility and order

#### Homepage Contents
- ✅ Admin can manage homepage content blocks
- ✅ Admin can use rich text editor
- ✅ Admin can upload images
- ✅ Admin can control content visibility

### 5. Navigation & Settings

#### Navigation Items
- ✅ Admin can create navigation menu items
- ✅ Admin can set parent-child relationships
- ✅ Admin can control menu order
- ✅ Admin can set external/internal links

#### Announcements
- ✅ Admin can create announcement bar messages
- ✅ Admin can set start and expiry dates
- ✅ Admin can control announcement visibility

#### Site Settings
- ✅ Admin can update website name and tagline
- ✅ Admin can update contact information
- ✅ Admin can manage social media links
- ✅ Admin can upload logo and favicon
- ✅ Admin can set theme colors

### 6. Application Management

#### Admission Applications
- ✅ Admin can view all admission applications
- ✅ Admin can filter applications by status
- ✅ Admin can view application details
- ✅ Admin can update application status

#### Career Applications
- ✅ Admin can view all career applications
- ✅ Admin can download applicant resumes
- ✅ Admin can update application status

### 7. Media Management
- ✅ Admin can upload images (automatically converted to WebP)
- ✅ Admin can upload multiple images
- ✅ Admin can delete images
- ✅ Images are optimized and stored properly

### 8. Rich Text Editing
- ✅ Admin can use TinyMCE editor for content
- ✅ Admin can format text (bold, italic, lists)
- ✅ Admin can insert images via editor
- ✅ Admin can create links
- ✅ Admin can view HTML source code

---

## User Journey Example

1. **Login**: Admin logs in at `/login`
2. **Dashboard**: Admin sees dashboard with statistics
3. **Create Event**: Admin navigates to Events → Create New
   - Fills in event details
   - Uploads featured image
   - Sets dates and location
   - Saves event
4. **Edit Notice**: Admin navigates to Notices → Clicks Edit on a notice
   - Updates content using rich text editor
   - Changes publication date
   - Saves changes
5. **Manage Hero Slider**: Admin navigates to Hero Slider
   - Creates new slide
   - Uploads background image
   - Sets slide content
   - Reorders slides
6. **Update Settings**: Admin navigates to Site Settings
   - Updates website name
   - Uploads new logo
   - Saves settings
7. **Review Applications**: Admin navigates to Admission Applications
   - Views pending applications
   - Updates application status
8. **Logout**: Admin logs out securely

---

## Technical Requirements Met

- ✅ Custom admin panel (no Filament dependency)
- ✅ Role-based access control (Spatie Permission)
- ✅ Rich text editing (TinyMCE)
- ✅ File uploads (Spatie Media Library)
- ✅ WebP image conversion
- ✅ Cache management
- ✅ Responsive design
- ✅ Form validation
- ✅ Error handling

---

**Last Updated**: 2025-01-18

