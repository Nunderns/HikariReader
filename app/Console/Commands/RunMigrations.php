<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunMigrations extends Command
{
    protected $signature = 'app:run-migrations';
    protected $description = 'Run database migrations with the correct connection';

    public function handle()
    {
        $this->info('Running migrations...');
        
        // Set the database connection to mysql
        config(['database.default' => 'mysql']);
        
        // Run the migrations
        $exitCode = Artisan::call('migrate', [
            '--force' => true,
        ]);
        
        if ($exitCode === 0) {
            $this->info('Migrations completed successfully.');
            return 0;
        } else {
            $this->error('Migrations failed.');
            return 1;
        }
    }
}
