<?php

// Database configuration - update these values as needed
$config = [
    'driver' => 'mysql',  // or 'sqlite'
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'HikariReader',
    'username' => 'root',
    'password' => '',
    'sqlite_path' => '/home/hkokayama/Documentos/Projetos/Laravel/HikariReader/database/database.sqlite',
];

function testMysqlConnection($config) {
    try {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        echo "✅ Successfully connected to MySQL database!\n";
        
        // List tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "\nTables in database:\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
        
        return true;
    } catch (PDOException $e) {
        echo "❌ MySQL Connection failed: " . $e->getMessage() . "\n";
        return false;
    }
}

function testSqliteConnection($path) {
    try {
        if (!file_exists($path)) {
            echo "SQLite database file does not exist: $path\n";
            if (!is_writable(dirname($path))) {
                echo "Directory is not writable: " . dirname($path) . "\n";
            }
            return false;
        }
        
        $pdo = new PDO("sqlite:" . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ Successfully connected to SQLite database!\n";
        
        // List tables
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "\nTables in database:\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
        
        return true;
    } catch (PDOException $e) {
        echo "❌ SQLite Connection failed: " . $e->getMessage() . "\n";
        return false;
    }
}

// Test MySQL connection
echo "=== Testing MySQL Connection ===\n";
$mysqlConnected = testMysqlConnection($config);

// Test SQLite connection
echo "\n=== Testing SQLite Connection ===\n";
$sqliteConnected = testSqliteConnection($config['sqlite_path']);

// Summary
echo "\n=== Summary ===\n";
echo "MySQL: " . ($mysqlConnected ? "✅ Connected" : "❌ Not connected") . "\n";
echo "SQLite: " . ($sqliteConnected ? "✅ Connected" : "❌ Not connected") . "\n";
