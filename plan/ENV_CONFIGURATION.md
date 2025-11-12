# Environment Configuration Guide

This document outlines all environment variables that need to be configured for the AlMaghrib International School application.

## Required Environment Variables

### Application Configuration

```env
APP_NAME="AlMaghrib International School"
APP_ENV=production
APP_KEY=base64:... # Generate with: php artisan key:generate
APP_DEBUG=false
APP_URL=https://almaghribschool.com
APP_TIMEZONE=Asia/Dhaka
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=almaghrib_school
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### Mail Configuration (SMTP/Titan)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.titan.email  # or your SMTP host
MAIL_PORT=587
MAIL_USERNAME=info@almaghribschool.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@almaghribschool.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Queue Configuration

For production, use Redis or database queues:

```env
QUEUE_CONNECTION=redis  # or 'database' if Redis is not available
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
```

### Filesystem/Storage Configuration

For local storage (default):
```env
FILESYSTEM_DISK=local
```

For AWS S3 (recommended for production):
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=almaghrib-school-media
AWS_URL=https://your-bucket.s3.amazonaws.com
```

### School Contact Information

```env
SCHOOL_PHONE=+880-31-1234567
SCHOOL_PHONE_DISPLAY=+880 31 1234567
SCHOOL_EMAIL_INFO=info@almaghribschool.com
SCHOOL_EMAIL_CAREER=career@almaghribschool.com
SCHOOL_EMAIL_ADMISSION=admission@almaghribschool.com
SCHOOL_ADDRESS_LINE1=Al-Maghrib International School
SCHOOL_ADDRESS_LINE2=Chattogram
SCHOOL_ADDRESS_CITY=Chattogram
SCHOOL_ADDRESS_COUNTRY=Bangladesh
SCHOOL_ADDRESS_FULL=Al-Maghrib International School, Chattogram, Bangladesh
SCHOOL_FACEBOOK=https://facebook.com/almaghribschool
```

### Third-Party Services

#### Mailchimp (Newsletter)

```env
MAILCHIMP_API_KEY=your_mailchimp_api_key
MAILCHIMP_LIST_ID=your_mailchimp_list_id
```

#### Google Analytics & Tag Manager

```env
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
GOOGLE_TAG_MANAGER_ID=GTM-XXXXXXX
```

### Cache Configuration

```env
CACHE_STORE=redis  # or 'file' if Redis is not available
CACHE_PREFIX=almaghrib_school
```

### Session Configuration

```env
SESSION_DRIVER=redis  # or 'database' if Redis is not available
SESSION_LIFETIME=120
```

### Error Tracking (Sentry)

```env
SENTRY_LARAVEL_DSN=https://your-dsn@sentry.io/project-id
SENTRY_TRACES_SAMPLE_RATE=1.0
SENTRY_PROFILES_SAMPLE_RATE=1.0
SENTRY_RELEASE=
SENTRY_ENVIRONMENT=production
```

### Log Aggregation

```env
LOG_CHANNEL=stack
LOG_STACK=single,sentry
LOG_LEVEL=error
LOG_DAILY_DAYS=14

# Optional: Papertrail
PAPERTRAIL_URL=
PAPERTRAIL_PORT=

# Optional: Slack
LOG_SLACK_WEBHOOK_URL=
LOG_SLACK_USERNAME="Laravel Log"
```

## Optional Configuration

### Search (Laravel Scout)

If using Meilisearch:
```env
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=your_master_key
```

If using Algolia:
```env
SCOUT_DRIVER=algolia
ALGOLIA_APP_ID=your_app_id
ALGOLIA_SECRET=your_secret
```

### Logging

```env
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error  # or 'debug' for development
```

## Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate and set `APP_KEY`
- [ ] Configure production database credentials
- [ ] Configure SMTP email settings
- [ ] Set up Redis for queues and caching
- [ ] Configure S3 or local storage
- [ ] Set up Mailchimp API credentials
- [ ] Add Google Analytics and Tag Manager IDs
- [ ] Update school contact information
- [ ] Configure SSL/HTTPS
- [ ] Set up queue workers (Supervisor/systemd)
- [ ] Configure scheduled tasks (cron)
- [ ] Set up backups
- [ ] Configure monitoring

## Development Configuration

For local development, you can use:
- `APP_ENV=local`
- `APP_DEBUG=true`
- `MAIL_MAILER=log` (emails will be logged instead of sent)
- `QUEUE_CONNECTION=sync` (jobs run immediately)
- `CACHE_STORE=file`
- `SESSION_DRIVER=file`

## Security Notes

- Never commit `.env` file to version control
- Use strong passwords for database and email
- Rotate API keys regularly
- Use environment-specific configurations
- Enable SSL/HTTPS in production
- Use secure session and cookie settings

