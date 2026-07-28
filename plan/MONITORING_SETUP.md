# Monitoring and Error Tracking Setup Guide

This guide explains how to set up monitoring, error tracking, and log aggregation for the Al-Maghrib International School application.

## Overview

The application includes support for:
- **Error Tracking**: Sentry for real-time error monitoring
- **Uptime Monitoring**: UptimeRobot for website availability monitoring
- **Performance Monitoring**: Laravel built-in performance tracking
- **Log Aggregation**: Centralized logging configuration

## 1. Error Tracking with Sentry

### Installation

Sentry is already installed via Composer. To complete setup:

1. **Sign up for Sentry** at [sentry.io](https://sentry.io) (free tier available)

2. **Create a new project** in Sentry:
   - Select "Laravel" as the platform
   - Copy your DSN (Data Source Name)

3. **Configure in `.env`**:
   ```env
   SENTRY_LARAVEL_DSN=https://your-dsn@sentry.io/project-id
   SENTRY_TRACES_SAMPLE_RATE=1.0
   SENTRY_PROFILES_SAMPLE_RATE=1.0
   ```

4. **Publish configuration** (already done):
   ```bash
   php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
   ```

5. **Test Sentry**:
   ```bash
   php artisan tinker
   >>> \Sentry\captureMessage('Test message from Laravel');
   ```

### Configuration

The Sentry configuration file is located at `config/sentry.php`. Key settings:

- **DSN**: Your Sentry project DSN
- **Environment**: Automatically set from `APP_ENV`
- **Release**: Automatically set from `APP_VERSION` or git commit
- **Traces Sample Rate**: Percentage of transactions to trace (0.0 to 1.0)
- **Profiles Sample Rate**: Percentage of transactions to profile

### Features

- **Automatic Error Capture**: All exceptions are automatically sent to Sentry
- **User Context**: User information is automatically attached to errors
- **Breadcrumbs**: Request, query, and log breadcrumbs are captured
- **Performance Monitoring**: Slow queries and requests are tracked
- **Release Tracking**: Track errors by application version

### Custom Error Reporting

You can manually report errors:

```php
use Sentry\State\Scope;

\Sentry\configureScope(function (Scope $scope): void {
    $scope->setTag('custom_tag', 'value');
    $scope->setContext('custom', [
        'key' => 'value',
    ]);
});

\Sentry\captureException($exception);
```

## 2. Uptime Monitoring with UptimeRobot

UptimeRobot is an external service that monitors your website's availability.

### Setup Instructions

1. **Sign up** at [uptimerobot.com](https://uptimerobot.com) (free tier: 50 monitors)

2. **Add a new monitor**:
   - **Monitor Type**: HTTP(s)
   - **Friendly Name**: Al-Maghrib School Website
   - **URL**: `https://your-domain.com`
   - **Monitoring Interval**: 5 minutes (free) or 1 minute (paid)
   - **Alert Contacts**: Add your email/SMS/Slack

3. **Recommended Monitors**:
   - **Homepage**: `https://your-domain.com`
   - **Health Check**: `https://your-domain.com/up` (Laravel health endpoint)
   - **Admin Panel**: `https://your-domain.com/admin` (if public)
   - **API Status**: `https://your-domain.com/api/health` (if applicable)

4. **Alert Settings**:
   - Set up email alerts for downtime
   - Configure SMS alerts for critical downtime
   - Set up Slack/Teams integration for team notifications

### Health Check Endpoint

Laravel includes a built-in health check endpoint at `/up`. This endpoint:
- Returns 200 OK if the application is healthy
- Returns 503 if there are issues
- Can be customized in `routes/web.php` or via middleware

## 3. Performance Monitoring

### Laravel Built-in Performance Tracking

Laravel provides several built-in performance monitoring tools:

#### 1. Query Logging

Enable query logging in development:

```php
DB::enableQueryLog();
// Your code
$queries = DB::getQueryLog();
```

#### 2. Request Timing

Add timing middleware:

```php
// In AppServiceProvider
public function boot()
{
    if (config('app.debug')) {
        DB::listen(function ($query) {
            Log::info('Query Time: ' . $query->time . 'ms', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
            ]);
        });
    }
}
```

#### 3. Laravel Telescope (Optional)

For detailed performance monitoring, install Laravel Telescope:

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Access at `/telescope` (requires authentication).

### Application Performance Monitoring (APM)

For production, consider:
- **New Relic**: Full-stack APM
- **Datadog**: Infrastructure and application monitoring
- **Sentry Performance**: Included with Sentry (already configured)

## 4. Log Aggregation

### Log Configuration

Laravel's logging is configured in `config/logging.php`. The default stack includes:
- **Single**: Single log file
- **Daily**: Daily log files
- **Slack**: Send logs to Slack
- **Papertrail**: Send logs to Papertrail
- **Syslog**: System logging
- **Errorlog**: PHP error log

### Recommended Setup

#### Development
```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'stdout'],
    ],
],
```

#### Production
```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'sentry'],
    ],
],
```

### External Log Aggregation Services

#### Option 1: Papertrail

1. Sign up at [papertrailapp.com](https://papertrailapp.com)
2. Configure in `.env`:
   ```env
   PAPERTRAIL_URL=logs.papertrailapp.com:12345
   ```
3. Add to `config/logging.php`:
   ```php
   'papertrail' => [
       'driver' => 'monolog',
       'level' => env('LOG_LEVEL', 'debug'),
       'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
       'handler_with' => [
           'host' => env('PAPERTRAIL_URL'),
           'port' => env('PAPERTRAIL_PORT', 12345),
           'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
       ],
   ],
   ```

#### Option 2: Loggly

1. Sign up at [loggly.com](https://www.loggly.com)
2. Install package:
   ```bash
   composer require monolog/monolog
   ```
3. Configure in `config/logging.php`

#### Option 3: CloudWatch (AWS)

If using AWS:
1. Create CloudWatch Log Group
2. Install AWS SDK:
   ```bash
   composer require aws/aws-sdk-php
   ```
3. Configure in `config/logging.php`

### Log Rotation

Laravel automatically rotates daily logs. For manual rotation:

```bash
# Rotate logs manually
php artisan log:clear
```

## 5. Monitoring Dashboard

### Recommended Setup

1. **Sentry Dashboard**: Error tracking and performance
2. **UptimeRobot Dashboard**: Uptime monitoring
3. **Laravel Horizon**: Queue monitoring (already installed)
4. **Server Monitoring**: Use your hosting provider's tools (DigitalOcean, AWS, etc.)

### Custom Monitoring Endpoint

Create a custom health check endpoint:

```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::get('health-check') !== null ? 'working' : 'not working',
    ]);
});
```

## 6. Alert Configuration

### Sentry Alerts

1. Go to Sentry project settings
2. Navigate to Alerts
3. Create alert rules:
   - **Error Rate**: Alert if error rate exceeds threshold
   - **New Issues**: Alert on new error types
   - **Performance**: Alert on slow transactions

### UptimeRobot Alerts

1. Configure alert contacts in UptimeRobot
2. Set up alert escalation
3. Configure maintenance windows

## 7. Best Practices

1. **Don't log sensitive data**: Never log passwords, tokens, or PII
2. **Use appropriate log levels**: Use `debug`, `info`, `warning`, `error`, `critical`
3. **Monitor error rates**: Set up alerts for unusual error spikes
4. **Review logs regularly**: Check logs weekly for patterns
5. **Set up log retention**: Configure log retention policies
6. **Test monitoring**: Regularly test that alerts are working

## 8. Production Checklist

- [ ] Sentry DSN configured
- [ ] UptimeRobot monitors set up
- [ ] Log aggregation configured
- [ ] Alert contacts configured
- [ ] Health check endpoint tested
- [ ] Performance monitoring enabled
- [ ] Log retention policy set
- [ ] Monitoring dashboards accessible
- [ ] Team notified of monitoring setup

## Additional Resources

- [Sentry Laravel Documentation](https://docs.sentry.io/platforms/php/guides/laravel/)
- [UptimeRobot Documentation](https://uptimerobot.com/api/)
- [Laravel Logging Documentation](https://laravel.com/docs/logging)
- [Laravel Telescope Documentation](https://laravel.com/docs/telescope)

