<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TestDbConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the database connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");
        
        $this->info("Testing database connection: {$connection}");
        $this->line('');
        
        $this->info('Configuration:');
        $this->line('- Driver: ' . ($config['driver'] ?? 'N/A'));
        $this->line('- Host: ' . ($config['host'] ?? 'N/A'));
        $this->line('- Port: ' . ($config['port'] ?? 'N/A'));
        $this->line('- Database: ' . ($config['database'] ?? 'N/A'));
        $this->line('- Username: ' . ($config['username'] ?? 'N/A'));
        
        $this->line('');
        $this->info('Attempting to connect...');
        
        try {
            DB::connection()->getPdo();
            $this->info('✅ Successfully connected to the database!');
            $this->info('Database name: ' . DB::connection()->getDatabaseName());
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Could not connect to the database.');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
