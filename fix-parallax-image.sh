#!/bin/bash

# Parallax Background Image Fix Script
# This script helps diagnose and fix the parallax section background image issue

echo "========================================="
echo "Parallax Background Image Fix Script"
echo "========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: This script must be run from the Laravel project root directory${NC}"
    exit 1
fi

echo "Step 1: Checking current configuration..."
echo "-------------------------------------------"

# Get current APP_URL
CURRENT_APP_URL=$(grep "^APP_URL=" .env | cut -d '=' -f2)
echo -e "Current APP_URL: ${YELLOW}${CURRENT_APP_URL}${NC}"

# Check if parallax section exists
echo ""
echo "Step 2: Checking parallax section in database..."
echo "-------------------------------------------"
php artisan tinker --execute="
\$section = App\Models\HomePageSection::where('section_key', 'parallax_experience')->first();
if (\$section) {
    echo 'Section Status: FOUND' . PHP_EOL;
    echo 'Is Active: ' . (\$section->is_active ? 'YES' : 'NO') . PHP_EOL;
    echo 'Has Background Image: ' . (\$section->hasMedia('background_image') ? 'YES' : 'NO') . PHP_EOL;
    if (\$section->hasMedia('background_image')) {
        \$media = \$section->getFirstMedia('background_image');
        echo 'Image URL: ' . \$media->getUrl() . PHP_EOL;
        echo 'File Exists: ' . (file_exists(\$media->getPath()) ? 'YES' : 'NO') . PHP_EOL;
    }
} else {
    echo 'Section Status: NOT FOUND' . PHP_EOL;
}
"

echo ""
echo "Step 3: Checking storage symlink..."
echo "-------------------------------------------"
if [ -L "public/storage" ]; then
    echo -e "${GREEN}✓ Storage symlink exists${NC}"
    ls -la public/storage | head -1
else
    echo -e "${RED}✗ Storage symlink missing${NC}"
    echo "Creating storage symlink..."
    php artisan storage:link
fi

echo ""
echo "Step 4: Checking image file accessibility..."
echo "-------------------------------------------"
if [ -d "storage/app/public/7" ]; then
    echo -e "${GREEN}✓ Media directory exists${NC}"
    echo "Files in storage/app/public/7:"
    ls -lh storage/app/public/7/*.jpeg 2>/dev/null | tail -3
else
    echo -e "${YELLOW}⚠ Media directory not found${NC}"
fi

echo ""
echo "========================================="
echo "Recommended Actions:"
echo "========================================="
echo ""

# Detect how the site might be accessed
echo "1. Update APP_URL in .env file"
echo "   Current: ${CURRENT_APP_URL}"
echo ""
echo "   Choose the correct URL for your setup:"
echo "   - Local development: http://localhost"
echo "   - Custom port: http://localhost:8000"
echo "   - IP address: http://YOUR_IP_ADDRESS"
echo "   - Domain: https://yourdomain.com"
echo ""

read -p "Do you want to update APP_URL now? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Enter new APP_URL (e.g., http://localhost or http://192.168.1.100):"
    read NEW_APP_URL
    
    # Backup .env
    cp .env .env.backup
    echo -e "${GREEN}✓ Created backup: .env.backup${NC}"
    
    # Update APP_URL
    sed -i "s|^APP_URL=.*|APP_URL=${NEW_APP_URL}|" .env
    echo -e "${GREEN}✓ Updated APP_URL to: ${NEW_APP_URL}${NC}"
fi

echo ""
echo "2. Clear all caches"
read -p "Clear caches now? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    echo -e "${GREEN}✓ Caches cleared${NC}"
fi

echo ""
echo "========================================="
echo "Testing:"
echo "========================================="
echo ""
echo "To test if the image is accessible:"
echo "1. Visit your website in a browser"
echo "2. Open DevTools (F12)"
echo "3. Check the Console tab for parallax debug info"
echo "4. Check the Network tab for image requests"
echo ""
echo "If you see a debug panel in the bottom-right corner,"
echo "it will show the image URL and source."
echo ""
echo "You can also test the image URL directly:"
php artisan tinker --execute="
\$section = App\Models\HomePageSection::where('section_key', 'parallax_experience')->first();
if (\$section && \$section->hasMedia('background_image')) {
    \$media = \$section->getFirstMedia('background_image');
    echo 'Test this URL in your browser:' . PHP_EOL;
    echo \$media->getUrl() . PHP_EOL;
}
"

echo ""
echo "========================================="
echo "Alternative: Use Default Image"
echo "========================================="
echo ""
echo "If you want to temporarily use the default image:"
echo "1. Go to Admin Dashboard"
echo "2. Navigate to: Homepage Settings → Parallax Experience"
echo "3. Toggle 'Use Default Image' to ON"
echo "4. Click 'Save Changes'"
echo ""

echo "Script completed!"
echo ""
