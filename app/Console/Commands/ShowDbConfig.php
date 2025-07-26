<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ShowDbConfig extends Command
{
    protected $signature = 'db:show-config';
    protected $description = 'Show the current database configuration';

    /**
     * Displays the current database configuration and related environment variables in the console.
     *
     * Outputs the default database connection name, its configuration details (driver, host, port, database, username), and the corresponding environment variables. The database password is masked for security. Returns 0 upon successful execution.
     *
     * @return int Exit code 0 on success.
     */
    public function handle()
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");
        
        $this->info("Current Database Configuration:");
        $this->line('');
        $this->line("<comment>Default Connection:</comment> {$connection}");
        
        $this->line("\n<comment>Connection Details:</comment>");
        $this->line("  - Driver: " . ($config['driver'] ?? 'N/A'));
        $this->line("  - Host: " . ($config['host'] ?? 'N/A'));
        $this->line("  - Port: " . ($config['port'] ?? 'N/A'));
        $this->line("  - Database: " . ($config['database'] ?? 'N/A'));
        $this->line("  - Username: " . ($config['username'] ?? 'N/A'));
        
        // Show environment variables
        $this->line("\n<comment>Environment Variables:</comment>");
        $this->line("  - DB_CONNECTION: " . env('DB_CONNECTION', 'not set'));
        $this->line("  - DB_DATABASE: " . env('DB_DATABASE', 'not set'));
        $this->line("  - DB_HOST: " . env('DB_HOST', 'not set'));
        $this->line("  - DB_PORT: " . env('DB_PORT', 'not set'));
        $this->line("  - DB_USERNAME: " . env('DB_USERNAME', 'not set'));
        $this->line("  - DB_PASSWORD: " . (env('DB_PASSWORD') ? '***' : 'not set'));
        
        return 0;
    }
}
