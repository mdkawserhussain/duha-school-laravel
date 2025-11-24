# Leadership Pages Guide

## 🎯 Overview

Custom leadership page template with enhanced UI for founder, director, and principal message pages.

## ✨ Features

### 1. **Profile Card Component**
- Professional profile display
- Photo with decorative elements
- Name, title, and bio
- Contact buttons (email, phone, LinkedIn)
- Horizontal or vertical layout options

### 2. **Enhanced Hero Section**
- Gradient background (navy to blue)
- Decorative patterns and floating elements
- Badge, title, and subtitle support
- Responsive design

### 3. **Better Typography**
- Drop cap on first paragraph
- Enhanced prose styling
- Larger, more readable text
- Better spacing and hierarchy
- Styled blockquotes with gold accent

### 4. **Visual Decorations**
- Background patterns
- Floating gradient orbs
- Large decorative quote mark
- Signature section with photo
- Gradient borders and shadows

### 5. **Call-to-Action Section**
- Gradient background card
- Links to About and Contact pages
- Engaging copy
- Responsive buttons

---

## 📝 Usage

### Automatic Template Selection

The leadership template is automatically used for these page slugs:
- `founder-director-message`
- `principal-message`
- `founder-message`
- `director-message`

### Adding Profile Data

In the Filament admin, add profile data to the page's metadata field (JSON):

```json
{
  "leader_name": "Dr. Ahmed Hassan",
  "leader_title": "Founder & Director",
  "leader_bio": "Dr. Hassan has over 20 years of experience in Islamic education...",
  "leader_email": "ahmed.hassan@school.edu",
  "leader_phone": "+880-1234-567890",
  "leader_linkedin": "https://linkedin.com/in/ahmed-hassan"
}
```

### Adding Profile Image

1. Go to the page in Filament admin
2. Upload image to the "Profile Image" media collection
3. The image will automatically display in the profile card

---

## 🎨 Component Usage

### Profile Card Component

You can use the profile card component anywhere:

```blade
<x-profile-card 
    name="Dr. Ahmed Hassan"
    title="Founder & Director"
    :image="$imageUrl"
    bio="Brief bio text here..."
    email="email@example.com"
    phone="+880-1234-567890"
    linkedin="https://linkedin.com/in/username"
    layout="horizontal"
/>
```

**Props:**
- `name` (string) - Person's name
- `title` (string) - Job title/position
- `image` (string|null) - Image URL
- `bio` (string) - Short biography
- `email` (string|null) - Email address
- `phone` (string|null) - Phone number
- `linkedin` (string|null) - LinkedIn URL
- `layout` (string) - 'horizontal' or 'vertical'

---

## 🎨 Design Elements

### Color Palette
- **Primary**: Navy (#0C1B3D) to Blue (#2563EB) gradient
- **Accent**: Gold (#F4C430)
- **Text**: Midnight (#0C1B3D), Gray (#4B5563)
- **Background**: White to Gray gradient

### Typography
- **Headings**: Bold, tight tracking
- **Body**: Large (prose-lg to prose-xl)
- **Drop Cap**: 7xl, ocean blue
- **Blockquotes**: Gold left border, gray background

### Spacing
- **Sections**: py-12 to py-20
- **Cards**: p-6 to p-8
- **Gaps**: 4 to 8 units

### Decorative Elements
- Floating gradient orbs (blur-3xl)
- Background patterns (SVG)
- Large quote mark (text-9xl, opacity-10)
- Ring effects on images
- Shadow layers

---

## 📱 Responsive Design

### Mobile (< 768px)
- Single column layout
- Smaller text sizes
- Stacked buttons
- Reduced padding

### Tablet (768px - 1024px)
- Profile card switches to horizontal
- Larger text
- Side-by-side buttons

### Desktop (> 1024px)
- Full horizontal profile card
- Maximum text sizes
- Optimal spacing
- All decorative elements visible

---

## 🔧 Customization

### Adding More Leadership Pages

Edit `app/Http/Controllers/PageController.php`:

```php
$leadershipPages = [
    'founder-director-message',
    'principal-message',
    'founder-message',
    'director-message',
    'vice-principal-message', // Add new page slug
];
```

### Changing Profile Card Layout

In the template, change the `layout` prop:

```blade
<x-profile-card 
    ...
    layout="vertical"  {{-- or "horizontal" --}}
/>
```

### Customizing Colors

Update the gradient in `resources/views/pages/leadership.blade.php`:

```html
<section class="relative py-16 md:py-24 overflow-hidden" 
         style="background: linear-gradient(135deg, #YourColor1 0%, #YourColor2 50%, #YourColor3 100%);">
```

---

## ✅ Features Checklist

- [x] Profile card component
- [x] Enhanced typography with drop cap
- [x] Visual decorations (patterns, orbs, quote mark)
- [x] Custom leadership template
- [x] Automatic template selection
- [x] Responsive design
- [x] Contact buttons
- [x] Signature section
- [x] Call-to-action section
- [x] Print & share functionality
- [x] Breadcrumbs
- [x] SEO optimization

---

## 📊 Performance

- **WebP images** for profile photos
- **Lazy loading** for images
- **Minimal CSS** (Tailwind utilities)
- **No external dependencies**
- **Fast page load** (< 2s)

---

## 🎯 Best Practices

1. **Profile Photos**: Use high-quality, professional photos (min 400x400px)
2. **Bio Length**: Keep bio under 200 characters for profile card
3. **Content**: Use full message content in the main content area
4. **Metadata**: Always include leader_name and leader_title at minimum
5. **Images**: Upload WebP format for best performance
6. **Links**: Verify email, phone, and LinkedIn URLs are correct

---

## 📚 Related Files

- **Component**: `resources/views/components/profile-card.blade.php`
- **Template**: `resources/views/pages/leadership.blade.php`
- **Controller**: `app/Http/Controllers/PageController.php`
- **Base Template**: `resources/views/pages/page.blade.php`

---

**Status**: ✅ Implemented
**Version**: 1.0
**Last Updated**: November 2025
