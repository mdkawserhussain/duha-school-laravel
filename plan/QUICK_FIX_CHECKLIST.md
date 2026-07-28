# Quick-Fix Checklist - Remaining Items

This checklist contains all remaining items that need to be completed before production deployment.

## ✅ Completed Items (Just Fixed)

- ✅ **500 Error Page** - Created `resources/views/errors/500.blade.php`
- ✅ **NewsletterSubscribeRequest** - Created Form Request class
- ✅ **NewsletterController Updated** - Now uses NewsletterSubscribeRequest
- ✅ **Scripts Executable** - All scripts now have executable permissions

---

## 🔧 High Priority - Before Production Launch

### 1. Production Configuration Verification
- [ ] Verify `config/filesystems.php` has S3 configuration
- [ ] Verify `config/cache.php` has Redis configuration
- [ ] Verify `config/queue.php` has proper queue driver setup
- [ ] Test Redis connection in production environment
- [ ] Test S3 storage connection (if using)
- [ ] Verify all environment variables are set correctly

**Files to Check:**
- `config/filesystems.php` - Ensure S3 disk is configured
- `config/cache.php` - Ensure Redis store is configured
- `config/queue.php` - Ensure Redis connection is configured
- `.env` - Verify all production values

**Commands:**
```bash
# Test Redis connection
php artisan tinker
>>> Cache::store('redis')->put('test', 'value', 60);
>>> Cache::store('redis')->get('test');

# Test S3 connection (if using)
php artisan tinker
>>> Storage::disk('s3')->put('test.txt', 'test content');
```

---

### 2. Queue Workers Setup (Production)

#### Option A: Using Supervisor (Recommended)
- [ ] Create Supervisor configuration file
- [ ] Configure queue worker process
- [ ] Start Supervisor service
- [ ] Verify queue workers are running
- [ ] Test queue processing

**Supervisor Config File:** `/etc/supervisor/conf.d/almaghrib-worker.conf`
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

**Commands:**
```bash
# Create supervisor config
sudo nano /etc/supervisor/conf.d/almaghrib-worker.conf
# (paste config above)

# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start almaghrib-worker:*

# Check status
sudo supervisorctl status
```

#### Option B: Using Laravel Horizon
- [ ] Verify Horizon is installed
- [ ] Configure Horizon in production
- [ ] Set up Supervisor for Horizon
- [ ] Start Horizon
- [ ] Verify Horizon dashboard is accessible

**Supervisor Config for Horizon:** `/etc/supervisor/conf.d/almaghrib-horizon.conf`
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

**Commands:**
```bash
# Start Horizon
php artisan horizon

# Or via Supervisor
sudo supervisorctl start almaghrib-horizon
```

---

### 3. Scheduled Tasks (Cron) Setup

- [ ] Add Laravel scheduler to crontab
- [ ] Verify cron job is running
- [ ] Test scheduled tasks manually
- [ ] Monitor scheduled task logs

**Crontab Entry:**
```bash
# Edit crontab for web server user
sudo crontab -e -u www-data

# Add this line:
* * * * * cd /var/www/almaghrib-school && php artisan schedule:run >> /dev/null 2>&1
```

**Verify:**
```bash
# Check if cron is running
sudo systemctl status cron

# Test scheduler manually
php artisan schedule:run

# View scheduled tasks
php artisan schedule:list
```

**Scheduled Tasks to Verify:**
- Sitemap generation (weekly)
- Any other scheduled commands

---

### 4. SSL Certificate Setup

- [ ] Install Certbot (Let's Encrypt)
- [ ] Obtain SSL certificate
- [ ] Configure Nginx/Apache for HTTPS
- [ ] Test SSL certificate
- [ ] Set up auto-renewal
- [ ] Verify HTTPS redirect works

**Commands:**
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d almaghribschool.com -d www.almaghribschool.com

# Test renewal
sudo certbot renew --dry-run
```

---

### 5. Backups Configuration

- [ ] Test backup script manually
- [ ] Set up automated daily backups
- [ ] Configure backup storage location
- [ ] Test backup restoration
- [ ] Verify backup retention policy

**Commands:**
```bash
# Test backup script
./scripts/backup.sh

# Add to crontab for daily backups (2 AM)
0 2 * * * cd /var/www/almaghrib-school && ./scripts/backup.sh >> /var/log/backup.log 2>&1
```

**Backup Locations to Verify:**
- Database backups
- Storage/app backups
- Configuration backups (optional)

---

### 6. Monitoring Setup

#### Basic Monitoring
- [ ] Set up uptime monitoring (UptimeRobot or similar)
- [ ] Configure email alerts for downtime
- [ ] Set up error log monitoring
- [ ] Configure disk space monitoring

#### Advanced Monitoring (Optional)
- [ ] Set up Sentry for error tracking
- [ ] Configure performance monitoring
- [ ] Set up log aggregation
- [ ] Configure application metrics

**Basic Setup:**
```bash
# Monitor error logs
tail -f storage/logs/laravel.log

# Monitor queue logs
tail -f storage/logs/worker.log

# Monitor Horizon logs
tail -f storage/logs/horizon.log
```

---

## 🧪 Testing & Verification

### Pre-Launch Testing
- [ ] Test all public routes
- [ ] Test all forms (admission, career, contact, newsletter)
- [ ] Test email sending
- [ ] Test queue processing
- [ ] Test file uploads
- [ ] Test admin panel access
- [ ] Test role-based permissions
- [ ] Test error pages (404, 500)
- [ ] Test mobile responsiveness
- [ ] Test SEO meta tags
- [ ] Test sitemap generation
- [ ] Test ICS export
- [ ] Test Atom feed

**Test Commands:**
```bash
# Run test suite
php artisan test

# Test specific feature
php artisan test --filter AdmissionTest

# Check code coverage (if configured)
php artisan test --coverage
```

---

## 📋 Production Deployment Checklist

### Pre-Deployment
- [ ] Review all environment variables
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` if needed
- [ ] Verify database credentials
- [ ] Verify email configuration
- [ ] Verify Redis configuration
- [ ] Verify S3 configuration (if using)
- [ ] Backup current database (if updating)
- [ ] Review recent code changes

### Deployment Steps
- [ ] Run deployment script: `./scripts/deploy.sh`
- [ ] Or manually:
  ```bash
  git pull origin main
  composer install --no-dev --optimize
  npm ci && npm run build
  php artisan migrate --force
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan horizon:terminate
  ```

### Post-Deployment
- [ ] Verify application loads
- [ ] Verify admin panel accessible
- [ ] Test form submissions
- [ ] Verify email sending
- [ ] Check queue processing
- [ ] Verify scheduled tasks
- [ ] Check error logs
- [ ] Monitor performance
- [ ] Verify SSL certificate
- [ ] Test backups

---

## 🔍 Code Quality & Coverage

### Code Coverage
- [ ] Run code coverage report
- [ ] Verify minimum 80% coverage
- [ ] Add tests for uncovered areas
- [ ] Document test coverage

**Commands:**
```bash
# Run with coverage (requires Xdebug)
php artisan test --coverage

# Or with PHPUnit directly
vendor/bin/phpunit --coverage-html coverage/
```

---

## 📝 Documentation Updates

### Final Documentation
- [ ] Update README with production URLs
- [ ] Document production environment setup
- [ ] Document monitoring procedures
- [ ] Document backup/restore procedures
- [ ] Document troubleshooting guide
- [ ] Update deployment guide with actual steps taken

---

## 🚀 Optional Enhancements (Post-Launch)

### Search Functionality
- [ ] Set up Laravel Scout
- [ ] Configure Meilisearch or Algolia
- [ ] Index existing content
- [ ] Add search UI to frontend

### Image Gallery
- [ ] Implement lightbox for gallery
- [ ] Add image lazy loading
- [ ] Optimize gallery performance

### Additional Features
- [ ] Add breadcrumbs component
- [ ] Add social sharing buttons
- [ ] Add RSS feed for notices
- [ ] Implement multi-language support

### Monitoring & Analytics
- [ ] Set up Sentry error tracking
- [ ] Configure UptimeRobot monitoring
- [ ] Set up performance monitoring
- [ ] Configure log aggregation

---

## ✅ Completion Status

**Total Items**: ~30-35  
**Completed**: 4 (just fixed)  
**Remaining**: ~26-31

### Priority Breakdown
- **High Priority**: 6 items (must complete before launch)
- **Testing**: 1 item (code coverage verification)
- **Deployment**: 1 checklist (follow steps)
- **Optional**: Multiple items (post-launch)

---

## 📞 Support & Resources

### Useful Commands
```bash
# Check application status
php artisan about

# View all routes
php artisan route:list

# Clear all caches
php artisan optimize:clear

# View scheduled tasks
php artisan schedule:list

# Check queue status
php artisan queue:monitor

# View Horizon dashboard
# Visit: /horizon (requires authentication)
```

### Important Files
- `.env` - Environment configuration
- `config/` - All configuration files
- `storage/logs/` - Application logs
- `scripts/` - Deployment and utility scripts
- `DEPLOYMENT.md` - Detailed deployment guide
- `ENV_CONFIGURATION.md` - Environment variables guide

---

**Last Updated**: After completing remaining high-priority items  
**Next Review**: Before production deployment

