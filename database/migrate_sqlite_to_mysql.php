// database/migrate_sqlite_to_mysql.php
<?php

/**
 * SQLite to MySQL Migration Script
 * 
 * This script migrates all data from SQLite to MySQL
 * Run: php database/migrate_sqlite_to_mysql.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "=== SQLite to MySQL Migration ===\n\n";

// Step 1: Verify SQLite connection
echo "1. Verifying SQLite connection...\n";
$sqlitePath = database_path('database.sqlite');
if (!file_exists($sqlitePath)) {
    die("   ✗ SQLite database not found at: {$sqlitePath}\n");
}

// Override SQLite config to use the correct database path
Config::set('database.connections.sqlite.database', $sqlitePath);

try {
    DB::connection('sqlite')->select('SELECT 1');
    echo "   ✓ SQLite connection OK\n";
} catch (\Exception $e) {
    die("   ✗ SQLite connection failed: " . $e->getMessage() . "\n");
}

// Step 2: Verify MySQL connection
echo "\n2. Verifying MySQL connection...\n";
try {
    DB::connection('mysql')->select('SELECT 1');
    echo "   ✓ MySQL connection OK\n";
} catch (\Exception $e) {
    die("   ✗ MySQL connection failed: " . $e->getMessage() . "\n   Please check your .env file\n");
}

// Step 3: Get all tables from SQLite
echo "\n3. Discovering tables in SQLite...\n";
$tables = DB::connection('sqlite')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' AND name != 'migrations'");
$tableNames = array_map(fn($t) => $t->name, $tables);

if (empty($tableNames)) {
    echo "   ⚠ No tables found in SQLite database\n";
    echo "   Proceeding to create tables in MySQL only...\n";
} else {
    echo "   Found " . count($tableNames) . " tables: " . implode(', ', $tableNames) . "\n";
}

// Step 4: Run migrations on MySQL (create table structure)
echo "\n4. Running migrations on MySQL...\n";
try {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
    echo "   ✓ Migrations completed - tables created in MySQL\n";
} catch (\Exception $e) {
    echo "   ⚠ Warning: " . $e->getMessage() . "\n";
    echo "   Continuing with data migration...\n";
}

// Step 5: Migrate data table by table
if (!empty($tableNames)) {
    echo "\n5. Migrating data from SQLite to MySQL...\n";

    DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=0');
    DB::connection('mysql')->statement('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');

    $totalRows = 0;
    $errors = [];

    foreach ($tableNames as $table) {
        try {
            // Check if table exists in MySQL
            $exists = DB::connection('mysql')->select("SHOW TABLES LIKE '{$table}'");
            if (empty($exists)) {
                echo "   ⚠ Table '{$table}' does not exist in MySQL, skipping...\n";
                continue;
            }

            // Get row count from SQLite
            $rowCount = DB::connection('sqlite')->table($table)->count();
            
            if ($rowCount === 0) {
                echo "   - {$table}: No data to migrate\n";
                continue;
            }

            // Get all data from SQLite
            $data = DB::connection('sqlite')->table($table)->get();
            
            // Clear existing data in MySQL
            DB::connection('mysql')->table($table)->truncate();
            
            // Insert data in chunks to avoid memory issues
            $chunkSize = 100;
            $inserted = 0;
            
            foreach ($data->chunk($chunkSize) as $chunk) {
                $insertData = $chunk->map(function($item) {
                    $array = (array) $item;
                    // Convert empty strings to null for nullable fields
                    foreach ($array as $key => $value) {
                        if ($value === '') {
                            $array[$key] = null;
                        }
                    }
                    return $array;
                })->toArray();
                
                DB::connection('mysql')->table($table)->insert($insertData);
                $inserted += count($insertData);
            }
            
            $totalRows += $inserted;
            echo "   ✓ {$table}: {$inserted} rows migrated\n";
            
        } catch (\Exception $e) {
            $errorMsg = "   ✗ {$table}: Error - " . $e->getMessage();
            echo $errorMsg . "\n";
            $errors[] = $errorMsg;
        }
    }

    DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=1');

    // Step 6: Reset auto-increment values
    echo "\n6. Resetting auto-increment values...\n";
    foreach ($tableNames as $table) {
        try {
            $maxId = DB::connection('mysql')->table($table)->max('id');
            if ($maxId !== null && $maxId !== '') {
                $maxId = (int) $maxId;
                if ($maxId > 0) {
                    DB::connection('mysql')->statement("ALTER TABLE `{$table}` AUTO_INCREMENT = " . ($maxId + 1));
                }
            }
        } catch (\Exception $e) {
            // Ignore errors for tables without id column or auto-increment
        }
    }
    echo "   ✓ Auto-increment values reset\n";

    // Step 7: Summary
    echo "\n=== Migration Summary ===\n";
    echo "Total rows migrated: {$totalRows}\n";

    if (!empty($errors)) {
        echo "\n⚠ Errors encountered:\n";
        foreach ($errors as $error) {
            echo "  {$error}\n";
        }
    } else {
        echo "\n✓ Migration completed successfully!\n";
    }
} else {
    echo "\n✓ Tables created in MySQL (no data to migrate)\n";
}

echo "\nNext steps:\n";
echo "1. Verify data: php artisan tinker\n";
echo "2. Test application: php artisan serve\n";
echo "3. Clear caches: php artisan config:clear && php artisan cache:clear\n";