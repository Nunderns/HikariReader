<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make the first user an admin
        $user = User::first();
        if ($user) {
            $user->is_admin = true;
            $user->save();
            $this->command->info('First user has been granted admin privileges.');
        } else {
            $this->command->warn('No users found to make admin.');
        }
    }
}
