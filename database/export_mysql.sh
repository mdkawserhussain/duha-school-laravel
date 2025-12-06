#!/bin/bash

# MySQL Database Export Script
# Exports the duha_school database to a SQL file

# Get database credentials from .env
ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    echo "Error: .env file not found!"
    exit 1
fi

DB_NAME=$(grep "^DB_DATABASE=" "$ENV_FILE" | cut -d'=' -f2 | tr -d '"' | tr -d "'")
DB_USER=$(grep "^DB_USERNAME=" "$ENV_FILE" | cut -d'=' -f2 | tr -d '"' | tr -d "'")
DB_PASSWORD=$(grep "^DB_PASSWORD=" "$ENV_FILE" | cut -d'=' -f2 | tr -d '"' | tr -d "'")
DB_HOST=$(grep "^DB_HOST=" "$ENV_FILE" | cut -d'=' -f2 | tr -d '"' | tr -d "'" | head -1)

# Default values if not found
DB_NAME=${DB_NAME:-duha_school}
DB_USER=${DB_USER:-root}
DB_HOST=${DB_HOST:-127.0.0.1}

# Generate filename with timestamp
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
EXPORT_FILE="database/${DB_NAME}_export_${TIMESTAMP}.sql"

echo "=== MySQL Database Export ==="
echo "Database: $DB_NAME"
echo "User: $DB_USER"
echo "Host: $DB_HOST"
echo "Export file: $EXPORT_FILE"
echo ""

# Export database
if [ -z "$DB_PASSWORD" ]; then
    echo "Exporting without password..."
    mysqldump -h "$DB_HOST" -u "$DB_USER" "$DB_NAME" > "$EXPORT_FILE" 2>&1
else
    echo "Exporting with password..."
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$EXPORT_FILE" 2>&1
fi

# Check if export was successful
if [ $? -eq 0 ] && [ -f "$EXPORT_FILE" ] && [ -s "$EXPORT_FILE" ]; then
    FILE_SIZE=$(du -h "$EXPORT_FILE" | cut -f1)
    LINE_COUNT=$(wc -l < "$EXPORT_FILE")
    echo ""
    echo "✓ Export completed successfully!"
    echo "  File: $EXPORT_FILE"
    echo "  Size: $FILE_SIZE"
    echo "  Lines: $LINE_COUNT"
    echo ""
    echo "To restore this backup:"
    echo "  mysql -u $DB_USER -p $DB_NAME < $EXPORT_FILE"
else
    echo ""
    echo "✗ Export failed!"
    echo "Check the error messages above."
    exit 1
fi

