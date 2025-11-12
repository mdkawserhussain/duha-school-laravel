# Deployment Guide

This guide provides step-by-step instructions for deploying the Al-Maghrib International School Laravel application to production.

## 📋 Pre-Deployment Checklist

- [ ] Server meets minimum requirements (PHP 8.2+, MySQL 8.0+, Redis)
- [ ] Domain name configured and DNS pointing to server
- [ ] SSL certificate ready (Let's Encrypt recommended)
- [ ] Database created and credentials ready
- [ ] Email service configured (SMTP/SendGrid/Mailgun)
- [ ] S3 bucket created (if using S3 storage)
- [ ] Environment variables documented

## 🖥️ Server Requirements

### Minimum Requirements

- **PHP**: 8.2 or higher
- **Extensions**: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML, GD, MySQLi
- **Database**: MySQL 8.0+ / MariaDB 10.6+ / PostgreSQL 13+
- **Web Server**: Nginx 1.18+ or Apache 2.4+
- **Memory**: 512MB minimum (1GB+ recommended)
- **Storage**: 2GB+ for application and media

### Recommended Setup

- **PHP-FPM**: 8.2 or 8.3
- **Nginx**: Latest stable
- **MySQL**: 8.0+
- **Redis**: 7.0+ (for queues and caching)
- **Supervisor**: For queue workers
- **Certbot**: For SSL certificates

## 🚀 Deployment Methods

### Option 1: Laravel Forge

1. **Connect your server** to Forge
2. **Create a new site** and link your repository
3. **Configure environment variables** in Forge dashboard
4. **Set up deployment script**:
   ```bash
   cd /home/forge/default
   git pull origin main
   composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
   npm ci
   npm run build
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan horizon:terminate
   ```
5. **Configure queue workers** in Forge (Supervisor)
6. **Set up scheduled tasks** (cron jobs)

### Option 2: DigitalOcean App Platform

1. **Connect your GitHub repository**
2. **Configure build settings**:
   - Build command: `composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev && npm ci && npm run build`
   - Run command: `php artisan serve --host=0.0.0.0 --port=8080`
3. **Add environment variables**
4. **Configure database** (managed MySQL)
5. **Set up workers** for queue processing

### Option 3: Manual Deployment (VPS)

#### Step 1: Server Setup

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install MySQL
sudo apt install -y mysql-server

# Install Redis
sudo apt install -y redis-server

# Install Nginx
sudo apt install -y nginx

# Install Supervisor
sudo apt install -y supervisor
```

#### Step 2: Clone and Setup Application

```bash
# Clone repository
cd /var/www
sudo git clone <your-repo-url> almaghrib-school
cd almaghrib-school

# Set permissions
sudo chown -R www-data:www-data /var/www/almaghrib-school
sudo chmod -R 755 /var/www/almaghrib-school
sudo chmod -R 775 storage bootstrap/cache

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci
npm run build

# Copy environment file
cp .env.example .env
php artisan key:generate

# Edit .env with production values
nano .env
```

#### Step 3: Database Setup

```bash
# Create database
sudo mysql -e "CREATE DATABASE almaghrib_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'almaghrib_user'@'localhost' IDENTIFIED BY 'strong_password';"
sudo mysql -e "GRANT ALL PRIVILEGES ON almaghrib_school.* TO 'almaghrib_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Run migrations
php artisan migrate --force
php artisan db:seed --force
```

#### Step 4: Nginx Configuration

Create `/etc/nginx/sites-available/almaghrib-school`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name almaghribschool.com www.almaghribschool.com;
    root /var/www/almaghrib-school/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/almaghrib-school /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### Step 5: SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d almaghribschool.com -d www.almaghribschool.com

# Auto-renewal (already configured by certbot)
```

#### Step 6: Queue Workers (Supervisor)

Create `/etc/supervisor/conf.d/almaghrib-worker.conf`:

```ini
[program:almaghrib-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/almaghrib-school/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/almaghrib-school/storage/logs/worker.log
stopwaitsecs=3600
```

Or for Horizon:

```ini
[program:almaghrib-horizon]
process_name=%(program_name)s
command=php /var/www/almaghrib-school/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/almaghrib-school/storage/logs/horizon.log
stopwaitsecs=3600
```

Start Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start almaghrib-worker:*
```

#### Step 7: Scheduled Tasks (Cron)

Edit crontab:

```bash
sudo crontab -e -u www-data
```

Add:

```
* * * * * cd /var/www/almaghrib-school && php artisan schedule:run >> /dev/null 2>&1
```

#### Step 8: Final Optimization

```bash
cd /var/www/almaghrib-school

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Generate sitemap
php artisan sitemap:generate

# Create storage link
php artisan storage:link
```

## 🔄 Deployment Script

Use the provided deployment script:

```bash
chmod +x scripts/deploy.sh
./scripts/deploy.sh
```

Or manually:

```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart workers
sudo supervisorctl restart almaghrib-worker:*
php artisan horizon:terminate
```

## 🔐 Security Configuration

### Environment Variables

Ensure these are set in production:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... # Generated key
```

### File Permissions

```bash
sudo chown -R www-data:www-data /var/www/almaghrib-school
sudo find /var/www/almaghrib-school -type f -exec chmod 644 {} \;
sudo find /var/www/almaghrib-school -type d -exec chmod 755 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

### Firewall

```bash
# Allow SSH, HTTP, HTTPS
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

## 📊 Monitoring

### Queue Monitoring

Access Horizon dashboard at `/horizon` (requires authentication).

### Log Monitoring

Monitor application logs:

```bash
tail -f storage/logs/laravel.log
```

### Server Monitoring

Consider using:
- **UptimeRobot**: For uptime monitoring
- **Sentry**: For error tracking
- **New Relic**: For performance monitoring

## 💾 Backups

### Automated Backups

Use the provided backup script:

```bash
chmod +x scripts/backup.sh
./scripts/backup.sh
```

### Database Backup

```bash
# Manual backup
mysqldump -u username -p almaghrib_school > backup_$(date +%Y%m%d).sql

# Restore
mysql -u username -p almaghrib_school < backup_20240101.sql
```

### Scheduled Backups

Add to crontab:

```bash
0 2 * * * /var/www/almaghrib-school/scripts/backup.sh
```

## 🔧 Troubleshooting

### Common Issues

**Issue**: 500 Internal Server Error
- Check file permissions
- Review `storage/logs/laravel.log`
- Verify `.env` configuration

**Issue**: Queue jobs not processing
- Check Supervisor status: `sudo supervisorctl status`
- Verify Redis connection
- Check queue connection in `.env`

**Issue**: Assets not loading
- Run `npm run build`
- Check `public/build` directory exists
- Verify Nginx configuration

**Issue**: Database connection errors
- Verify database credentials in `.env`
- Check MySQL service: `sudo systemctl status mysql`
- Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

## 📈 Performance Optimization

### Caching

Enable Redis caching:

```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### CDN Setup

1. Configure Cloudflare or similar CDN
2. Point DNS to CDN
3. Configure cache rules
4. Enable image optimization

### Database Optimization

```sql
-- Add indexes for frequently queried columns
ALTER TABLE events ADD INDEX idx_event_date (event_date);
ALTER TABLE events ADD INDEX idx_published (is_published, published_at);
ALTER TABLE notices ADD INDEX idx_published (is_published, published_at);
```

## 🔄 Updates and Maintenance

### Updating the Application

```bash
cd /var/www/almaghrib-school
git pull origin main
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo supervisorctl restart almaghrib-worker:*
```

### Maintenance Mode

Enable:

```bash
php artisan down
```

Disable:

```bash
php artisan up
```

## 📞 Support

For deployment issues:
1. Check application logs: `storage/logs/laravel.log`
2. Check server logs: `/var/log/nginx/error.log`
3. Verify environment variables
4. Test database connection
5. Review this guide

---

**Happy Deploying! 🚀**

