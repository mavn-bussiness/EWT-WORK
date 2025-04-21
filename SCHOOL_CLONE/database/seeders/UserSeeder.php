<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Optional: if you want to truncate
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure your User model is in App\Models

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Truncate the table before seeding
        // Useful during development to start fresh
        // Be cautious using truncate if you have foreign key constraints
        // Schema::disableForeignKeyConstraints(); // Temporarily disable if needed
        // DB::table('users')->truncate();
        // Schema::enableForeignKeyConstraints(); // Re-enable if needed

        // Or delete existing users (respects model events like deleting related data)

        // --- Create Sample Users ---

       

        User::create([
            'firstName' => 'Sample',
            'lastName' => 'Teacher',
            'otherName' => null,
            'email' => 'teacher@example.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);
        User::create([
            'firstName' => 'Kikoyo',
            'lastName' => 'David',
            'otherName' => null,
            'email' => 'kikoyo@example.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);
        User::create([
            'firstName' => 'arnold',
            'lastName' => 'Rwemiti',
            'otherName' => null,
            'email' => 'rwemiti@example.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);
        User::create([
            'firstName' => 'Ntambi',
            'lastName' => 'Nassim',
            'otherName' => null,
            'email' => 'nassim@example.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);
        User::create([
            'firstName' => 'Bukayo',
            'lastName' => 'saka',
            'otherName' => null,
            'email' => 'A@example.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);

         User::create([
            'firstName' => 'Test',
            'lastName' => 'Student',
            'otherName' => 'Q',
            'email' => 'student@example.com',
            'role' => 'student',
            'email_verified_at' => null, // Example of not verified
            // Note: Your migration allows nullable password.
            // Depending on your logic, you might seed null or a password.
            // Seeding with a password is often useful for testing login.
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);

        User::create([
            'firstName' => 'John',
            'lastName' => 'Parent',
            'otherName' => null,
            'email' => 'parent@example.com',
            'role' => 'parent',
            'email_verified_at' => now(),
             // Assuming parents might not need a direct login password initially
            'password' => null,
            'profile_photo' => null,
            'is_active' => true,
        ]);

        // Add more users for other roles (bursar, dos, librarian) as needed...
        User::create([
            'firstName' => 'Finance',
            'lastName' => 'Bursar',
            'otherName' => null,
            'email' => 'bursar@example.com',
            'role' => 'bursar',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'profile_photo' => null,
            'is_active' => true,
        ]);

        // --- Using Factories (Recommended for more data) ---
        // If you have a UserFactory defined (php artisan make:factory UserFactory)
        // you can generate users more efficiently:
        //
        // User::factory()->count(10)->create(); // Creates 10 random users
        //
        // User::factory()->create([ // Creates one user with specific attributes
        //     'firstName' => 'Specific',
        //     'lastName' => 'User',
        //     'email' => 'specific@example.com',
        //     'role' => 'librarian',
        // ]);

    }
}