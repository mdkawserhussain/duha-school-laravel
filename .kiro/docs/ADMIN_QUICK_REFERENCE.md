# Admin Panel Quick Reference

## 🚀 Quick Access

**Admin URL**: `/admin`

## 📊 Navigation Structure

### Dashboard
- Overview widgets
- Quick stats
- Recent activity

### Homepage Settings (19 Sections)
1. Achievements
2. Advisors & Board
3. Board Members
4. Call to Action
5. Children Responsibility
6. Competitions
7. **Enrollment News** ← Enrollment section
8. Hero Slider
9. **Notice Board** ← Notices section
10. Our Values
11. Parallax Experience
12. Academic Programs
13. Regular Events
14. Stat Highlights ← Highlights section
15. Stats Heading
16. Statistics
17. **Upcoming Events** ← Events section
18. **Vision & Mission** ← Vision section
19. Why Choose Us

### Content
- **Pages** (Full CRUD)
- **Events** (Full CRUD)
- **Notices** (Full CRUD)

### Applications
- **Admission Applications** (View/Edit)
- **Career Applications** (View/Edit)

### People
- **Staff** (Full CRUD)

### Site Settings
- **Announcements** (Full CRUD)
- General Settings

## ⚡ Common Tasks

### Edit Homepage Section
1. Login → Homepage Settings
2. Click section name
3. Edit fields
4. Save (cache auto-clears)

### Create New Event
1. Login → Content → Events
2. Click "New Event"
3. Fill form (title auto-generates slug)
4. Upload image (optional)
5. Set status to "Published"
6. Save

### Create New Notice
1. Login → Content → Notices
2. Click "New Notice"
3. Fill form (title, excerpt, content)
4. Toggle "Published" ON
5. Toggle "Important" if urgent
6. Save

### Review Applications
1. Login → Applications
2. Click "Admission Applications" or "Career Applications"
3. View pending (badge shows count)
4. Click "View" or "Edit"
5. Update status
6. Add review notes
7. Save

### Manage Staff
1. Login → People → Staff
2. Click "New Staff" or edit existing
3. Upload photo
4. Add social links
5. Set order (lower = first)
6. Toggle "Active" ON
7. Save

## 🔑 Keyboard Shortcuts

- **Ctrl+S**: Save form (in most browsers)
- **Ctrl+Shift+R**: Hard refresh browser
- **Esc**: Close modal/dialog

## 🎨 Field Types

- **TextInput**: Single-line text
- **Textarea**: Multi-line text
- **RichEditor**: HTML editor with formatting
- **FileUpload**: Image/file upload with editor
- **DatePicker**: Date selection
- **DateTimePicker**: Date + time selection
- **Select**: Dropdown menu
- **Toggle**: On/off switch
- **Repeater**: Dynamic list of items

## 🖼️ Image Guidelines

- **Max Size**: 5MB
- **Formats**: JPEG, PNG, WebP, SVG
- **Recommended**: 1920x1080 or higher
- **Auto-Convert**: All images → WebP
- **Aspect Ratios**: 16:9, 4:3, 1:1 (use image editor)

## 🔐 Permissions

### Admin Role
- ✅ Full access to everything
- ✅ Can delete records
- ✅ Access to site settings

### Editor Role
- ✅ Content management (Pages, Events, Notices, Staff)
- ✅ Homepage sections
- ❌ Cannot delete
- ❌ No site settings
- ❌ No applications

### Admissions Officer Role
- ✅ View/edit applications only
- ❌ No content management
- ❌ Cannot delete

## 🐛 Quick Fixes

### Changes not showing?
```bash
php artisan cache:forget homepage_v2_data
php artisan view:clear
```
Then hard refresh browser (Ctrl+Shift+R)

### Image not uploading?
```bash
php artisan storage:link
```

### Section not appearing?
- Check "Is Active" toggle is ON
- Verify "Sort Order" is set
- Clear cache

## 📱 Mobile Testing

After making changes:
1. Clear cache
2. Hard refresh browser
3. Test on mobile device or use browser dev tools
4. Check responsive design

## 🔍 Search & Filter

### In Tables
- Use search box at top
- Click column headers to sort
- Use filters dropdown
- Toggle columns visibility

### Finding Records
- Use search in table
- Apply filters
- Sort by date/name
- Check pagination

## 💾 Backup Reminder

Before major changes:
1. Export data if possible
2. Take database backup
3. Note current settings
4. Test on staging first (if available)

## 📞 Support

### Documentation
- [Admin CRUD Operations](./admin-crud-operations.md)
- [Homepage Sections Guide](./homepage/admin-sections-guide.md)
- [Sections Verification](./admin-homepage-sections-verification.md)

### Common Issues
- Check logs: `storage/logs/laravel.log`
- Clear all caches: `php artisan cache:clear`
- Restart queue: `php artisan queue:restart`

## ⚙️ Maintenance Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Clear specific cache
php artisan cache:forget homepage_v2_data

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue management
php artisan queue:work
php artisan queue:restart
php artisan horizon
```

## 🎯 Best Practices

1. **Save Often**: Don't lose work
2. **Preview Changes**: Use view action before publishing
3. **Use Drafts**: For pages/events not ready
4. **Optimize Images**: Compress before upload
5. **Test Mobile**: Always check responsive design
6. **Clear Cache**: After major changes
7. **Use Slugs**: Keep URLs clean and SEO-friendly
8. **Add Alt Text**: For accessibility (in image editor)
9. **Review Before Delete**: Deletion is permanent
10. **Keep Backups**: Regular database backups

## 📊 Dashboard Widgets

- **Stats Overview**: Quick metrics
- **Recent Applications**: Latest submissions
- **Upcoming Events**: Next 5 events
- **Quick Actions**: Common tasks
- **Theme Toggle**: Light/dark mode

## 🔄 Workflow Tips

### Publishing Content
1. Create as draft
2. Add all content
3. Upload images
4. Preview
5. Set publish date
6. Change status to published
7. Save

### Managing Applications
1. Check badge count
2. Filter by status
3. Review details
4. Update status
5. Add notes
6. Download documents
7. Save

### Homepage Updates
1. Edit section
2. Update content
3. Upload new images
4. Preview changes
5. Save (cache auto-clears)
6. Verify on frontend

## 🎨 Content Guidelines

### Titles
- Clear and concise
- 50-60 characters max
- Include keywords

### Descriptions
- 150-160 characters
- Compelling and informative
- Call to action

### Images
- High quality
- Relevant to content
- Proper aspect ratio
- Compressed for web

### Rich Text
- Use headings (H2, H3)
- Break into paragraphs
- Add lists for readability
- Include links where relevant

## 🚦 Status Indicators

### Content Status
- 🟢 **Published**: Live on website
- 🟡 **Draft**: Not visible to public
- 🔴 **Archived**: Hidden but preserved

### Application Status
- 🟡 **Pending**: Awaiting review
- 🔵 **Reviewed**: Reviewed but not decided
- 🟢 **Approved/Shortlisted**: Accepted
- 🔴 **Rejected**: Declined

### Section Status
- ✅ **Active**: Visible on homepage
- ❌ **Inactive**: Hidden from homepage

---

**Last Updated**: November 2025
**Version**: 1.0
