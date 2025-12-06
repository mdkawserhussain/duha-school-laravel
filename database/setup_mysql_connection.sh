#!/bin/bash

echo "=== MySQL Setup Helper ==="
echo ""
echo "This script will help you set up MySQL for the migration."
echo ""

# Check if MySQL is running
if ! systemctl is-active --quiet mysql 2>/dev/null && ! systemctl is-active --quiet mysqld 2>/dev/null; then
    echo "⚠ MySQL service might not be running."
    echo "   Try: sudo systemctl start mysql"
    echo ""
fi

echo "Choose an option:"
echo "1. Set password for root user (recommended)"
echo "2. Create new MySQL user for application"
echo "3. Test current MySQL connection"
echo ""
read -p "Enter choice (1-3): " choice

case $choice in
    1)
        echo ""
        echo "You'll need to run these MySQL commands:"
        echo ""
        echo "sudo mysql -u root"
        echo ""
        echo "Then in MySQL:"
        echo "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_password';"
        echo "FLUSH PRIVILEGES;"
        echo "CREATE DATABASE IF NOT EXISTS duha_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        echo "EXIT;"
        echo ""
        echo "Then update .env with: DB_PASSWORD=your_password"
        ;;
    2)
        echo ""
        read -p "Enter new username (e.g., duha_user): " username
        read -sp "Enter password: " password
        echo ""
        echo ""
        echo "Run these MySQL commands:"
        echo ""
        echo "sudo mysql -u root"
        echo ""
        echo "Then in MySQL:"
        echo "CREATE DATABASE IF NOT EXISTS duha_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        echo "CREATE USER '${username}'@'localhost' IDENTIFIED BY '${password}';"
        echo "GRANT ALL PRIVILEGES ON duha_school.* TO '${username}'@'localhost';"
        echo "FLUSH PRIVILEGES;"
        echo "EXIT;"
        echo ""
        echo "Then update .env with:"
        echo "DB_USERNAME=${username}"
        echo "DB_PASSWORD=${password}"
        ;;
    3)
        echo ""
        echo "Testing MySQL connection..."
        php artisan config:clear
        php artisan tinker --execute="try { DB::connection('mysql')->select('SELECT 1'); echo '✓ MySQL connection successful!'; } catch (\Exception \$e) { echo '✗ MySQL connection failed: ' . \$e->getMessage(); }"
        ;;
    *)
        echo "Invalid choice"
        ;;
esac

