# Logo Upload Fix - Quick Reference

## Problem
Logo uploads in admin site settings were not reflecting on the frontend.

## Root Cause
Helper method was checking accessor before checking media collection, causing it to return placeholder even when logo was uploaded.

## Solution
Updated `SiteSettingsHelper::logoUrl()` to check media collection FIRST.

## Files Changed
✅ `app/Helpers/SiteSettingsHelper.php` - Fixed logoUrl() method

## How to Upload Logo

1. Login to admin dashboard
2. Go to: **Site Settings → Edit**
3. Click **"Branding"** tab
4. Upload logo image (PNG, JPEG, SVG, WebP)
5. Click **"Save"**
6. Visit homepage - logo should display

## If Logo Doesn't Show

```bash
# Clear cache
php artisan cache:clear
php artisan view:clear

# Hard refresh browser
Ctrl+Shift+R (Windows/Linux)
Cmd+Shift+R (Mac)
```

## Verify Logo is Uploaded

```bash
php artisan tinker --execute="
\$settings = App\Models\SiteSettings::current();
echo 'Has logo: ' . (\$settings->hasMedia('logo') ? 'YES' : 'NO') . PHP_EOL;
"
```

## Check Logo URL

```bash
php artisan tinker --execute="
echo App\Helpers\SiteSettingsHelper::logoUrl() . PHP_EOL;
"
```

## Logo Requirements

- **Formats**: PNG, JPEG, JPG, SVG, WebP
- **Max Size**: 2MB
- **Recommended**: 200x200px
- **Location**: Stored in `storage/app/public/site-settings/logos/`

## Status
✅ **FIXED** - Logo uploads now display correctly on frontend

## Documentation
- Full details: `LOGO_UPLOAD_FIX_SUMMARY.md`
- This quick reference: `LOGO_UPLOAD_QUICK_REFERENCE.md`
