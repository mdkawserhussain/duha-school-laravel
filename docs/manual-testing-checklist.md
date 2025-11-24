# Manual Testing Checklist - Admin Panel

## Pre-Testing Setup

- [ ] Ensure database is seeded with test data
- [ ] Ensure at least one admin user exists
- [ ] Clear all caches: `php artisan cache:clear && php artisan config:clear && php artisan route:clear`
- [ ] Start development server: `php artisan serve`
- [ ] Open browser in incognito/private mode for clean testing

---

## 1. Authentication & Access Control

### Login
- [ ] Navigate to `/login`
- [ ] Enter valid admin email and password
- [ ] Click "Log in" button
- [ ] Verify redirect to `/admin/dashboard`
- [ ] Verify admin sidebar is visible
- [ ] Verify user name/email is displayed in navbar

### Invalid Login
- [ ] Try logging in with invalid email
- [ ] Verify error message is displayed
- [ ] Try logging in with invalid password
- [ ] Verify error message is displayed
- [ ] Try logging in with empty fields
- [ ] Verify validation errors are displayed

### Logout
- [ ] Click logout button
- [ ] Verify redirect to login page
- [ ] Verify cannot access admin routes after logout

### Access Control
- [ ] Try accessing `/admin/dashboard` without login
- [ ] Verify redirect to login page
- [ ] Try accessing `/admin/events` without login
- [ ] Verify redirect to login page

---

## 2. Dashboard

### Dashboard Display
- [ ] Verify dashboard loads without errors
- [ ] Verify statistics cards are displayed
- [ ] Verify statistics show correct counts
- [ ] Verify "Recent Events" section displays events
- [ ] Verify "Recent Notices" section displays notices
- [ ] Verify "Recent Applications" section displays applications (if applicable)
- [ ] Verify "Quick Actions" section is visible
- [ ] Verify all links in Quick Actions work

### Dashboard Links
- [ ] Click "New Event" quick action
- [ ] Verify redirect to event create page
- [ ] Click "New Notice" quick action
- [ ] Verify redirect to notice create page
- [ ] Click "New Page" quick action
- [ ] Verify redirect to page create page
- [ ] Click "Manage Hero" quick action
- [ ] Verify redirect to hero slider page

### Dashboard Statistics
- [ ] Verify "Total Pages" count is accurate
- [ ] Verify "Upcoming Events" count is accurate
- [ ] Verify "Active Staff" count is accurate
- [ ] Verify "Pending Admissions" count is accurate (if applicable)
- [ ] Verify "Pending Career Apps" count is accurate (if applicable)
- [ ] Click on each statistic card
- [ ] Verify redirect to corresponding index page

---

## 3. Events Management

### Events List (Index)
- [ ] Navigate to `/admin/events`
- [ ] Verify events table is displayed
- [ ] Verify pagination works (if more than 15 events)
- [ ] Verify search functionality works
- [ ] Verify status filter works (published/draft/archived)
- [ ] Verify category filter works
- [ ] Verify featured filter works
- [ ] Verify "Create New Event" button is visible
- [ ] Verify "View", "Edit", "Delete" actions are visible for each event

### Create Event
- [ ] Click "Create New Event" button
- [ ] Verify form loads without errors
- [ ] Fill in all required fields (title, content, dates)
- [ ] Upload a featured image
- [ ] Set event status to "published"
- [ ] Click "Save Event" button
- [ ] Verify success message is displayed
- [ ] Verify redirect to events index
- [ ] Verify new event appears in list

### Edit Event
- [ ] Click "Edit" on an existing event
- [ ] Verify form loads with existing data
- [ ] Verify featured image is displayed (if exists)
- [ ] Modify event title
- [ ] Modify event content using rich text editor
- [ ] Change event status
- [ ] Click "Save Event" button
- [ ] Verify success message is displayed
- [ ] Verify changes are saved

### View Event
- [ ] Click "View" on an event
- [ ] Verify event details are displayed correctly
- [ ] Verify featured image is displayed (if exists)
- [ ] Verify all event information is shown

### Delete Event
- [ ] Click "Delete" on an event
- [ ] Verify confirmation dialog appears
- [ ] Confirm deletion
- [ ] Verify success message is displayed
- [ ] Verify event is removed from list

### Event Validation
- [ ] Try creating event without title
- [ ] Verify validation error is displayed
- [ ] Try creating event with invalid date format
- [ ] Verify validation error is displayed
- [ ] Try creating event with end date before start date
- [ ] Verify validation error is displayed

---

## 4. Notices Management

### Notices List (Index)
- [ ] Navigate to `/admin/notices`
- [ ] Verify notices table is displayed
- [ ] Verify pagination works
- [ ] Verify search functionality works
- [ ] Verify published status filter works
- [ ] Verify category filter works
- [ ] Verify important filter works
- [ ] Verify "Create New Notice" button is visible

### Create Notice
- [ ] Click "Create New Notice" button
- [ ] Fill in title and content
- [ ] Select category
- [ ] Mark as important (if needed)
- [ ] Set publication date
- [ ] Upload featured image
- [ ] Click "Save Notice" button
- [ ] Verify success message
- [ ] Verify notice appears in list

### Edit Notice
- [ ] Click "Edit" on a notice
- [ ] Verify form loads with existing data
- [ ] Modify content using rich text editor
- [ ] Change publication date
- [ ] Click "Save Notice" button
- [ ] Verify changes are saved

### Delete Notice
- [ ] Click "Delete" on a notice
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify notice is removed

### Notice Validation
- [ ] Try creating notice without title
- [ ] Verify validation error
- [ ] Try creating notice without content
- [ ] Verify validation error

---

## 5. Pages Management

### Pages List (Index)
- [ ] Navigate to `/admin/pages`
- [ ] Verify pages table is displayed
- [ ] Verify pagination works
- [ ] Verify search functionality works
- [ ] Verify category filter works
- [ ] Verify published status filter works

### Create Page
- [ ] Click "Create New Page" button
- [ ] Fill in title
- [ ] Add content using rich text editor
- [ ] Test rich text editor features:
  - [ ] Bold, italic formatting
  - [ ] Bullet lists
  - [ ] Numbered lists
  - [ ] Insert image via editor
  - [ ] Create links
  - [ ] View HTML source
- [ ] Fill in meta title and description
- [ ] Upload featured image
- [ ] Set page as published
- [ ] Click "Save Page" button
- [ ] Verify success message
- [ ] Verify page appears in list

### Edit Page
- [ ] Click "Edit" on a page
- [ ] Verify form loads with existing data
- [ ] Modify content in rich text editor
- [ ] Insert new image via editor
- [ ] Click "Save Page" button
- [ ] Verify changes are saved

### Delete Page
- [ ] Click "Delete" on a page
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify page is removed

---

## 6. Staff Management

### Staff List (Index)
- [ ] Navigate to `/admin/staff`
- [ ] Verify staff table is displayed
- [ ] Verify pagination works
- [ ] Verify search functionality works
- [ ] Verify active status filter works
- [ ] Verify type filter works

### Create Staff Member
- [ ] Click "Create New Staff Member" button
- [ ] Fill in name, position, bio
- [ ] Enter email and phone
- [ ] Add social media links
- [ ] Upload profile image
- [ ] Set staff as active
- [ ] Click "Save Staff Member" button
- [ ] Verify success message
- [ ] Verify staff member appears in list

### Edit Staff Member
- [ ] Click "Edit" on a staff member
- [ ] Verify form loads with existing data
- [ ] Verify profile image is displayed
- [ ] Modify bio
- [ ] Update social links
- [ ] Click "Save Staff Member" button
- [ ] Verify changes are saved

### Delete Staff Member
- [ ] Click "Delete" on a staff member
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify staff member is removed

---

## 7. Hero Slider Management

### Hero Slider List
- [ ] Navigate to `/admin/hero-slider`
- [ ] Verify slider list is displayed
- [ ] Verify slides are sortable (drag and drop)
- [ ] Verify active/inactive toggle works
- [ ] Verify "Create New Slide" button is visible

### Create Hero Slide
- [ ] Click "Create New Slide" button
- [ ] Fill in title, subtitle, description
- [ ] Add button text and link
- [ ] Upload background image
- [ ] Upload video (optional)
- [ ] Set slide as active
- [ ] Click "Save Slide" button
- [ ] Verify success message
- [ ] Verify slide appears in list

### Edit Hero Slide
- [ ] Click "Edit" on a slide
- [ ] Verify form loads with existing data
- [ ] Verify images are displayed
- [ ] Modify slide content
- [ ] Change background image
- [ ] Click "Save Slide" button
- [ ] Verify changes are saved

### Reorder Slides
- [ ] Drag and drop slides to reorder
- [ ] Verify order is saved
- [ ] Verify order persists after page refresh

### Toggle Active Status
- [ ] Click toggle on a slide
- [ ] Verify status changes
- [ ] Verify change persists

### Duplicate Slide
- [ ] Click "Duplicate" on a slide
- [ ] Verify new slide is created with same content
- [ ] Verify can edit duplicated slide independently

### Delete Slide
- [ ] Click "Delete" on a slide
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify slide is removed

---

## 8. Homepage Sections Management

### Homepage Sections List
- [ ] Navigate to `/admin/homepage-sections`
- [ ] Verify sections table is displayed
- [ ] Verify pagination works
- [ ] Verify "Create New Section" button is visible

### Create Homepage Section
- [ ] Click "Create New Section" button
- [ ] Enter section key (unique)
- [ ] Select section type
- [ ] Fill in title, subtitle, description
- [ ] Add button text and link
- [ ] Upload multiple images
- [ ] Enter JSON data (if needed)
- [ ] Set sort order
- [ ] Set as active
- [ ] Click "Save Section" button
- [ ] Verify success message
- [ ] Verify section appears in list

### Edit Homepage Section
- [ ] Click "Edit" on a section
- [ ] Verify form loads with existing data
- [ ] Verify images are displayed
- [ ] Modify section content
- [ ] Add/remove images
- [ ] Click "Save Section" button
- [ ] Verify changes are saved

### Delete Homepage Section
- [ ] Click "Delete" on a section
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify section is removed

---

## 9. Homepage Contents Management

### Homepage Contents List
- [ ] Navigate to `/admin/homepage-contents`
- [ ] Verify contents table is displayed
- [ ] Verify pagination works

### Create Homepage Content
- [ ] Click "Create New Content" button
- [ ] Enter content key
- [ ] Fill in title and content (rich text editor)
- [ ] Upload images
- [ ] Set as active
- [ ] Click "Save Content" button
- [ ] Verify success message

### Edit Homepage Content
- [ ] Click "Edit" on a content item
- [ ] Verify form loads with existing data
- [ ] Modify content using rich text editor
- [ ] Click "Save Content" button
- [ ] Verify changes are saved

---

## 10. Navigation Items Management

### Navigation Items List
- [ ] Navigate to `/admin/navigation-items`
- [ ] Verify navigation items table is displayed
- [ ] Verify parent-child relationships are shown
- [ ] Verify "Create New Item" button is visible

### Create Navigation Item
- [ ] Click "Create New Item" button
- [ ] Enter title
- [ ] Enter slug
- [ ] Select route name or enter URL
- [ ] Set parent (if submenu)
- [ ] Set sort order
- [ ] Set as active
- [ ] Click "Save Item" button
- [ ] Verify success message

### Edit Navigation Item
- [ ] Click "Edit" on a navigation item
- [ ] Verify form loads with existing data
- [ ] Modify title or link
- [ ] Change sort order
- [ ] Click "Save Item" button
- [ ] Verify changes are saved

### Delete Navigation Item
- [ ] Click "Delete" on a navigation item
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify item is removed

---

## 11. Announcements Management

### Announcements List
- [ ] Navigate to `/admin/announcements`
- [ ] Verify announcements table is displayed
- [ ] Verify active status is shown
- [ ] Verify expiry dates are shown

### Create Announcement
- [ ] Click "Create New Announcement" button
- [ ] Enter message text
- [ ] Add link (optional)
- [ ] Set start date
- [ ] Set expiry date
- [ ] Set as active
- [ ] Click "Save Announcement" button
- [ ] Verify success message

### Edit Announcement
- [ ] Click "Edit" on an announcement
- [ ] Verify form loads with existing data
- [ ] Modify message
- [ ] Change expiry date
- [ ] Click "Save Announcement" button
- [ ] Verify changes are saved

---

## 12. Site Settings

### Site Settings Page
- [ ] Navigate to `/admin/settings`
- [ ] Verify settings form is displayed
- [ ] Verify all sections are visible:
  - [ ] Website Information
  - [ ] Contact Information
  - [ ] Social Media Links
  - [ ] SEO Settings
  - [ ] Theme Settings
  - [ ] Logo & Favicon

### Update Website Information
- [ ] Modify website name
- [ ] Modify tagline
- [ ] Click "Save Settings" button
- [ ] Verify success message
- [ ] Verify changes are saved

### Update Contact Information
- [ ] Modify phone number
- [ ] Modify email address
- [ ] Modify address
- [ ] Click "Save Settings" button
- [ ] Verify changes are saved

### Upload Logo
- [ ] Click "Choose File" for logo
- [ ] Select an image file
- [ ] Verify image preview appears
- [ ] Click "Save Settings" button
- [ ] Verify logo is uploaded
- [ ] Verify logo appears on frontend

### Upload Favicon
- [ ] Click "Choose File" for favicon
- [ ] Select an image file
- [ ] Click "Save Settings" button
- [ ] Verify favicon is uploaded

### Update Social Media Links
- [ ] Enter Facebook URL
- [ ] Enter Twitter URL
- [ ] Enter Instagram URL
- [ ] Click "Save Settings" button
- [ ] Verify links are saved

---

## 13. Application Management

### Admission Applications List
- [ ] Navigate to `/admin/admission-applications`
- [ ] Verify applications table is displayed
- [ ] Verify status column is shown
- [ ] Verify pagination works
- [ ] Verify status filter works

### View Admission Application
- [ ] Click "View" on an application
- [ ] Verify all application details are displayed
- [ ] Verify applicant information is shown
- [ ] Verify status dropdown is visible
- [ ] Change status to "approved"
- [ ] Click "Update Status" button
- [ ] Verify success message
- [ ] Verify status is updated

### Career Applications List
- [ ] Navigate to `/admin/career-applications`
- [ ] Verify applications table is displayed
- [ ] Verify resume download link is visible

### View Career Application
- [ ] Click "View" on an application
- [ ] Verify all application details are displayed
- [ ] Click "Download Resume" link
- [ ] Verify resume file downloads
- [ ] Change status
- [ ] Click "Update Status" button
- [ ] Verify status is updated

---

## 14. Media Management

### Image Upload
- [ ] Navigate to any create/edit form with image upload
- [ ] Click "Choose File" button
- [ ] Select an image file (JPEG, PNG)
- [ ] Verify file is selected
- [ ] Verify image preview appears (if applicable)
- [ ] Submit form
- [ ] Verify image is uploaded
- [ ] Verify image is converted to WebP format
- [ ] Verify original file is deleted (check storage)

### Multiple Image Upload
- [ ] Navigate to homepage sections create form
- [ ] Select multiple image files
- [ ] Submit form
- [ ] Verify all images are uploaded
- [ ] Verify all images are converted to WebP

### Image Upload via TinyMCE
- [ ] Navigate to page/notice/event edit form
- [ ] Click image icon in TinyMCE toolbar
- [ ] Select "Upload" option
- [ ] Choose an image file
- [ ] Verify image is uploaded
- [ ] Verify image appears in editor
- [ ] Verify image URL is correct

### Image Validation
- [ ] Try uploading file larger than 5MB
- [ ] Verify validation error is displayed
- [ ] Try uploading non-image file
- [ ] Verify validation error is displayed

---

## 15. Rich Text Editor (TinyMCE)

### Editor Functionality
- [ ] Navigate to any form with TinyMCE editor
- [ ] Verify editor loads without errors
- [ ] Type text in editor
- [ ] Select text and apply bold formatting
- [ ] Select text and apply italic formatting
- [ ] Create bullet list
- [ ] Create numbered list
- [ ] Insert link
- [ ] Insert image via editor
- [ ] View HTML source code
- [ ] Switch back to visual editor
- [ ] Verify all formatting is preserved

### Editor Toolbar
- [ ] Verify all toolbar buttons are visible
- [ ] Test undo/redo buttons
- [ ] Test format dropdown
- [ ] Test alignment buttons
- [ ] Test list buttons
- [ ] Test image button
- [ ] Test link button
- [ ] Test code view button

---

## 16. Form Validation

### Required Fields
- [ ] Try submitting form without required fields
- [ ] Verify validation errors are displayed
- [ ] Verify error messages are clear and helpful
- [ ] Verify fields with errors are highlighted

### Field Format Validation
- [ ] Try entering invalid email format
- [ ] Verify validation error
- [ ] Try entering invalid URL format
- [ ] Verify validation error
- [ ] Try entering invalid date format
- [ ] Verify validation error

### Unique Field Validation
- [ ] Try creating item with duplicate slug
- [ ] Verify validation error
- [ ] Try creating item with duplicate section key
- [ ] Verify validation error

---

## 17. Error Handling

### 404 Errors
- [ ] Try accessing non-existent resource (e.g., `/admin/events/9999/edit`)
- [ ] Verify 404 error page is displayed
- [ ] Verify error message is user-friendly

### 500 Errors
- [ ] Trigger a server error (if possible)
- [ ] Verify error is handled gracefully
- [ ] Verify error message is logged

### Network Errors
- [ ] Disconnect internet
- [ ] Try submitting a form
- [ ] Verify error message is displayed
- [ ] Reconnect internet
- [ ] Verify form can be submitted

---

## 18. Cache Management

### Cache Clearing
- [ ] Create a new homepage section
- [ ] Verify homepage cache is cleared
- [ ] View homepage
- [ ] Verify new section appears
- [ ] Edit a homepage section
- [ ] Verify homepage cache is cleared
- [ ] Delete a homepage section
- [ ] Verify homepage cache is cleared

### Cache Performance
- [ ] Load homepage multiple times
- [ ] Verify response time is acceptable
- [ ] Verify cache is working (check response headers)

---

## 19. Responsive Design

### Mobile View (< 640px)
- [ ] Resize browser to mobile width
- [ ] Verify sidebar collapses to hamburger menu
- [ ] Verify all forms are usable on mobile
- [ ] Verify tables are scrollable on mobile
- [ ] Verify buttons are large enough for touch
- [ ] Verify text is readable

### Tablet View (640px - 1024px)
- [ ] Resize browser to tablet width
- [ ] Verify layout adapts correctly
- [ ] Verify forms are properly sized
- [ ] Verify tables are readable

### Desktop View (> 1024px)
- [ ] Verify full sidebar is visible
- [ ] Verify optimal use of screen space
- [ ] Verify forms are properly sized

---

## 20. Accessibility

### Keyboard Navigation
- [ ] Navigate entire admin panel using only keyboard
- [ ] Verify Tab key moves through form fields
- [ ] Verify Enter key submits forms
- [ ] Verify Escape key closes modals
- [ ] Verify all interactive elements are accessible

### Screen Reader
- [ ] Test with screen reader (if available)
- [ ] Verify all form fields have labels
- [ ] Verify buttons have descriptive text
- [ ] Verify images have alt text

### Focus Indicators
- [ ] Verify focus indicators are visible
- [ ] Verify focus order is logical
- [ ] Verify focus is not trapped in modals

---

## 21. Performance

### Page Load Times
- [ ] Measure dashboard load time
- [ ] Verify load time is < 2 seconds
- [ ] Measure form load times
- [ ] Verify forms load quickly

### Image Loading
- [ ] Verify images load progressively
- [ ] Verify lazy loading works
- [ ] Verify WebP images are used

### Database Queries
- [ ] Monitor database queries (if possible)
- [ ] Verify no N+1 query problems
- [ ] Verify queries are optimized

---

## 22. Security

### CSRF Protection
- [ ] Verify all forms have CSRF tokens
- [ ] Try submitting form without CSRF token
- [ ] Verify request is rejected

### XSS Protection
- [ ] Try entering script tags in content fields
- [ ] Verify scripts are sanitized
- [ ] Verify content is displayed safely

### File Upload Security
- [ ] Try uploading executable file
- [ ] Verify file is rejected
- [ ] Try uploading file with malicious name
- [ ] Verify file is handled safely

---

## 23. Browser Compatibility

### Chrome
- [ ] Test all functionality in Chrome
- [ ] Verify no console errors
- [ ] Verify all features work

### Firefox
- [ ] Test all functionality in Firefox
- [ ] Verify no console errors
- [ ] Verify all features work

### Safari
- [ ] Test all functionality in Safari (if available)
- [ ] Verify no console errors
- [ ] Verify all features work

### Edge
- [ ] Test all functionality in Edge
- [ ] Verify no console errors
- [ ] Verify all features work

---

## 24. User Experience

### Flash Messages
- [ ] Verify success messages appear after actions
- [ ] Verify error messages appear on errors
- [ ] Verify messages are dismissible
- [ ] Verify messages don't persist after page refresh

### Loading States
- [ ] Verify loading indicators appear during form submission
- [ ] Verify buttons show loading state
- [ ] Verify page doesn't freeze during operations

### Confirmation Dialogs
- [ ] Verify delete confirmations appear
- [ ] Verify confirmation messages are clear
- [ ] Verify cancel button works
- [ ] Verify confirm button works

---

## 25. Integration Testing

### Frontend-Backend Integration
- [ ] Create content in admin panel
- [ ] Verify content appears on frontend
- [ ] Edit content in admin panel
- [ ] Verify changes appear on frontend
- [ ] Delete content in admin panel
- [ ] Verify content is removed from frontend

### Cache Integration
- [ ] Create homepage section
- [ ] Verify homepage cache is cleared
- [ ] View homepage
- [ ] Verify new section appears immediately

---

## Testing Notes

**Test Date**: _______________  
**Tester**: _______________  
**Browser**: _______________  
**Version**: _______________  

### Issues Found

1. 
2. 
3. 

### Recommendations

1. 
2. 
3. 

---

**Last Updated**: 2025-01-18

