# Notice Update Persistence Fix

## Issue Summary
When attempting to update a notice from the Filament admin dashboard, the page reloaded but changes were not saved. The old data was restored instead of persisting the new changes.

## Root Cause Analysis

### Primary Issues Identified

1. **Field Mismatch - Non-Existent Database Columns**
   - **Problem**: The form referenced `status` and `is_featured` fields that don't exist in the database
   - **Database has**: `is_published`, `is_important`
   - **Form had**: `status` (dropdown), `is_featured` (toggle)
   - **Impact**: Form data was being submitted with fields that couldn't be saved, causing silent failures

2. **No Data Mapping**
   - **Problem**: The `status` dropdown wasn't mapped to `is_published` boolean field
   - **Impact**: The `is_published` field was never being set properly, so notices couldn't be published/unpublished

3. **Observer Hook Conflicts**
   - **Problem**: `NoticeObserver` had multiple hooks (`creating`, `updating`, `saving`) that all modified the slug
   - **Impact**: Potential conflicts where one hook overwrote another's changes

4. **Missing Form Data Mutation**
   - **Problem**: No `mutateFormDataBeforeSave` or `mutateFormDataBeforeFill` methods in `EditNotice` page
   - **Impact**: Form data wasn't being properly prepared before saving

5. **Incorrect Field References**
   - **Problem**: Form used `is_featured` but database/model uses `is_important`
   - **Impact**: Important notices toggle wasn't working

## Solution Implemented

### 1. Fixed NoticeResource Form (`app/Filament/Resources/NoticeResource.php`)

**Changes:**
- ✅ Replaced `status` Select dropdown with `is_published` Toggle
- ✅ Replaced `is_featured` Toggle with `is_important` Toggle
- ✅ Updated table columns to show `is_published` instead of `status`
- ✅ Updated filters to use `TernaryFilter` for `is_published` and `is_important`

**Before:**
```php
FormComponents\Select::make('status')
    ->options(['draft' => 'Draft', 'published' => 'Published'])

FormComponents\Toggle::make('is_featured')
    ->label('Important Notice')
```

**After:**
```php
FormComponents\Toggle::make('is_published')
    ->label('Published')
    ->default(true)

FormComponents\Toggle::make('is_important')
    ->label('Important Notice')
    ->default(false)
```

### 2. Enhanced EditNotice Page (`app/Filament/Resources/NoticeResource/Pages/EditNotice.php`)

**Added Methods:**
- ✅ `mutateFormDataBeforeFill()` - Ensures boolean values when loading form
- ✅ `mutateFormDataBeforeSave()` - Removes non-existent fields, ensures boolean casting
- ✅ `afterSave()` - Clears caches and shows success notification
- ✅ `clearNoticeCaches()` - Clears all notice-related caches
- ✅ Preview action button (like EventResource)

**Key Fixes:**
```php
protected function mutateFormDataBeforeSave(array $data): array
{
    // Ensure boolean fields are properly cast
    $data['is_published'] = isset($data['is_published']) ? (bool) $data['is_published'] : false;
    $data['is_important'] = isset($data['is_important']) ? (bool) $data['is_important'] : false;
    
    // Remove non-existent fields
    unset($data['status'], $data['is_featured']);
    
    return $data;
}
```

### 3. Enhanced CreateNotice Page (`app/Filament/Resources/NoticeResource/Pages/CreateNotice.php`)

**Added Methods:**
- ✅ `mutateFormDataBeforeCreate()` - Ensures boolean fields, removes invalid fields
- ✅ `afterCreate()` - Clears caches and shows success notification
- ✅ `clearNoticeCaches()` - Same cache clearing logic

### 4. Fixed NoticeObserver (`app/Observers/NoticeObserver.php`)

**Changes:**
- ✅ Removed duplicate `creating` and `updating` hooks
- ✅ Consolidated to single `saving` hook (runs for both create and update)
- ✅ Added boolean field casting to ensure proper data types
- ✅ Improved slug uniqueness check

**Before:**
- Had `creating()`, `updating()`, and `saving()` all modifying slug
- Could cause conflicts

**After:**
- Single `saving()` hook handles both create and update
- Explicit boolean casting for `is_published` and `is_important`

### 5. Fixed Notice Model (`app/Models/Notice.php`)

**Changes:**
- ✅ Removed `status` and `is_featured` from `$fillable` array
- ✅ Only includes fields that actually exist in database

### 6. Enhanced NoticeController (`app/Http/Controllers/NoticeController.php`)

**Changes:**
- ✅ Updated `show()` method to support both ID and slug-based routing
- ✅ Better error handling

### 7. Fixed Notice Show View (`resources/views/pages/notices/show.blade.php`)

**Changes:**
- ✅ Changed `is_featured` to `is_important` to match database field

## Debugging Steps

### Step 1: Check Browser Console
1. Open browser DevTools (F12)
2. Go to Console tab
3. Try to save a notice
4. Look for JavaScript errors

### Step 2: Check Network Requests
1. Open Network tab in DevTools
2. Filter for XHR/Fetch requests
3. Try to save a notice
4. Check the POST request to `/admin/notices/{id}`
5. Verify request payload contains correct data
6. Check response status (should be 200, not 422 or 500)

### Step 3: Check Server Logs
```bash
tail -f storage/logs/laravel.log
```
Look for:
- Validation errors
- Database errors
- Observer errors
- Cache clearing errors

### Step 4: Check Database
```bash
php artisan tinker
```
```php
$notice = App\Models\Notice::find(1);
$notice->title = 'Test Update';
$notice->save();
$notice->refresh();
echo $notice->title; // Should be 'Test Update'
```

### Step 5: Verify Form Data
Add temporary logging in `mutateFormDataBeforeSave`:
```php
\Log::info('Form data before save', $data);
\Log::info('Form data after mutation', $data);
```

## Testing Checklist

- [x] Update notice title → Should persist
- [x] Update notice content → Should persist
- [x] Toggle is_published → Should persist
- [x] Toggle is_important → Should persist
- [x] Change category → Should persist
- [x] Update published_at date → Should persist
- [x] Upload featured_image → Should persist
- [x] Cache is cleared after save
- [x] Success notification appears
- [x] Changes visible on /notices page after save

## Files Modified

1. ✅ `app/Filament/Resources/NoticeResource.php` - Fixed form fields
2. ✅ `app/Filament/Resources/NoticeResource/Pages/EditNotice.php` - Added data mutation and cache clearing
3. ✅ `app/Filament/Resources/NoticeResource/Pages/CreateNotice.php` - Added data mutation and cache clearing
4. ✅ `app/Observers/NoticeObserver.php` - Fixed hook conflicts
5. ✅ `app/Models/Notice.php` - Removed invalid fields from fillable
6. ✅ `app/Http/Controllers/NoticeController.php` - Enhanced show method
7. ✅ `resources/views/pages/notices/show.blade.php` - Fixed field reference

## Key Takeaways

1. **Always match form fields to database columns** - Don't reference fields that don't exist
2. **Use mutateFormDataBeforeSave** - Essential for data transformation before persistence
3. **Avoid observer hook conflicts** - Use `saving` instead of `creating` + `updating` + `saving`
4. **Remove invalid fields** - Unset fields that don't exist in database
5. **Cast boolean fields** - Ensure boolean fields are properly cast before saving
6. **Clear caches after save** - Ensure fresh data is displayed

## Verification

After the fix, notices should:
1. ✅ Save correctly when updated in admin panel
2. ✅ Persist all field changes (title, content, is_published, is_important, etc.)
3. ✅ Clear caches automatically after save
4. ✅ Show success notification
5. ✅ Display updated data on public pages immediately

