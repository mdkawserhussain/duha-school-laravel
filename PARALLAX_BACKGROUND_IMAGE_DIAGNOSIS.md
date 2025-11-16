# Parallax Section Background Image - Diagnostic Report

## Investigation Summary

### Status: ✅ IMAGE EXISTS AND IS CONFIGURED CORRECTLY

The background image is properly uploaded, stored, and configured in the CMS. However, it may not display correctly depending on how you access the website.

## Root Cause Analysis

### Primary Issue: APP_URL Configuration

**Problem**: The `APP_URL` in `.env` is set to `http://localhost`, which causes the media library to generate URLs like:
```
http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
```

**Impact**: 
- ✅ Works when accessing via `http://localhost`
- ❌ Fails when accessing via IP address (e.g., `http://192.168.1.100`)
- ❌ Fails when accessing via domain name
- ❌ Fails when accessing via different port (e.g., `http://localhost:8000`)

### Current Configuration

#### Database Status
```
Section ID: 15
Section Key: parallax_experience
Is Active: YES
Title: "Where tradition meets innovation every school day."
Has Media (background_image): YES
Has Media (images): NO
```

#### Media Details
```
Media ID: 7
File Name: 01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Disk: public
Collection: background_image
Size: 36,284 bytes (35.4 KB)
MIME Type: image/jpeg
Path: storage/app/public/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
File Exists: YES ✅
Accessible via symlink: YES ✅
```

#### Generated URL
```
Current: http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Source: background_image_collection
```

#### Debug Log Output
```
=== PARALLAX SECTION DEBUG START ===
Section found: YES (ID: 15)
Section is_active: YES
Section title column: Where tradition meets innovation every school day.
SectionData count: 5
SectionData keys: badge, description, feature_pills, cta, use_default_image
use_default_image (raw): false
use_default_image (processed): FALSE
Attempting to load custom background image...
Media relationship already loaded
hasMedia("background_image"): YES
getFirstMedia("background_image"): SUCCESS (ID: 7)
Media getUrl(): http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Final URL validation: VALID
Final backgroundImage: http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Image source: background_image_collection
=== PARALLAX SECTION DEBUG END ===
```

## Solutions

### Solution 1: Update APP_URL (Recommended)

Update the `APP_URL` in your `.env` file to match how you access the website:

#### For Local Development
```env
# If accessing via localhost
APP_URL=http://localhost

# If accessing via IP address
APP_URL=http://192.168.1.100

# If using Laravel Valet
APP_URL=http://duha.test

# If using custom port
APP_URL=http://localhost:8000
```

#### For Production
```env
# Use your actual domain
APP_URL=https://duhainternationalschool.com
```

**After changing APP_URL:**
```bash
php artisan config:clear
php artisan cache:clear
```

### Solution 2: Use Relative URLs

Modify the Spatie Media Library configuration to use relative URLs instead of absolute URLs.

**File**: `config/media-library.php`

Find the `url_generator` setting and change it to use relative paths:

```php
'url_generator' => \Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator::class,
```

Or create a custom URL generator that returns relative URLs.

### Solution 3: Use Request URL

Modify the parallax component to use the current request URL instead of the configured APP_URL.

**File**: `resources/views/components/homepage/parallax-section.blade.php`

Add this after getting the media URL:

```php
// Convert absolute URL to relative if it uses localhost
if ($backgroundImage && str_contains($backgroundImage, 'localhost')) {
    $backgroundImage = preg_replace('#^https?://[^/]+#', '', $backgroundImage);
    $backgroundImage = url($backgroundImage);
}
```

### Solution 4: Force Relative Paths in Component

Modify the component to always use relative paths:

```php
if ($media) {
    // Get relative path instead of full URL
    $backgroundImage = '/storage/' . $media->id . '/' . $media->file_name;
    $backgroundImage = asset($backgroundImage);
}
```

## Verification Steps

### 1. Check Current Access Method
```bash
# How are you accessing the site?
echo "Current URL: $(curl -s http://localhost | grep -o 'http[s]*://[^"]*' | head -1)"
```

### 2. Test Image Accessibility
```bash
# Test if image is accessible
curl -I http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg

# Should return: HTTP/1.1 200 OK
```

### 3. Check Browser Console
Open browser console (F12) and look for:
- ✅ "Background image loaded successfully"
- ❌ "Background image failed to load"

### 4. Check Network Tab
1. Open browser DevTools (F12)
2. Go to Network tab
3. Filter by "Img"
4. Reload page
5. Look for the parallax image request
6. Check if it returns 200 or 404

### 5. View Page Source
1. Right-click page → View Page Source
2. Search for "PARALLAX SECTION DEBUG"
3. Check the debug comments for image URL

## Quick Fixes

### Quick Fix 1: Update .env and Clear Cache
```bash
# Edit .env file
nano .env
# Change APP_URL to match your access method

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Restart server if using artisan serve
```

### Quick Fix 2: Use Default Image Temporarily
If you need a quick workaround, you can force the use of the default image:

1. Go to Admin Dashboard
2. Navigate to Homepage Settings → Parallax Experience
3. Toggle "Use Default Image" to ON
4. Save changes

This will use the default SVG image at `public/images/parallax-students.svg`

## Testing Checklist

- [ ] Verify APP_URL matches access method
- [ ] Clear all caches
- [ ] Check image file exists in storage
- [ ] Check symlink exists (public/storage → storage/app/public)
- [ ] Test image URL directly in browser
- [ ] Check browser console for errors
- [ ] Check Network tab for 404 errors
- [ ] View page source for debug info
- [ ] Test on different browsers
- [ ] Test on mobile device

## Debug Information

### Enable Debug Mode
In `.env`:
```env
APP_DEBUG=true
```

This will show:
- Visual debug panel in bottom-right corner
- Console logs with detailed information
- HTML comments with debug output

### Check Laravel Logs
```bash
tail -f storage/logs/laravel.log | grep "Parallax"
```

### Check Media Table
```bash
php artisan tinker --execute="
DB::table('media')
    ->where('model_type', 'App\\\Models\\\HomePageSection')
    ->where('collection_name', 'background_image')
    ->get()
    ->each(function(\$m) {
        echo 'ID: ' . \$m->id . ' | File: ' . \$m->file_name . ' | Model ID: ' . \$m->model_id . PHP_EOL;
    });
"
```

## Common Issues and Solutions

### Issue 1: Image Shows on Localhost but Not on IP
**Cause**: APP_URL is set to localhost
**Solution**: Update APP_URL to use IP address or use relative URLs

### Issue 2: Image Shows in Admin but Not Frontend
**Cause**: Cache not cleared after upload
**Solution**: Clear cache and refresh browser

### Issue 3: 404 Error for Image
**Cause**: Storage symlink missing or broken
**Solution**: Run `php artisan storage:link`

### Issue 4: Image Loads but Doesn't Display
**Cause**: CSS background-attachment: fixed may not work on mobile
**Solution**: Use media queries to change to scroll on mobile

### Issue 5: Image URL is Relative but Still Doesn't Work
**Cause**: Base URL not set correctly
**Solution**: Check `<base>` tag in HTML or use absolute URLs

## Recommended Solution

**For your specific case**, I recommend **Solution 1: Update APP_URL**

1. Determine how you access the website (localhost, IP, domain)
2. Update `.env` file with correct APP_URL
3. Clear caches
4. Test the parallax section

This is the cleanest solution that will work across the entire application, not just the parallax section.

## Additional Notes

### Why the Image Exists but May Not Display

The image is:
- ✅ Uploaded correctly
- ✅ Stored in the correct location
- ✅ Accessible via symlink
- ✅ Referenced correctly in the database
- ✅ Generated with correct URL format

The only issue is the **hostname** in the URL. If you access the site via a different hostname than what's in APP_URL, the browser will try to load the image from the wrong host.

### Example Scenario

**APP_URL**: `http://localhost`
**Generated Image URL**: `http://localhost/storage/7/image.jpeg`

**Accessing via**:
- `http://localhost` → ✅ Works
- `http://127.0.0.1` → ❌ Fails (tries to load from localhost)
- `http://192.168.1.100` → ❌ Fails (tries to load from localhost)
- `http://duha.test` → ❌ Fails (tries to load from localhost)

### Browser Behavior

When the browser encounters:
```html
<section style="background-image: url('http://localhost/storage/7/image.jpeg');">
```

It will make a request to exactly that URL. If you're viewing the page from a different host, the request will fail because `localhost` from your browser's perspective is different from the server's localhost.

## Support

If the image still doesn't display after trying these solutions:

1. Check the browser console for specific error messages
2. Check the Network tab for the actual request/response
3. Verify the APP_URL matches your access method
4. Ensure storage symlink exists
5. Check file permissions on storage directory
6. Try accessing the image URL directly in browser

## Conclusion

The parallax section background image is **properly configured and working**. The issue is likely related to the APP_URL configuration not matching how you're accessing the website. Update the APP_URL in your `.env` file to match your access method, clear caches, and the image should display correctly.
