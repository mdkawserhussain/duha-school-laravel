# Vision & Mission Section - Islamic Focus Update

## What Was Done

Updated the Vision & Mission section with comprehensive Islamic-focused content that emphasizes:

### Vision
"To be a beacon of Islamic education excellence, cultivating generations of God-conscious learners who embody Taqwa, pursue knowledge with Ihsan, and lead with wisdom, integrity, and compassion to serve humanity and please Allah (SWT)."

### Mission
"To provide holistic Islamic education that seamlessly integrates Cambridge academic excellence with Qur'anic sciences, Arabic mastery, and prophetic character development—preparing students to excel in both Dunya and Akhirah while serving as ambassadors of Islam."

### Islamic Core Values (10 Values)
1. **Tawheed** - Oneness of Allah
2. **Taqwa** - God Consciousness
3. **Ihsan** - Excellence in All
4. **Amanah** - Trust & Responsibility
5. **Adab** - Prophetic Manners
6. **Ilm** - Pursuit of Knowledge
7. **Sabr** - Patience & Perseverance
8. **Shukr** - Gratitude to Allah
9. **Rahmah** - Mercy & Compassion
10. **Khidmah** - Service to Others

### Key Features
- Qur'an & Sunnah Foundation
- Cambridge IGCSE & A-Level
- Hifz, Tajweed & Arabic Excellence
- Islamic Character & Leadership
- Service to Ummah & Humanity

## How to Apply the Update

### Option 1: Using Database Seeder (Recommended)
```bash
php artisan db:seed
```

This will seed all data including the Vision & Mission section. Or run specifically:

```bash
php artisan db:seed --class=VisionMissionSectionSeeder
```

Then clear cache:
```bash
php artisan cache:forget homepage_v2_data
```

### Option 2: Using Artisan Command
```bash
php artisan homepage:update-vision
```

This command will:
- Update the `home_page_sections` table with the new content
- Clear the homepage cache automatically
- Show success confirmation

### Option 3: Using SQL Script (If needed)
If you prefer direct database access:

1. Open your PostgreSQL client
2. Run the SQL file: `database/seeders/insert_vision_mission.sql`
3. Clear cache manually:
```bash
php artisan cache:forget homepage_v2_data
```

## Files Modified

1. **database/seeders/VisionMissionSectionSeeder.php** - Updated with Islamic content
2. **database/seeders/DatabaseSeeder.php** - Added Vision seeder to call list
3. **app/Console/Commands/UpdateVisionMission.php** - New command for easy updates
4. **database/seeders/insert_vision_mission.sql** - SQL script for direct database update

## Homepage Display

The Vision & Mission section is now positioned between:
- **Advisors & Board** section (before)
- **Board Members** section (after)

The section will display:
- Islamic charter badge
- Dual-line heading: "Nurturing Faith, Inspiring Excellence"
- Comprehensive description rooted in Qur'an and Sunnah
- Vision card with star icon
- Mission card with lightning icon
- 5 feature pills highlighting key programs
- Campus image with overlay
- Floating card with 10 Islamic core values

## Admin Panel Management

You can further customize this content via Filament admin:
1. Login to `/admin`
2. Navigate to **Homepage Settings** → **Vision & Mission Section**
3. Edit any field as needed
4. Save changes (cache clears automatically)

## Cache Management

The homepage data is cached for 1 hour. To see changes immediately:
```bash
php artisan cache:forget homepage_v2_data
```

Or clear all cache:
```bash
php artisan cache:clear
```

## Testing

After applying the update, visit your homepage and verify:
- [ ] Vision & Mission section appears between Advisors and Board Members
- [ ] Islamic values are displayed correctly
- [ ] All 10 core values are visible in the floating card
- [ ] Feature pills show 5 items
- [ ] Text is properly formatted with Arabic terms (Taqwa, Ihsan, etc.)
- [ ] Section is responsive on mobile devices

## Related Documentation

- [Quick Start Guide](./quick-start-vision-mission.md) - 3-step setup
- [Admin Sections Guide](./admin-sections-guide.md) - All homepage sections
- [Tech Stack](./../../steering/tech.md) - Commands and tools
