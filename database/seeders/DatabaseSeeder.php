<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Avoid inserting duplicate users
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user'
            ]
        );

        for ($i = 1; $i <= 10; $i++) {
            User::firstOrCreate(
                ['email' => "user$i@example.com"],
                [
                    'name' => "User $i",
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }

        $this->call(AdminUserSeeder::class);
    }

    
    
}
