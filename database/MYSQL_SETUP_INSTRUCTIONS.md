# MySQL Setup Instructions

## Current Issue
Your MySQL connection is failing because the root user requires a password, but `.env` has an empty `DB_PASSWORD`.

## Quick Fix Options

### Option 1: Set Password for Root User (Easiest)

1. **Login to MySQL as root:**
   ```bash
   sudo mysql -u root
   ```

2. **Set password authentication:**
   ```sql
   ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_password';
   FLUSH PRIVILEGES;
   ```

3. **Create database:**
   ```sql
   CREATE DATABASE IF NOT EXISTS duha_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT;
   ```

4. **Update `.env` file:**
   ```env
   DB_PASSWORD=your_password
   ```

5. **Test connection:**
   ```bash
   php artisan config:clear
   php artisan tinker
   ```
   Then in Tinker:
   ```php
   DB::connection('mysql')->select('SELECT 1');
   ```

### Option 2: Create New MySQL User (More Secure)

1. **Login to MySQL:**
   ```bash
   sudo mysql -u root
   ```

2. **Create database and user:**
   ```sql
   CREATE DATABASE IF NOT EXISTS duha_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'duha_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON duha_school.* TO 'duha_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

3. **Update `.env` file:**
   ```env
   DB_USERNAME=duha_user
   DB_PASSWORD=your_secure_password
   ```

4. **Test connection:**
   ```bash
   php artisan config:clear
   php artisan tinker
   ```
   Then in Tinker:
   ```php
   DB::connection('mysql')->select('SELECT 1');
   ```

## After Setup

Once MySQL connection works, run the migration:

```bash
php database/migrate_sqlite_to_mysql.php
```

## Troubleshooting

### "Access denied" error
- Make sure you set the password correctly
- Verify `.env` has the correct password
- Clear config cache: `php artisan config:clear`

### "Unknown database" error
- Create the database: `CREATE DATABASE duha_school;`

### MySQL service not running
```bash
sudo systemctl start mysql
# or
sudo systemctl start mysqld
```

### Check MySQL status
```bash
sudo systemctl status mysql
```

