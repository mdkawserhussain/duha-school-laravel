# Parallax Section Background Image - Issue Summary

## Executive Summary

**Status**: ✅ **IMAGE IS PROPERLY CONFIGURED**  
**Issue**: URL hostname mismatch due to APP_URL configuration  
**Severity**: Low (cosmetic, easy fix)  
**Impact**: Background image may not display depending on access method

## Quick Diagnosis

### What's Working ✅
- Image file exists in storage
- Image is uploaded and stored correctly
- Database configuration is correct
- Media library is functioning properly
- Storage symlink is active
- File permissions are correct
- Component logic is working
- Debug logging is comprehensive

### What's Not Working ❌
- Image URL uses `http://localhost` hostname
- Won't display if accessing site via different URL
- Hardcoded hostname in generated URLs

## Root Cause

**APP_URL Configuration Mismatch**

```
Configured: APP_URL=http://localhost
Generated URL: http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg

Problem: If you access the site via:
- http://127.0.0.1 → Image won't load
- http://192.168.1.100 → Image won't load  
- http://yourdomain.com → Image won't load
- http://localhost:8000 → Image won't load

Only works when accessing via: http://localhost
```

## Evidence

### Database Check ✅
```
Section ID: 15
Section Key: parallax_experience
Is Active: YES
Has Media: YES
Media ID: 7
File Name: 01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
File Size: 36,284 bytes
File Exists: YES
```

### File System Check ✅
```
Path: storage/app/public/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Symlink: public/storage → storage/app/public
Accessible: YES
Permissions: OK
```

### URL Generation ⚠️
```
Generated: http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Source: background_image_collection
Valid URL: YES
Hostname: localhost (HARDCODED)
```

### Debug Logs ✅
```
Section found: YES (ID: 15)
Section is_active: YES
hasMedia("background_image"): YES
getFirstMedia("background_image"): SUCCESS (ID: 7)
Media getUrl(): http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
Image source: background_image_collection
```

## Solution

### Recommended: Update APP_URL

**Step 1**: Determine your access method
```bash
# How do you access the website?
# - http://localhost
# - http://127.0.0.1
# - http://192.168.1.100
# - http://yourdomain.com
# - http://localhost:8000
```

**Step 2**: Update `.env` file
```env
# Change this line to match your access method
APP_URL=http://YOUR_ACTUAL_URL
```

**Step 3**: Clear caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Step 4**: Test
- Visit your website
- Check if parallax background image displays
- Open browser console (F12) to see debug info

### Alternative Solutions

#### Option 1: Use Automated Fix Script
```bash
./fix-parallax-image.sh
```

This script will:
- Check current configuration
- Verify image exists
- Prompt to update APP_URL
- Clear caches automatically
- Provide testing instructions

#### Option 2: Use Default Image Temporarily
1. Login to Admin Dashboard
2. Go to: Homepage Settings → Parallax Experience
3. Toggle "Use Default Image" to ON
4. Save changes

This uses the default SVG at `public/images/parallax-students.svg`

#### Option 3: Modify Component (Advanced)
Edit `resources/views/components/homepage/parallax-section.blade.php` to use relative URLs:

```php
// After getting media URL, convert to relative
if ($backgroundImage && str_contains($backgroundImage, 'localhost')) {
    $backgroundImage = preg_replace('#^https?://[^/]+#', '', $backgroundImage);
    $backgroundImage = url($backgroundImage);
}
```

## Testing Procedure

### 1. Visual Test
1. Visit homepage
2. Scroll to parallax section
3. Check if background image is visible
4. Image should cover the section with parallax effect

### 2. Browser Console Test
1. Open DevTools (F12)
2. Go to Console tab
3. Look for "🔍 Parallax Section Debug"
4. Check if image loaded successfully
5. Should see: "✅ Background image loaded successfully"

### 3. Network Tab Test
1. Open DevTools (F12)
2. Go to Network tab
3. Filter by "Img"
4. Reload page
5. Look for parallax image request
6. Should return: 200 OK (not 404)

### 4. Debug Panel Test
If `APP_DEBUG=true` in `.env`:
- Look for debug panel in bottom-right corner
- Shows: Image Source, URL, Use Default, Section Active, Has Media
- All should show correct values

### 5. Direct URL Test
Copy the image URL from debug info and paste in browser:
```
http://localhost/storage/7/01KA4CE9ZG2HG3PAZNC2VMCH47.jpeg
```
Should display the image directly.

## Verification Commands

### Check Section Status
```bash
php artisan tinker --execute="
\$section = App\Models\HomePageSection::where('section_key', 'parallax_experience')->first();
echo 'Active: ' . (\$section->is_active ? 'YES' : 'NO') . PHP_EOL;
echo 'Has Media: ' . (\$section->hasMedia('background_image') ? 'YES' : 'NO') . PHP_EOL;
"
```

### Check Image URL
```bash
php artisan tinker --execute="
\$section = App\Models\HomePageSection::where('section_key', 'parallax_experience')->first();
if (\$section && \$section->hasMedia('background_image')) {
    echo \$section->getFirstMediaUrl('background_image') . PHP_EOL;
}
"
```

### Check File Exists
```bash
ls -lh storage/app/public/7/*.jpeg
```

### Check Symlink
```bash
ls -la public/storage
```

## Common Scenarios

### Scenario 1: Local Development
```env
APP_URL=http://localhost
```
Access via: `http://localhost` → ✅ Works

### Scenario 2: Local Development with Port
```env
APP_URL=http://localhost:8000
```
Access via: `http://localhost:8000` → ✅ Works

### Scenario 3: Local Network
```env
APP_URL=http://192.168.1.100
```
Access via: `http://192.168.1.100` → ✅ Works

### Scenario 4: Production
```env
APP_URL=https://duhainternationalschool.com
```
Access via: `https://duhainternationalschool.com` → ✅ Works

## Troubleshooting

### Issue: Image still doesn't show after updating APP_URL

**Check 1**: Did you clear caches?
```bash
php artisan config:clear
php artisan cache:clear
```

**Check 2**: Did you restart the server?
```bash
# If using artisan serve
Ctrl+C to stop, then:
php artisan serve
```

**Check 3**: Did you hard refresh the browser?
```
Ctrl+Shift+R (Windows/Linux)
Cmd+Shift+R (Mac)
```

### Issue: Image loads but doesn't display

**Check 1**: CSS background-attachment
On mobile devices, `background-attachment: fixed` may not work. The component already handles this.

**Check 2**: Image dimensions
Check if image is too small or too large. Current image is 36KB which is fine.

**Check 3**: Browser compatibility
Test in different browsers (Chrome, Firefox, Safari).

### Issue: 404 error for image

**Check 1**: Storage symlink
```bash
php artisan storage:link
```

**Check 2**: File permissions
```bash
chmod -R 775 storage/
chmod -R 775 public/storage/
```

**Check 3**: File actually exists
```bash
ls -la storage/app/public/7/
```

## Prevention

To avoid this issue in the future:

1. **Set APP_URL correctly from the start**
   - Use environment-specific values
   - Update when deploying to different environments

2. **Use environment variables**
   ```env
   # .env.local
   APP_URL=http://localhost
   
   # .env.production
   APP_URL=https://yourdomain.com
   ```

3. **Test in multiple environments**
   - Local development
   - Staging server
   - Production server

4. **Document the correct APP_URL**
   - Add to README
   - Include in deployment docs

## Files Involved

### Component
- `resources/views/components/homepage/parallax-section.blade.php`
  - Handles image loading and display
  - Includes extensive debug logging
  - Falls back to default image if needed

### Admin Page
- `app/Filament/Pages/ParallaxSection.php`
  - Manages parallax section in admin
  - Handles image uploads

### Model
- `app/Models/HomePageSection.php`
  - Stores section data
  - Manages media attachments

### Configuration
- `.env` - APP_URL setting
- `config/app.php` - Application URL
- `config/media-library.php` - Media library settings

## Conclusion

The parallax section background image is **fully functional and properly configured**. The only issue is the APP_URL configuration not matching the access method. This is a simple configuration issue, not a code bug.

**Recommended Action**: Update APP_URL in `.env` to match how you access the website, then clear caches.

**Time to Fix**: < 2 minutes

**Difficulty**: Easy (configuration change only)

**Risk**: None (can be reverted easily)

## Support

If you need further assistance:

1. Run the diagnostic script: `./fix-parallax-image.sh`
2. Check Laravel logs: `tail -f storage/logs/laravel.log`
3. Check browser console for specific errors
4. Verify APP_URL matches your access method
5. Ensure all caches are cleared

## Documentation

- Full diagnosis: `PARALLAX_BACKGROUND_IMAGE_DIAGNOSIS.md`
- Fix script: `fix-parallax-image.sh`
- This summary: `PARALLAX_IMAGE_ISSUE_SUMMARY.md`
