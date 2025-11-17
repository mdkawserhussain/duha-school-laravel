# Quick Start: Vision & Mission Section

## 🎯 Access
**Admin Dashboard → Homepage Settings → Vision & Mission**

## ✏️ What You Can Edit

| Section | What It Controls |
|---------|------------------|
| **Badge & Heading** | Top badge text, main heading (2 lines), description |
| **Vision Card** | Vision title and statement |
| **Mission Card** | Mission title and statement |
| **Feature Pills** | Highlight features (e.g., "Cambridge Primary to A-Level") |
| **Campus Image** | Upload image, set overlay title and subtitle |
| **Core Values** | Floating card with your core values list |
| **Settings** | Show/hide section, set display order |

## 🚀 Quick Edit Steps

1. Click on any section to expand it
2. Edit the fields you want to change
3. Click **"Save Changes"** at the bottom
4. Visit your homepage to see the updates

## 💡 Pro Tips

- **Vision & Mission**: Keep under 500 characters for best display
- **Features**: 3-5 features look best
- **Core Values**: 3-4 values fit perfectly in the card
- **Images**: Use high-quality photos (max 5MB)
- **Toggle Off**: Use "Active" toggle to temporarily hide the section

## 🔄 Reset to Defaults

If you want to restore the original content, contact your developer to run:
```bash
php artisan db:seed --class=VisionMissionSectionSeeder
```

## ❓ Need Help?

See the full guide: `VISION_MISSION_ADMIN_GUIDE.md`
