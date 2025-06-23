<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_super_admin' => true,
            ]
        );

        for ($i = 1; $i <= 7; $i++) {
            User::firstOrCreate(
                ['email' => "admin$i@example.com"],
                [
                    'name' => "Admin $i",
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_super_admin' => false,
                ]
            );
        }
    }
}
