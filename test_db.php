<?php

require __DIR__.'/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get database configuration
$config = [
    'driver' => env('DB_CONNECTION', 'mysql'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
];

// Display configuration
echo "Testing database connection...\n";
echo "Driver: " . $config['driver'] . "\n";
echo "Host: " . $config['host'] . "\n";
echo "Port: " . $config['port'] . "\n";
echo "Database: " . $config['database'] . "\n";
echo "Username: " . $config['username'] . "\n";
echo "Password: " . ($config['password'] ? '***' : 'not set') . "\n\n";

// Test connection
try {
    if ($config['driver'] === 'mysql') {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Successfully connected to MySQL database!\n";
        
        // Check if tables exist
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "\nTables in database:\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    } else if ($config['driver'] === 'sqlite') {
        $path = $config['database'];
        if ($path === ':memory:' || !file_exists($path)) {
            echo "SQLite database file does not exist: $path\n";
            if (!is_writable(dirname($path))) {
                echo "Directory is not writable: " . dirname($path) . "\n";
            }
        } else {
            $pdo = new PDO("sqlite:" . $path);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✅ Successfully connected to SQLite database!\n";
            
            // Check if tables exist
            $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
            echo "\nTables in database:\n";
            foreach ($tables as $table) {
                echo "- $table\n";
            }
        }
    } else {
        echo "Unsupported database driver: " . $config['driver'] . "\n";
    }
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
}
