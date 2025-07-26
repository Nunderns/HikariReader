<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeds the application's database by ensuring an admin user exists and running additional seeders.
     *
     * Creates an admin user with a default email and password if one does not already exist, then executes the `AdminUserSeeder` and `GenreSeeder` to populate related data.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'is_admin' => true,
                'password' => bcrypt('password'),
            ]
        );

        // Run the seeders
        $this->call([
            AdminUserSeeder::class,
            GenreSeeder::class,
        ]);
    }
}
