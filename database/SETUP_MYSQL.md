# MySQL Setup Guide

## Step 1: Create MySQL Database

### Option A: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE duha_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Create user (optional, or use root)
CREATE USER 'duha_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON duha_school.* TO 'duha_user'@'localhost';
FLUSH PRIVILEGES;

# Exit MySQL
EXIT;
```

### Option B: Using phpMyAdmin

1. Open phpMyAdmin (usually `http://localhost/phpmyadmin`)
2. Click "New" to create database
3. Name: `duha_school`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

## Step 2: Update .env File

Your `.env` file has been updated with MySQL configuration. Please verify and update these values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=duha_school
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

**Important**: Update `DB_PASSWORD` with your actual MySQL root password (or the password for the user you created).

## Step 3: Test MySQL Connection

```bash
php artisan tinker
```

Then in Tinker:
```php
DB::connection('mysql')->select('SELECT 1');
// Should return: [{"1":1}]
```

## Step 4: Run Migration Script

Once MySQL is set up and connected, run the migration script:

```bash
php database/migrate_sqlite_to_mysql.php
```

This will:
- Create all tables in MySQL
- Migrate all data from SQLite to MySQL
- Reset auto-increment values

## Step 5: Verify Migration

```bash
php artisan tinker
```

Check row counts:
```php
DB::table('users')->count();
DB::table('events')->count();
DB::table('notices')->count();
// ... etc
```

## Troubleshooting

### "Access denied for user"
- Check MySQL username and password in `.env`
- Verify MySQL service is running: `sudo systemctl status mysql` (Linux) or check MySQL service in Windows

### "Unknown database 'duha_school'"
- Create the database first (see Step 1)

### "Connection refused"
- Check MySQL is running
- Verify `DB_HOST` is correct (usually `127.0.0.1` or `localhost`)

