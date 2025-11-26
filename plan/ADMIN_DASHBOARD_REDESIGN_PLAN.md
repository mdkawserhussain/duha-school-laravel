# Admin Dashboard Redesign Plan for New Homepage

## 📋 Executive Summary

The homepage has been redesigned with 9 component-based sections. The admin dashboard needs to be updated to manage all these sections dynamically. Currently, some sections are hardcoded and need admin interfaces, while others exist but need updates.

---

## 🔍 Current State Analysis

### ✅ **Sections WITH Admin Management**
1. **Hero Section** - `HeroSliderManager.php` (Multiple slides)
2. **Vision & Mission** - `VisionMissionSection.php` 
3. **Advisors** - `AdvisorsSection.php`
4. **Stat Highlights** - `StatHighlightsSection.php`

### ⚠️ **Sections WITH Partial Admin (Need Updates)**
1. **Competitions** - Has `CompetitionSection.php` but uses wrong `section_key` ('video_2' instead of 'competitions')
2. **News/Events** - Should use existing `EventService` but component has hardcoded data

### ❌ **Sections WITHOUT Admin Management (Hardcoded)**
1. **Achievements Section** - Hardcoded array in `achievements-section.blade.php`
2. **Stats Section** - Hardcoded array in `stats-section.blade.php`
3. **Parallax Section** - Hardcoded content in `parallax-section.blade.php`
4. **Programs Section** - Hardcoded program cards in `programs-section.blade.php`

---

## 📊 Section-by-Section Requirements

### 1. **Hero Section** ✅
- **Status**: Complete
- **Admin Page**: `HeroSliderManager.php`
- **Data Structure**: Multiple hero slides with images, titles, CTAs
- **Action**: No changes needed

### 2. **Achievements Section** ❌ NEW
- **Status**: Hardcoded
- **Component**: `achievements-section.blade.php`
- **Current Data**: Hardcoded array with 4 items
- **Required Admin Interface**:
  - Section header (title, subtitle, description)
  - Repeater for achievements:
    - Title (e.g., "Cambridge Top Achievers")
    - Copy/Description
    - Badge text (e.g., "IGCSE", "Hifz", "STEM", "Leadership")
    - Icon (SVG path or icon name)
  - Sort order
  - Active toggle
- **Section Key**: `achievements`
- **Section Type**: `achievements`

### 3. **Stats Section** ❌ NEW
- **Status**: Hardcoded
- **Component**: `stats-section.blade.php`
- **Current Data**: Hardcoded array with 4 stat items + CTA section
- **Required Admin Interface**:
  - Section header (title, subtitle, description)
  - Repeater for stats:
    - Label (e.g., "Students", "Teachers")
    - Value (e.g., "1200+", "85")
    - Copy/Description
    - Icon (SVG path)
  - CTA Section:
    - Title
    - Description
    - Button 1 (text, link)
    - Button 2 (text, link)
  - Sort order
  - Active toggle
- **Section Key**: `stats_main`
- **Section Type**: `stats`

### 4. **News/Events Section** ⚠️ UPDATE
- **Status**: Should use EventService but component has hardcoded data
- **Component**: `news-events-section.blade.php`
- **Current Data**: Hardcoded array with 3 events
- **Required Changes**:
  - Update component to use `$upcomingEvents` from `HomeController`
  - OR create admin interface for featured events
  - Section header management
- **Section Key**: `upcoming_events` (already exists)
- **Section Type**: `events`

### 5. **Vision & Mission Section** ✅
- **Status**: Complete
- **Admin Page**: `VisionMissionSection.php`
- **Action**: No changes needed

### 6. **Parallax Section** ❌ NEW
- **Status**: Hardcoded
- **Component**: `parallax-section.blade.php`
- **Current Data**: Hardcoded text and feature pills
- **Required Admin Interface**:
  - Background image upload
  - Section badge text
  - Main heading
  - Description
  - Repeater for feature pills (text)
  - CTA button (text, link)
  - Sort order
  - Active toggle
- **Section Key**: `parallax_experience`
- **Section Type**: `parallax`

### 7. **Competitions Section** ⚠️ UPDATE
- **Status**: Has admin but wrong section_key
- **Admin Page**: `CompetitionSection.php`
- **Current Issue**: Uses `section_key: 'video_2'` (wrong)
- **Required Changes**:
  - Update `getSectionKey()` to return `'competitions'`
  - Update `getSectionType()` to return `'competitions'`
  - Update form to match component structure:
    - Repeater for competitions:
      - Title
      - Copy/Description
      - Gradient colors (or preset options)
      - Icon (SVG path)
  - Update component to read from database
- **Section Key**: `competitions` (change from `video_2`)
- **Section Type**: `competitions` (change from `video`)

### 8. **Advisors Section** ✅
- **Status**: Complete
- **Admin Page**: `AdvisorsSection.php`
- **Action**: Verify component reads from database correctly

### 9. **Programs Section** ❌ NEW
- **Status**: Hardcoded
- **Component**: `programs-section.blade.php`
- **Current Data**: Hardcoded 3 program cards + special features section
- **Required Admin Interface**:
  - Section header (title, subtitle, description)
  - Repeater for programs:
    - Title (e.g., "Early Years")
    - Grade range (e.g., "Kindergarten - Grade 2")
    - Description
    - Icon background color
    - Icon (SVG path)
    - Repeater for features (list items)
  - Special Features Section:
    - Title
    - Description
    - 4 feature items (icon, title, subtitle)
    - CTA button (text, link)
  - Sort order
  - Active toggle
- **Section Key**: `academic_programs`
- **Section Type**: `programs`

---

## 🗄️ Database Schema Updates

### New Section Keys to Add to `HomePageSectionForm.php`:
```php
'achievements' => 'Achievements Section',
'stats_main' => 'Stats Section',
'parallax_experience' => 'Parallax Experience Section',
'competitions' => 'Competitions Section', // Update existing
'academic_programs' => 'Academic Programs Section',
```

### New Section Types to Add:
```php
'achievements' => 'Achievements Section',
'stats' => 'Stats Section',
'parallax' => 'Parallax Section',
'competitions' => 'Competitions Section',
'programs' => 'Programs Section',
```

---

## 📝 Implementation Plan

### Phase 1: Update Existing Admin Pages
1. **Fix CompetitionSection.php**
   - Change `section_key` from `'video_2'` to `'competitions'`
   - Change `section_type` from `'video'` to `'competitions'`
   - Update form schema to match component structure

2. **Update HomePageSectionForm.php**
   - Add new section keys to options
   - Add new section types to options
   - Update type mapping logic

### Phase 2: Create New Admin Pages
1. **AchievementsSection.php**
   - Create new Filament page
   - Implement repeater for achievements
   - Add icon selector/input
   - Create view file

2. **StatsSection.php**
   - Create new Filament page
   - Implement repeater for stats
   - Add CTA section fields
   - Create view file

3. **ParallaxSection.php**
   - Create new Filament page
   - Add background image upload
   - Implement repeater for feature pills
   - Create view file

4. **ProgramsSection.php**
   - Create new Filament page
   - Implement nested repeater (programs → features)
   - Add special features section
   - Create view file

### Phase 3: Update Components to Read from Database
1. **achievements-section.blade.php**
   - Replace hardcoded array with database query
   - Use `HomePageSection::where('section_key', 'achievements')->first()`

2. **stats-section.blade.php**
   - Replace hardcoded array with database query
   - Read stats and CTA from `data` JSON

3. **parallax-section.blade.php**
   - Replace hardcoded content with database query
   - Use background image from media library

4. **programs-section.blade.php**
   - Replace hardcoded programs with database query
   - Read programs and special features from `data` JSON

5. **competitions-section.blade.php**
   - Update to read from database (currently may be hardcoded)

6. **news-events-section.blade.php**
   - Update to use `$upcomingEvents` from controller OR create featured events admin

### Phase 4: Update HomeController
- Ensure all new sections are passed to view
- Add fallback data for each section
- Update cache key if needed

---

## 🎨 Admin UI Structure

### Navigation Group: "Homepage Settings"
All pages should be in this group with appropriate sort orders:

1. Hero Slider Manager (existing)
2. Stat Highlights (existing)
3. Vision & Mission (existing)
4. Achievements Section (NEW - sort: 4)
5. Stats Section (NEW - sort: 5)
6. News/Events Section (UPDATE - sort: 6)
7. Parallax Section (NEW - sort: 7)
8. Competitions Section (UPDATE - sort: 8)
9. Programs Section (NEW - sort: 9)
10. Advisors Section (existing)

---

## 📦 Data Structure Examples

### Achievements Section Data:
```json
{
  "title": "Recognising Our Learners",
  "subtitle": "Highlights",
  "description": "From Qur'an recitation championships to Cambridge distinctions...",
  "achievements": [
    {
      "title": "Cambridge Top Achievers",
      "copy": "Multiple \"Top in Bangladesh\" awards...",
      "badge": "IGCSE",
      "icon": "M9 12l2 2 4-4M7.835 4.697a3.42..."
    }
  ]
}
```

### Stats Section Data:
```json
{
  "title": "Our School in Numbers",
  "subtitle": "Impact",
  "description": "A snapshot of growth...",
  "stats": [
    {
      "label": "Students",
      "value": "1200+",
      "copy": "Across Early Years to A-Level",
      "icon": "M13 6a3 3 0 11-6 0..."
    }
  ],
  "cta": {
    "title": "Join a community grounded in faith...",
    "button1": {"text": "Schedule a Visit", "link": "#visit"},
    "button2": {"text": "Talk to Admissions", "link": "#contact"}
  }
}
```

### Programs Section Data:
```json
{
  "title": "Our Academic Programs",
  "subtitle": "Academic Excellence",
  "description": "Comprehensive educational pathways...",
  "programs": [
    {
      "title": "Early Years",
      "grade_range": "Kindergarten - Grade 2",
      "description": "Foundation learning through play-based activities...",
      "icon_bg_color": "#6EC1F5",
      "icon": "M10.394 2.08a1 1 0 00-.788 0l-7 3...",
      "features": [
        "Play-based Learning",
        "Basic Quran & Arabic",
        "Creative Arts & Music"
      ]
    }
  ],
  "special_features": {
    "title": "Beyond Traditional Education",
    "description": "Our holistic approach ensures...",
    "features": [
      {"icon": "...", "title": "Smart Classes", "subtitle": "Digital Learning"}
    ],
    "cta": {"text": "Schedule a Visit", "link": "#contact"}
  }
}
```

---

## ✅ Success Criteria

1. ✅ All 9 homepage sections have admin management
2. ✅ No hardcoded data in components (except fallbacks)
3. ✅ All sections can be enabled/disabled
4. ✅ All sections have sort order control
5. ✅ Media uploads work (images, videos)
6. ✅ Repeaters work correctly for multi-item sections
7. ✅ Components gracefully handle missing data
8. ✅ Navigation is organized and intuitive

---

## 🚀 Next Steps

1. Review and approve this plan
2. Create new Filament pages for missing sections
3. Update existing pages that need fixes
4. Update components to read from database
5. Test all admin interfaces
6. Test homepage rendering with admin data
7. Add fallback data for all sections

---

## 📌 Notes

- All new pages should use `ManagesHomePageSection` trait
- All pages should follow existing patterns
- Use Filament Repeaters for multi-item data
- Use Spatie Media Library for image uploads
- Store complex data in `data` JSON field
- Components should have fallback data if section not found

