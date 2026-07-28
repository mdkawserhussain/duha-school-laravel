#!/bin/bash

set -e

# Configuration
BACKUP_DIR="${BACKUP_DIR:-./backups}"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="${DB_DATABASE:-duha_school}"
DB_USER="${DB_USERNAME:-root}"
DB_PASS="${DB_PASSWORD:-root}"

echo "💾 Creating backup..."

# Create backup directory
mkdir -p "$BACKUP_DIR"

# Database backup
echo "📦 Backing up database..."
if command -v mysqldump &> /dev/null; then
    mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/database_$DATE.sql"
    echo "✅ Database backup created: $BACKUP_DIR/database_$DATE.sql"
else
    echo "⚠️  mysqldump not found, skipping database backup"
fi

# Storage backup
echo "📦 Backing up storage..."
if [ -d storage/app ]; then
    tar -czf "$BACKUP_DIR/storage_$DATE.tar.gz" storage/app
    echo "✅ Storage backup created: $BACKUP_DIR/storage_$DATE.tar.gz"
fi

# Cleanup old backups (keep last 7 days)
echo "🧹 Cleaning up old backups..."
find "$BACKUP_DIR" -name "database_*.sql" -mtime +7 -delete
find "$BACKUP_DIR" -name "storage_*.tar.gz" -mtime +7 -delete

echo "✅ Backup complete!"
echo "📁 Backup location: $BACKUP_DIR"

