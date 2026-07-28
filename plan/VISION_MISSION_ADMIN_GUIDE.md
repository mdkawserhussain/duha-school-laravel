# Vision & Mission Section - Admin Guide

## Overview
The Vision & Mission section is now fully manageable through the Filament admin dashboard under **Homepage Settings > Vision & Mission**. All content can be updated without touching any code.

## Location
Navigate to: **Admin Dashboard → Homepage Settings → Vision & Mission**

## Editable Fields

### 1. Section Badge & Heading
- **Badge Text**: Small text in the badge (e.g., "Our Charter")
- **Heading Line 1**: First line of main heading (e.g., "Empowering Minds,")
- **Heading Line 2**: Second line (highlighted) (e.g., "Enriching Hearts")
- **Section Description**: Brief description below the heading

### 2. Vision Card
- **Vision Title**: Title for the vision card (default: "Vision")
- **Vision Statement**: Your school's vision statement (required)

### 3. Mission Card
- **Mission Title**: Title for the mission card (default: "Mission")
- **Mission Statement**: Your school's mission statement (required)

### 4. Feature Pills
Add feature highlights displayed as pills below the cards:
- Click "Add item" to add new features
- Each feature has a text field (e.g., "Cambridge Primary to A-Level")
- Supports up to 6 features
- Features are displayed with a gold dot indicator

### 5. Campus Image Section
- **Campus Image**: Upload a campus photo (optional, uses default if empty)
  - Supported formats: JPEG, PNG, WebP, SVG
  - Max size: 5MB
  - Includes image editor for cropping
- **Image Overlay Title**: Title displayed on the image (e.g., "Our Campus")
- **Image Overlay Subtitle**: Subtitle on the image (e.g., "Where tradition meets innovation")

### 6. Core Values Card
- **Values Card Title**: Title for the floating card (default: "Core Values")
- **Core Values**: List of core values (1-6 items)
  - Each value is displayed with a gold dot
  - Examples: "Ihsan in every lesson", "Amanah & compassion"

### 7. Section Settings
- **Sort Order**: Controls the order of sections on the homepage
- **Active**: Toggle to show/hide the entire section

## How Changes Appear

All changes are reflected immediately on the homepage after clicking "Save Changes". The section will:
- Only display if the "Active" toggle is ON
- Show all configured content dynamically
- Use default values if fields are left empty
- Hide optional elements (like features or values) if none are added

## Tips

1. **Vision & Mission Statements**: Keep them concise but impactful (max 500 characters each)
2. **Feature Pills**: Use 3-5 features for best visual balance
3. **Core Values**: 3-4 values work best for the floating card
4. **Campus Image**: Use high-quality images with good contrast for text overlay
5. **Headings**: Keep line 1 and line 2 balanced in length for better visual appeal

## Default Content

The seeder has populated default content based on Duha International School. You can modify all fields to match your school's identity.

## Troubleshooting

- **Changes not appearing?**: Clear cache by saving the section again
- **Image not uploading?**: Check file size (max 5MB) and format (JPEG, PNG, WebP, SVG)
- **Section not showing?**: Ensure the "Active" toggle is ON

## Technical Notes

- Data is stored in the `home_page_sections` table with `section_key = 'vision'`
- Images are stored using Spatie Media Library in the `images` collection
- Cache is automatically cleared when saving changes
