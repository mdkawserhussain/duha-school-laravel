# Quick Start: Vision & Mission Section

## ✅ What's Ready

1. **Seeder Updated** with Islamic-focused content
2. **DatabaseSeeder** now includes VisionMissionSectionSeeder
3. **Admin Panel** has full editing capabilities
4. **Homepage** displays section between Advisors and Board Members

## 🚀 Quick Setup (3 Steps)

### Step 1: Run Seeder
```bash
php artisan db:seed --class=VisionMissionSectionSeeder
```

### Step 2: Clear Cache
```bash
php artisan cache:forget homepage_v2_data
```

### Step 3: View Homepage
Visit your homepage and scroll to the Vision & Mission section (between Advisors and Board Members).

## 📝 What You'll See

### Vision
"To be a beacon of Islamic education excellence, cultivating generations of God-conscious learners who embody Taqwa, pursue knowledge with Ihsan, and lead with wisdom, integrity, and compassion to serve humanity and please Allah (SWT)."

### Mission
"To provide holistic Islamic education that seamlessly integrates Cambridge academic excellence with Qur'anic sciences, Arabic mastery, and prophetic character development—preparing students to excel in both Dunya and Akhirah while serving as ambassadors of Islam."

### 10 Islamic Core Values
1. Tawheed - Oneness of Allah
2. Taqwa - God Consciousness
3. Ihsan - Excellence in All
4. Amanah - Trust & Responsibility
5. Adab - Prophetic Manners
6. Ilm - Pursuit of Knowledge
7. Sabr - Patience & Perseverance
8. Shukr - Gratitude to Allah
9. Rahmah - Mercy & Compassion
10. Khidmah - Service to Others

## 🎨 Customizing via Admin

1. Login: `/admin`
2. Navigate: **Homepage Settings** → **Vision & Mission**
3. Edit any field
4. Upload campus image
5. Click **Save**
6. Cache clears automatically

## 📚 Full Documentation

- [vision-mission-update.md](./vision-mission-update.md) - Complete update details
- [admin-sections-guide.md](./admin-sections-guide.md) - All admin sections guide

## 🔧 Alternative Methods

### Using Custom Command
```bash
php artisan homepage:update-vision
```

### Using SQL (Direct Database)
```bash
# Run the SQL file in your PostgreSQL client
database/seeders/insert_vision_mission.sql
```

### Seed Everything
```bash
php artisan db:seed
```

## ✨ Features

- ✅ Islamic-focused content
- ✅ 10 core Islamic values
- ✅ 5 feature highlights
- ✅ Campus image upload
- ✅ Fully editable in admin
- ✅ Responsive design
- ✅ Auto cache clearing
- ✅ WebP image optimization

## 🎯 Section Position

```
Homepage Order:
├── Hero
├── Achievements
├── Stats
├── News & Events
├── Parallax
├── Competitions
├── Advisors & Board
├── Vision & Mission ← HERE
├── Board Members
└── Programs
```

## 💡 Pro Tips

1. **Images**: Upload high-quality campus photos (min 1920x1080)
2. **Values**: Keep them concise (3-5 words each)
3. **Vision**: Aspirational and inspiring
4. **Mission**: Actionable and specific
5. **Cache**: Always clear after changes

## 🐛 Troubleshooting

**Not seeing changes?**
```bash
php artisan cache:forget homepage_v2_data
php artisan view:clear
```

**Image not uploading?**
```bash
php artisan storage:link
```

**Section not active?**
- Check admin: Vision & Mission → Active toggle is ON

## 📞 Need Help?

Check the comprehensive guides:
- [admin-sections-guide.md](./admin-sections-guide.md) - All sections
- [vision-mission-update.md](./vision-mission-update.md) - Detailed update info
