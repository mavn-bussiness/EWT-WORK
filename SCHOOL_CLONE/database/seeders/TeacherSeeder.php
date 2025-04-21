<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Optional: if you want to truncate
use App\Models\User;       // Make sure your User model is in App\Models
use App\Models\Teacher;    // Make sure your Teacher model is in App\Models
use Carbon\Carbon;         // For handling dates
use phpDocumentor\Reflection\Types\Boolean;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Truncate the table before seeding
        // Be cautious using truncate if you have foreign key constraints
        // Teacher::query()->delete(); // Alternative: Delete existing teachers

        // --- Find existing Users with the 'teacher' role ---
        // It's crucial that UserSeeder runs first to create these users.
        $teacherUsers = User::where('role', 'teacher')->limit(4)->get();

        if ($teacherUsers->count() < 4) {
            $this->command->warn('Could not find 4 users with the role "teacher" to seed. Found: ' . $teacherUsers->count());
            // You might want to create missing users here or stop seeding.
            // For this example, we'll seed only for the users found.
             if ($teacherUsers->isEmpty()) {
                 $this->command->error('No teacher users found. Please run UserSeeder first or ensure users with role "teacher" exist.');
                 return; // Stop seeding if no teacher users are found
             }
        }

        $this->command->info('Found ' . $teacherUsers->count() . ' teacher users. Creating teacher profiles...');

        // --- Create Teacher Records ---
        $staffIdCounter = 1001; // Starting staff ID, ensure uniqueness

        foreach ($teacherUsers as $index => $user) {
            // Generate unique staff ID
            $staffId = 'TCH' . $staffIdCounter++;

            // Sample data - customize as needed
            $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'History', 'Geography', 'Art'];
            $qualifications = ['B.Ed', 'M.Sc', 'B.A.', 'PhD', 'Diploma in Education'];
            $phonePrefixes = ['070', '071', '075', '077', '078', '079'];


            Teacher::create([
                'user_id' => $user->id, // Link to the User record
                'staffId' => $staffId, // Unique staff ID
                'subject' => $subjects[array_rand($subjects)], // Assign a random subject
                'qualification' => $qualifications[array_rand($qualifications)], // Assign random qualification
                'phoneNumber' => $phonePrefixes[array_rand($phonePrefixes)] . random_int(1000000, 9999999), // Generate sample phone
                'employment_date' => Carbon::now()->subYears(rand(1, 10))->subMonths(rand(0, 11))->subDays(rand(0, 28))->toDateString(),
                'is_dos'=>'false' // Random past date
                // 'created_at' and 'updated_at' are handled automatically
            ]);

             $this->command->info("Created teacher profile for user: {$user->firstName} {$user->lastName} (ID: {$user->id}) with Staff ID: {$staffId}");
        }

        // --- Using Factories (Recommended for more complex/random data) ---
        // If you have a TeacherFactory defined:
        //
        // foreach ($teacherUsers as $user) {
        //     Teacher::factory()->create([
        //         'user_id' => $user->id,
        //         // Factory can handle random data generation for other fields
        //     ]);
        // }
    }
}