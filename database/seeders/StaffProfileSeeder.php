<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffProfile;

class StaffProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Use existing images found in storage/app/public/staff
        // I picked 3 filenames that looked valid from the directory listing.
        // Assuming these are valid image files.
        $images = [
            'staff/43zdvZvw11fx0SnyhgWmPmsrC8VUd7BOD4BqFwdR.jpg',
            'staff/5zXYzZsgZpfQtTWqQtKdRIuIyswZqtNidnTOxrqC.jpg',
            'staff/7BFFCGnPwZtotkyDQGdlF3vUKIaeVXPdRdgGyaex.jpg',
        ];

        $staffMembers = [
            [
                'name' => 'Nash Roxas',
                'role_text' => 'Head Librarian',
                'bio' => 'Over 20 years of experience in library sciences. Dedicated to community outreach.',
                'image' => $images[0],
                'sort_order' => 1,
            ],
            [
                'name' => 'Kart Mendoza',
                'role_text' => 'Assistant Librarian',
                'bio' => 'Passionate about digital archiving and modernizing library systems.',
                'image' => $images[1],
                'sort_order' => 2,
            ],
            [
                'name' => 'Ahron Valenzuela',
                'role_text' => 'Archivist',
                'bio' => 'Expert in historical manuscripts and preservation techniques.',
                'image' => $images[2],
                'sort_order' => 3,
            ],
        ];

        foreach ($staffMembers as $staff) {
            StaffProfile::firstOrCreate(
                ['name' => $staff['name']], // Check by name to avoid duplicates
                $staff
            );
        }
    }
}
