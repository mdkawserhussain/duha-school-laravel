# Image Upload Fix - Vision & Mission Section

## Problem Identified

The Vision & Mission section was not displaying uploaded images on the frontend, even though uploads appeared successful in the admin panel.

## Root Cause

The issue was caused by a **field name mismatch** between the form and the image processing logic:

1. **Form Field Name**: `campus_image` (in VisionMissionSection.php)
2. **Expected Field Name**: `image` (in ManagesHomePageSection trait)

The parent trait's `save()` method was looking for `$formState['image']`, but the form was using `$formState['campus_image']`, so the image upload logic was never triggered.

## Solution Implemented

### 1. Overrode the `save()` Method
Created a custom `save()` method in `VisionMissionSection.php` that:
- Properly handles the `campus_image` field
- Processes image uploads to the media library
- Saves all other form data correctly
- Clears cache after saving

### 2. Enhanced the `mount()` Method
Updated the `mount()` method to:
- Load existing images when editing
- Display the current campus image in the form
- Properly initialize all form fields

### 3. Added Image Processing Logic
Implemented `processImageUpload()` method that:
- Handles Livewire temporary files
- Supports multiple file path formats
- Tries multiple storage locations
- Logs errors for debugging
- Adds images to the 'images' media collection

## Files Modified

### app/Filament/Pages/VisionMissionSection.php
- Added custom `mount()` method to load existing images
- Added custom `save()` method to handle campus_image field
- Added `processImageUpload()` method for robust file handling
- Excluded `campus_image` from JSON data storage

### No Changes Required
- `resources/views/components/homepage/vision-section.blade.php` - Already correctly configured
- Database structure - Already supports media library
- HomePageSection model - Already has media library traits

## How It Works Now

### Upload Flow
```
1. Admin uploads image via "Campus Image" field
   ↓
2. Filament stores temporary file in livewire-tmp/
   ↓
3. Form submits with campus_image field
   ↓
4. Custom save() method captures campus_image data
   ↓
5. processImageUpload() adds file to media library
   ↓
6. Image stored in 'images' collection
   ↓
7. Cache cleared automatically
```

### Display Flow
```
1. Frontend loads vision section
   ↓
2. Checks if section has media in 'images' collection
   ↓
3. If yes: Uses getFirstMediaUrl('images')
   ↓
4. If no: Falls back to default asset('images/vision-campus.svg')
   ↓
5. Image displayed in campus section
```

## Testing Checklist

### Before Fix
- [x] Text changes worked ✅
- [x] Image uploads appeared successful in admin ✅
- [ ] Images displayed on frontend ❌

### After Fix
- [ ] Text changes still work
- [ ] Image uploads work in admin
- [ ] Uploaded images display on frontend
- [ ] Existing images load in form when editing
- [ ] Default image shows when no upload
- [ ] Cache clears after save
- [ ] No errors in Laravel logs

## Manual Testing Steps

1. **Test Image Upload**
   ```
   - Login to admin dashboard
   - Go to Homepage Settings > Vision & Mission
   - Scroll to "Campus Image Section"
   - Click "Campus Image" upload field
   - Select an image (JPEG, PNG, WebP, or SVG)
   - Click "Save Changes"
   - Visit homepage
   - Verify image appears in Vision & Mission section
   ```

2. **Test Image Replacement**
   ```
   - Return to admin panel
   - Upload a different image
   - Save changes
   - Verify new image replaces old one on frontend
   ```

3. **Test Image Removal**
   ```
   - Remove the uploaded image in admin
   - Save changes
   - Verify default image appears on frontend
   ```

4. **Test Form Loading**
   ```
   - Upload an image and save
   - Navigate away from the page
   - Return to Vision & Mission page
   - Verify uploaded image shows in form
   ```

## Verification Commands

### Check if image is attached to section
```bash
php artisan tinker --execute="
\$section = App\Models\HomePageSection::where('section_key', 'vision')->first();
echo 'Has media: ' . (\$section->hasMedia('images') ? 'YES' : 'NO') . PHP_EOL;
echo 'Media URL: ' . (\$section->getFirstMediaUrl('images') ?: 'None') . PHP_EOL;
"
```

### Check media table
```bash
php artisan tinker --execute="
\$media = DB::table('media')
    ->where('model_type', 'App\\\Models\\\HomePageSection')
    ->where('collection_name', 'images')
    ->get();
echo 'Media count: ' . \$media->count() . PHP_EOL;
foreach (\$media as \$m) {
    echo 'File: ' . \$m->file_name . ' | Model ID: ' . \$m->model_id . PHP_EOL;
}
"
```

### Clear all caches
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

## Technical Details

### Media Collection
- **Collection Name**: `images`
- **Storage Disk**: `public`
- **Directory**: `vision-section/`
- **Conversions**: thumb (300x300), medium (600x400), large (1920x1080)
- **Format**: WebP for conversions

### File Upload Settings
- **Max Size**: 5MB (5120 KB)
- **Accepted Types**: JPEG, PNG, WebP, SVG
- **Image Editor**: Enabled
- **Visibility**: Public
- **Dehydrated**: False (handled separately)

### Storage Paths Checked
The `processImageUpload()` method checks these paths in order:
1. `storage/app/public/{imagePath}`
2. `storage/app/public/vision-section/{basename}`
3. `storage/app/{imagePath}`
4. `public/storage/{imagePath}`
5. Direct path
6. Storage disk lookup

## Error Handling

### Logging
All image upload errors are logged to `storage/logs/laravel.log` with:
- Error message
- File path attempted
- Exception details

### Fallback Behavior
- If upload fails: Error logged, but save continues
- If no image: Default SVG displayed
- If image deleted: Reverts to default

## Known Limitations

1. **Single Image Only**: Only one campus image supported (by design)
2. **No Bulk Upload**: Must upload one image at a time
3. **Manual Cache Clear**: If changes don't appear, may need manual cache clear

## Future Enhancements

- [ ] Add image preview in admin before upload
- [ ] Support multiple campus images (gallery)
- [ ] Add image optimization settings
- [ ] Implement automatic cache clearing on media changes
- [ ] Add image alt text field for accessibility

## Support

If images still don't display after this fix:

1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Verify storage link: `php artisan storage:link`
3. Check file permissions: `chmod -R 775 storage/`
4. Clear all caches: See verification commands above
5. Check media table: See verification commands above

## Rollback

If this fix causes issues, revert to using the trait's default behavior:

1. Remove custom `save()` and `processImageUpload()` methods
2. Change field name from `campus_image` to `image`
3. Update mount method to use `image` instead of `campus_image`
