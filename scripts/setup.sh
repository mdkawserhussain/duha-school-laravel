#!/bin/bash

set -e

echo "🚀 Setting up Duha International School Laravel Application..."

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "ℹ️  .env file already exists, skipping..."
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate
else
    echo "ℹ️  Application key already exists, skipping..."
fi

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm install

# Build assets
echo "🎨 Building frontend assets..."
npm run build

# Set permissions
echo "🔐 Setting storage and cache permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Seed database
echo "🌱 Seeding database..."
php artisan db:seed --force

# Generate sitemap
echo "🗺️  Generating sitemap..."
php artisan sitemap:generate

# Create storage link
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Setup complete!"
echo ""
echo "📋 Next steps:"
echo "   1. Update .env file with your database credentials"
echo "   2. Run 'php artisan serve' to start the development server"
echo "   3. Visit http://localhost:8000 in your browser"
echo "   4. Admin panel: http://localhost:8000/admin"
echo ""

