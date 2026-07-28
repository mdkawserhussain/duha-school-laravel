# Hero Section Admin Management Update

## 📋 Summary

The hero section has been updated to be fully manageable through the admin dashboard. Previously, the hero section component was completely hardcoded and didn't use any database data. Now, all hero section content can be managed dynamically through the Filament admin interface.

---

## ✅ What Was Updated

### 1. **HeroSliderManager.php** - Backend Updates

#### Added New Properties:
- `$videoPoster` - For handling video poster image uploads

#### Updated Methods:

**`loadSlides()`** - Now loads all hero section data:
- `video_url` - Background video URL
- `video_poster` - Video poster image URL
- `secondary_button_text` - Secondary CTA button text
- `secondary_button_link` - Secondary CTA button link
- `features` - Array of feature highlights (icon, title, description)
- `stats_cards` - Array of stats cards (label1, label2, title, description)
- `stats_pills` - Array of stats pills (value, label)

**`editSlide()`** - Now includes all new fields when editing

**`saveSlide()`** - Now saves all new fields to the `data` JSON field:
- Secondary CTA buttons
- Video URL and poster
- Feature highlights
- Stats cards
- Stats pills

**`addNewSlide()`** - Initializes default empty arrays for repeaters

**`previewSlide()`** - Includes all new fields in preview

### 2. **hero-section.blade.php** - Component Updates

#### Changed from Hardcoded to Dynamic:
- ✅ Badge text - Now reads from `$heroData['badge']`
- ✅ Main headline - Combines `title` + `subtitle` from database
- ✅ Description - Reads from `$heroSlide->description`
- ✅ Primary CTA - Reads from `button_text` and `button_link`
- ✅ Secondary CTA - Reads from `$heroData['secondary_button_text']` and `secondary_button_link`
- ✅ Background video - Reads from `$heroData['video_url']`
- ✅ Video poster - Reads from media library `video_poster` collection
- ✅ Feature highlights - Loops through `$heroData['features']` array
- ✅ Stats cards - Loops through `$heroData['stats_cards']` array
- ✅ Stats pills - Loops through `$heroData['stats_pills']` array

#### Fallback Data:
All fields have fallback values matching the original hardcoded content, so the section will display correctly even if no data is configured in the admin.

### 3. **hero-slider-manager.blade.php** - Admin Form Updates

#### New Form Sections Added:

1. **Secondary CTA Section**
   - Secondary Button Text
   - Secondary Button Link

2. **Background Video Section**
   - Video URL input
   - Video Poster Image upload (with preview)

3. **Feature Highlights Section**
   - Repeater for managing 2+ feature items
   - Each feature has: Icon SVG Path, Title, Description
   - Add/Remove buttons

4. **Stats Cards Section**
   - Repeater for managing 2+ stats cards
   - Each card has: Label 1, Label 2, Title, Description
   - Add/Remove buttons

5. **Stats Pills Section**
   - Repeater for managing 3+ stats pills
   - Each pill has: Value, Label
   - Add/Remove buttons

#### Alpine.js Integration:
- Created separate Alpine.js data components for each repeater:
  - `featureRepeater()` - Manages feature highlights
  - `statsCardsRepeater()` - Manages stats cards
  - `statsPillsRepeater()` - Manages stats pills
- All repeaters sync with Livewire automatically
- Deep watching enabled for nested array changes

### 4. **HomePageSection Model** - Media Collections

#### Added New Media Collection:
- `video_poster` - Single file collection for video poster images

---

## 📊 Data Structure

### Hero Slide Data Structure:
```json
{
  "badge": "Since 2010 • Chattogram",
  "video_url": "https://example.com/video.mp4",
  "secondary_button_text": "Virtual Tour",
  "secondary_button_link": "#virtual-tour",
  "features": [
    {
      "icon": "M10.394 2.08a1...",
      "title": "Cambridge & Hifz Streams",
      "description": "Balanced academics with authentic Islamic scholarship."
    }
  ],
  "stats_cards": [
    {
      "label1": "Lower Campus",
      "label2": "Morning Shift",
      "title": "Early Years • Primary",
      "description": "Cambridge Primary with Qur'an & Arabic immersion."
    }
  ],
  "stats_pills": [
    {
      "value": "1200+",
      "label": "Students"
    }
  ]
}
```

---

## 🎯 How to Use

### In Admin Dashboard:

1. **Navigate to**: Homepage Settings → Hero Slider

2. **Add/Edit a Slide**:
   - Click "Add New Slide" or edit an existing slide
   - Fill in basic fields: Title, Subtitle, Description, Badge
   - Add Primary CTA: Button Text and Link
   - Add Secondary CTA: Secondary Button Text and Link
   - Upload Background Video: Enter video URL and upload poster image
   - Add Feature Highlights: Click "+ Add Feature" to add feature items
   - Add Stats Cards: Click "+ Add Card" to add campus info cards
   - Add Stats Pills: Click "+ Add Stat" to add stat numbers
   - Upload slide image (optional)
   - Toggle Active status
   - Click "Save Slide"

3. **Manage Multiple Slides**:
   - Drag and drop to reorder slides
   - Only the first active slide is displayed on homepage
   - Toggle active/inactive status
   - Duplicate or delete slides

---

## 🔄 Component Behavior

### Data Flow:
1. **HomeController** loads all hero slides from database
2. **hero-section.blade.php** uses the **first active slide** from `$heroSlides`
3. Component reads all data from slide's `data` JSON field
4. Falls back to hardcoded defaults if data not found

### Conditional Display:
- Section only displays if `$heroSlide` exists and `is_active = true`
- Each subsection (features, stats cards, pills) only displays if array has items
- Buttons only display if text and link are provided

---

## ✨ Key Features

1. **Full CMS Control**: All hero content manageable through admin
2. **Multiple Slides Support**: Can create multiple hero slides, first active one displays
3. **Repeaters**: Easy add/remove for features, stats cards, and pills
4. **Media Management**: Video poster images handled via Spatie Media Library
5. **Live Preview**: See changes in real-time while editing
6. **Fallback Data**: Graceful degradation if admin data not configured
7. **Drag & Drop**: Reorder slides easily
8. **Active/Inactive**: Toggle slides on/off without deleting

---

## 🎨 Admin Form Layout

The form is organized into clear sections:
1. **Basic Information**: Title, Subtitle, Description, Badge
2. **Primary CTA**: Button Text and Link
3. **Secondary CTA**: Secondary Button Text and Link
4. **Background Video**: Video URL and Poster Image
5. **Feature Highlights**: Repeater for 2+ features
6. **Stats Cards**: Repeater for 2+ cards
7. **Stats Pills**: Repeater for 3+ pills
8. **Settings**: Active toggle

---

## 📝 Notes

- The hero section uses the **first active slide** from the database
- All additional data (except basic fields) is stored in the `data` JSON field
- Video poster images are stored in the `video_poster` media collection
- Slide images are stored in the `images` media collection
- Alpine.js repeaters automatically sync with Livewire
- All fields are optional - section will work with partial data

---

## ✅ Testing Checklist

- [ ] Create a new hero slide with all fields
- [ ] Edit an existing slide
- [ ] Add/remove features, stats cards, and pills
- [ ] Upload video poster image
- [ ] Test with missing data (should show fallbacks)
- [ ] Toggle active/inactive status
- [ ] Reorder slides
- [ ] Verify homepage displays correctly

---

## 🚀 Next Steps

1. Access admin dashboard
2. Go to "Homepage Settings" → "Hero Slider"
3. Create or edit a hero slide
4. Configure all fields as needed
5. Save and view homepage

The hero section is now fully dynamic and manageable through the admin interface!

