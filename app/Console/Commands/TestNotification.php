<?php

namespace App\Console\Commands;

use App\Models\Manga;
use App\Models\User;
use App\Notifications\MangaNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestNotification extends Command
{
    protected $signature = 'notifications:test';
    protected $description = 'Send a test notification to all admin users';

    public function handle()
    {
        // Get a manga for testing
        $manga = Manga::first();
        
        if (!$manga) {
            $this->error('No manga found in the database. Please create a manga first.');
            return 1;
        }
        
        // Get all admin users
        $admins = User::where('is_admin', true)->get();
        
        if ($admins->isEmpty()) {
            $this->error('No admin users found.');
            return 1;
        }
        
        // Send test notification
        Notification::send($admins, new MangaNotification($manga, 'created'));
        
        $this->info('Test notification sent to ' . $admins->count() . ' admin users.');
        return 0;
    }
}
