#!/bin/bash

set -e

echo "🚀 Deploying Duha International School Application..."

# Maintenance mode
echo "🔧 Enabling maintenance mode..."
php artisan down || true

# Pull latest code (if using git)
if [ -d .git ]; then
    echo "📥 Pulling latest code..."
    git pull origin main || git pull origin master
fi

# Install/update dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install/update Node dependencies
echo "📦 Installing Node dependencies..."
npm ci

# Build assets
echo "🎨 Building production assets..."
npm run build

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Clear caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Generate sitemap
echo "🗺️  Generating sitemap..."
php artisan sitemap:generate || true

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Restart queue workers (if using supervisor)
if command -v supervisorctl &> /dev/null; then
    echo "🔄 Restarting queue workers..."
    supervisorctl restart laravel-worker:* || true
fi

# Restart Horizon (if using)
if php artisan list | grep -q "horizon:terminate"; then
    echo "🔄 Restarting Horizon..."
    php artisan horizon:terminate || true
fi

# Disable maintenance mode
echo "✅ Disabling maintenance mode..."
php artisan up

echo "✅ Deployment complete!"
echo ""
echo "📋 Post-deployment checklist:"
echo "   ✓ Verify application is accessible"
echo "   ✓ Check queue workers are running"
echo "   ✓ Verify scheduled tasks (cron)"
echo "   ✓ Test admin panel access"
echo "   ✓ Check error logs"
echo ""

