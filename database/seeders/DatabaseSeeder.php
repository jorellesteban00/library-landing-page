<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Librarian
        User::firstOrCreate(
            ['email' => 'librarian@example.com'],
            [
                'name' => 'Librarian User',
                'password' => bcrypt('password'),
                'role' => 'librarian',
            ]
        );

        // Staff (News)
        User::firstOrCreate(
            ['email' => 'news@example.com'],
            [
                'name' => 'News Staff',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'staff_type' => 'news',
            ]
        );

        // Staff (Books)
        User::firstOrCreate(
            ['email' => 'books@example.com'],
            [
                'name' => 'Book Staff',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'staff_type' => 'books',
            ]
        );

        // Normal User
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );
    }
}
