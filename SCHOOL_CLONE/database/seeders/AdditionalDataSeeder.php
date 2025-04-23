<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdditionalDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        DB::transaction(function () use ($faker) {
            // Fetch existing data seeded by BursarDataSeeder
            $termId = DB::table('terms')->where('name', 'Term 1')->first()->id;
            $studentIds = DB::table('students')->pluck('id')->toArray();
            $bursarUserIds = DB::table('bursars')->pluck('user_id')->toArray();
            $adminUserId = DB::table('users')->where('email', 'admin@school.com')->first()->id;

            // 1. Insert Teachers, Headteacher, and Deans of Students
            $users = [];
            // Teachers
            for ($i = 0; $i < 10; $i++) {
                $userId = DB::table('users')->insertGetId([
                    'firstName' => $faker->firstName,
                    'lastName' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'role' => 'teacher',
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $users[] = ['id' => $userId, 'role' => 'teacher'];
                DB::table('teachers')->insert([
                    'user_id' => $userId,
                    'staffId' => 'TCH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'subject' => $faker->randomElement(['Mathematics', 'English', 'Physics', 'Chemistry', 'Biology']),
                    'qualification' => $faker->randomElement(['B.Ed', 'M.Ed', 'BSc Education']),
                    'phoneNumber' => $faker->phoneNumber,
                    'employment_date' => $faker->dateTimeBetween('2020-01-01', '2025-01-01')->format('Y-m-d'),
                    'is_dos' => $faker->boolean(10),
                    'dos_department' => $faker->boolean(10) ? 'Science' : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // Headteacher
            $headteacherUserId = DB::table('users')->insertGetId([
                'firstName' => 'Head',
                'lastName' => 'Teacher',
                'email' => 'headteacher@school.com',
                'role' => 'headteacher',
                'password' => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $users[] = ['id' => $headteacherUserId, 'role' => 'headteacher'];
            DB::table('headteacher')->insert([
                'user_id' => $headteacherUserId,
                'staffId' => 'HT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'qualification' => 'M.Ed',
                'phoneNumber' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Dean of Students
            $dosUserId = DB::table('users')->insertGetId([
                'firstName' => 'Dean',
                'lastName' => 'Student',
                'email' => 'dos@school.com',
                'role' => 'dos',
                'password' => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $users[] = ['id' => $dosUserId, 'role' => 'dos'];
            DB::table('deans_of_students')->insert([
                'user_id' => $dosUserId,
                'staffId' => 'DOS' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'department' => 'Student Affairs',
                'phoneNumber' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Insert Parents and Parent-Student Relationships
            $parentIds = [];
            for ($i = 0; $i < 15; $i++) {
                $userId = DB::table('users')->insertGetId([
                    'firstName' => $faker->firstName,
                    'lastName' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'role' => 'parent',
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $parentId = DB::table('parents')->insertGetId([
                    'user_id' => $userId,
                    'relationship' => $faker->randomElement(['Father', 'Mother', 'Guardian']),
                    'phoneNumber' => $faker->phoneNumber,
                    'alternativePhoneNumber' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'occupation' => $faker->jobTitle,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $parentIds[] = $parentId;
            }
            // Link students to parents (each student has 1-2 parents)
            foreach ($studentIds as $studentId) {
                $numParents = $faker->numberBetween(1, 2);
                $selectedParents = $faker->randomElements($parentIds, $numParents);
                foreach ($selectedParents as $parentId) {
                    DB::table('parent_student')->insert([
                        'student_id' => $studentId,
                        'parent_id' => $parentId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 3. Insert Classes
            $classIds = [];
            $classLevels = ['S1', 'S2', 'S3', 'S4'];
            $teacherIds = DB::table('teachers')->pluck('id')->toArray();
            foreach ($classLevels as $level) {
                foreach (['A', 'B'] as $stream) {
                    $classId = DB::table('classes')->insertGetId([
                        'name' => $level,
                        'stream' => $stream,
                        'class_teacher_id' => $faker->randomElement($teacherIds),
                        'capacity' => 40,
                        'classroom_location' => "Room {$level}-{$stream}",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $classIds[] = $classId;
                }
            }

            // 4. Insert Class Registrations
            foreach ($studentIds as $studentId) {
                $classId = $faker->randomElement($classIds);
                DB::table('class_registrations')->insert([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'term_id' => $termId,
                    'status' => 'registered',
                    'registration_date' => '2025-01-10',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 5. Insert Subjects
            $subjects = [
                ['name' => 'Mathematics', 'code' => 'MATH', 'category' => 'sciences', 'is_compulsory' => true],
                ['name' => 'English', 'code' => 'ENG', 'category' => 'languages', 'is_compulsory' => true],
                ['name' => 'Physics', 'code' => 'PHY', 'category' => 'sciences', 'is_compulsory' => false],
                ['name' => 'Chemistry', 'code' => 'CHEM', 'category' => 'sciences', 'is_compulsory' => false],
                ['name' => 'Biology', 'code' => 'BIO', 'category' => 'sciences', 'is_compulsory' => false],
                ['name' => 'History', 'code' => 'HIST', 'category' => 'arts', 'is_compulsory' => false],
            ];
            $subjectIds = [];
            foreach ($subjects as $subject) {
                $subjectId = DB::table('subjects')->insertGetId([
                    'name' => $subject['name'],
                    'code' => $subject['code'],
                    'category' => $subject['category'],
                    'is_compulsory' => $subject['is_compulsory'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $subjectIds[$subject['name']] = $subjectId;
            }

            // 6. Insert Teacher-Subject Assignments
            foreach ($teacherIds as $teacherId) {
                $teacher = DB::table('teachers')->where('id', $teacherId)->first();
                $subjectName = $teacher->subject;
                $subjectId = $subjectIds[$subjectName] ?? $faker->randomElement(array_values($subjectIds));
                $assignedClasses = $faker->randomElements($classIds, $faker->numberBetween(1, 3));
                foreach ($assignedClasses as $classId) {
                    DB::table('teacher_subjects')->insert([
                        'teacher_id' => $teacherId,
                        'subject_id' => $subjectId,
                        'class_id' => $classId,
                        'term_id' => $termId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 7. Insert Timetables
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $times = [
                ['start' => '08:00:00', 'end' => '09:00:00'],
                ['start' => '09:00:00', 'end' => '10:00:00'],
                ['start' => '10:30:00', 'end' => '11:30:00'],
                ['start' => '11:30:00', 'end' => '12:30:00'],
                ['start' => '14:00:00', 'end' => '15:00:00'],
            ];
            foreach ($classIds as $classId) {
                foreach ($days as $day) {
                    foreach ($times as $time) {
                        $teacherSubject = DB::table('teacher_subjects')
                            ->where('class_id', $classId)
                            ->inRandomOrder()
                            ->first();
                        if ($teacherSubject) {
                            DB::table('timetables')->insert([
                                'class_id' => $classId,
                                'subject_id' => $teacherSubject->subject_id,
                                'teacher_id' => $teacherSubject->teacher_id,
                                'day' => $day,
                                'start_time' => $time['start'],
                                'end_time' => $time['end'],
                                'term_id' => $termId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }

            // 8. Insert Assessments
            $assessmentIds = [];
            $assessmentTypes = ['test', 'exam', 'assignment'];
            foreach ($classIds as $classId) {
                $classSubjects = DB::table('teacher_subjects')
                    ->where('class_id', $classId)
                    ->pluck('subject_id')
                    ->toArray();
                foreach ($classSubjects as $subjectId) {
                    foreach ($assessmentTypes as $type) {
                        $assessmentId = DB::table('assessments')->insertGetId([
                            'name' => ucfirst($type) . ' - ' . DB::table('subjects')->where('id', $subjectId)->first()->name,
                            'subject_id' => $subjectId,
                            'class_id' => $classId,
                            'term_id' => $termId,
                            'assessment_date' => $faker->dateTimeBetween('2025-02-01', '2025-04-01')->format('Y-m-d'),
                            'max_score' => 100,
                            'type' => $type,
                            'description' => $faker->sentence,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $assessmentIds[] = $assessmentId;
                    }
                }
            }

            // 9. Insert Marks
            foreach ($assessmentIds as $assessmentId) {
                $assessment = DB::table('assessments')->where('id', $assessmentId)->first();
                $classStudents = DB::table('class_registrations')
                    ->where('class_id', $assessment->class_id)
                    ->where('term_id', $termId)
                    ->pluck('student_id')
                    ->toArray();
                $teacherId = DB::table('teacher_subjects')
                    ->where('class_id', $assessment->class_id)
                    ->where('subject_id', $assessment->subject_id)
                    ->first()->teacher_id;
                $teacherUserId = DB::table('teachers')->where('id', $teacherId)->first()->user_id;
                foreach ($classStudents as $studentId) {
                    $score = $faker->numberBetween(40, 100);
                    $grade = $score >= 80 ? 'A' : ($score >= 60 ? 'B' : ($score >= 40 ? 'C' : 'D'));
                    DB::table('marks')->insert([
                        'student_id' => $studentId,
                        'assessment_id' => $assessmentId,
                        'score' => $score,
                        'grade' => $grade,
                        'teacher_remarks' => $faker->sentence,
                        'recorded_by' => $teacherUserId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 10. Insert Attendance
            $dates = [];
            $startDate = Carbon::createFromFormat('Y-m-d', '2025-01-15');
            $endDate = Carbon::createFromFormat('Y-m-d', '2025-04-15');
            while ($startDate->lte($endDate)) {
                if (in_array($startDate->dayOfWeek, [1, 2, 3, 4, 5])) { // Monday to Friday
                    $dates[] = $startDate->format('Y-m-d');
                }
                $startDate->addDay();
            }
            foreach ($classIds as $classId) {
                $classStudents = DB::table('class_registrations')
                    ->where('class_id', $classId)
                    ->where('term_id', $termId)
                    ->pluck('student_id')
                    ->toArray();
                $teacherId = DB::table('classes')->where('id', $classId)->first()->class_teacher_id;
                $teacherUserId = DB::table('teachers')->where('id', $teacherId)->first()->user_id;
                foreach ($classStudents as $studentId) {
                    foreach ($dates as $date) {
                        $status = $faker->randomElement(['present', 'absent', 'late', 'excused']);
                        DB::table('attendance')->insert([
                            'student_id' => $studentId,
                            'class_id' => $classId,
                            'date' => $date,
                            'status' => $status,
                            'remarks' => $status !== 'present' ? $faker->sentence : null,
                            'marked_by' => $teacherUserId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // 11. Insert School Events
            for ($i = 0; $i < 5; $i++) {
                $eventDate = $faker->dateTimeBetween('2025-01-15', '2025-04-15');
                DB::table('school_events')->insert([
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph,
                    'event_date' => $eventDate->format('Y-m-d'),
                    'start_time' => $faker->time('H:i:00'),
                    'end_time' => $faker->time('H:i:00'),
                    'location' => $faker->randomElement(['School Hall', 'Sports Field', 'Library']),
                    'organizer_id' => $faker->randomElement([$adminUserId, $headteacherUserId, $dosUserId]),
                    'is_approved' => $faker->boolean(80),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 12. Insert Announcements
            for ($i = 0; $i < 5; $i++) {
                $publishDate = $faker->dateTimeBetween('2025-01-01', '2025-04-15');
                DB::table('announcements')->insert([
                    'title' => $faker->sentence(3),
                    'content' => $faker->paragraph,
                    'posted_by' => $faker->randomElement([$adminUserId, $headteacherUserId, $dosUserId]),
                    'audience' => $faker->randomElement(['all', 'teachers', 'students', 'parents']),
                    'publish_date' => $publishDate->format('Y-m-d'),
                    'expiry_date' => $faker->dateTimeBetween($publishDate, '2025-12-31')->format('Y-m-d'),
                    'is_active' => $faker->boolean(80),
                    'attachment_path' => $faker->boolean(30) ? '/attachments/announcement_' . $i . '.pdf' : null,
                    'is_circular' => $faker->boolean(20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 13. Insert Scholarships
            foreach ($studentIds as $studentId) {
                if ($faker->boolean(20)) { // 20% chance a student gets a scholarship
                    DB::table('scholarships')->insert([
                        'student_id' => $studentId,
                        'scholarship_name' => $faker->randomElement(['Merit Scholarship', 'Need-Based Scholarship', 'Sports Scholarship']),
                        'sponsor' => $faker->company,
                        'amount' => $faker->randomFloat(2, 100000, 500000),
                        'term_id' => $termId,
                        'type' => $faker->randomElement(['full', 'partial', 'one-time']),
                        'description' => $faker->sentence,
                        'start_date' => '2025-01-15',
                        'end_date' => $faker->randomElement([null, '2025-04-15']),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 14. Insert Staff Reports (Headteacher module)
            for ($i = 0; $i < 10; $i++) {
                $teacherUserId = $faker->randomElement(array_column(array_filter($users, fn($u) => $u['role'] === 'teacher'), 'id'));
                $status = $faker->randomElement(['pending', 'approved', 'rejected', 'reviewed']);
                $reportId = DB::table('staff_reports')->insertGetId([
                    'user_id' => $teacherUserId,
                    'title' => $faker->sentence(3),
                    'content' => $faker->paragraph,
                    'status' => $status,
                    'headteacher_comments' => $status !== 'pending' ? $faker->sentence : null,
                    'reviewed_at' => $status !== 'pending' ? now() : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // Insert Report Comments
                if ($status !== 'pending') {
                    DB::table('report_comments')->insert([
                        'report_id' => $reportId,
                        'user_id' => $headteacherUserId,
                        'comment' => $faker->sentence,
                        'status_change' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
