<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BursarDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        DB::transaction(function () use ($faker) {
            // 1. Insert Academic Years
            $academicYearId = DB::table('academic_years')->insertGetId([
                'name' => '2025 Academic Year',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'is_current' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Insert Terms
            $termId = DB::table('terms')->insertGetId([
                'academic_year_id' => $academicYearId,
                'name' => 'Term 1',
                'start_date' => '2025-01-15',
                'end_date' => '2025-04-15',
                'is_current' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Insert Fee Structures
            $feeStructureId = DB::table('fee_structures')->insertGetId([
                'term_id' => $termId,
                'class_level' => 'S1',
                'tuition' => 500000.00,
                'boarding' => 200000.00,
                'development' => 50000.00,
                'uniform' => 30000.00,
                'books' => 20000.00,
                'other_charges' => 10000.00,
                'description' => 'Fee structure for Senior 1, Term 1, 2025',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Insert Users (Bursars, Students, and Admins)
            $users = [];
            // Bursars
            for ($i = 0; $i < 5; $i++) {
                $users[] = [
                    'id' => DB::table('users')->insertGetId([
                        'firstName' => $faker->firstName,
                        'lastName' => $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'role' => 'bursar',
                        'password' => Hash::make('password'),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]),
                    'role' => 'bursar',
                ];
            }
            // Students
            for ($i = 0; $i < 20; $i++) {
                $users[] = [
                    'id' => DB::table('users')->insertGetId([
                        'firstName' => $faker->firstName,
                        'lastName' => $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'role' => 'student',
                        'password' => Hash::make('password'),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]),
                    'role' => 'student',
                ];
            }
            // Admin (for approvals)
            $adminId = DB::table('users')->insertGetId([
                'firstName' => 'Admin',
                'lastName' => 'User',
                'email' => 'admin@school.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5. Insert Bursars
            foreach ($users as $user) {
                if ($user['role'] === 'bursar') {
                    DB::table('bursars')->insert([
                        'user_id' => $user['id'],
                        'staffId' => 'BUR' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'role' => $faker->randomElement(['chief_bursar', 'assistant_bursar', 'accounts_clerk', 'cashier']),
                        'phoneNumber' => $faker->phoneNumber,
                        'transaction_limit' => $faker->randomFloat(2, 100000, 1000000),
                        'can_approve_expenses' => $faker->boolean(30),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 6. Insert Students
            $studentIds = [];
            foreach ($users as $user) {
                if ($user['role'] === 'student') {
                    $studentId = DB::table('students')->insertGetId([
                        'user_id' => $user['id'],
                        'dateOfBirth' => $faker->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
                        'gender' => $faker->randomElement(['Male', 'Female']),
                        'nationality' => $faker->country,
                        'religion' => $faker->randomElement(['Christian', 'Muslim', 'Other']),
                        'admissionNumber' => 'ADM' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'guardianContact' => $faker->phoneNumber,
                        'address' => $faker->address,
                        'admission_date' => '2025-01-10',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $studentIds[] = $studentId;
                }
            }

            // 7. Insert Admin
            DB::table('admins')->insert([
                'user_id' => $adminId,
                'phoneNumber' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 8. Insert Fees
            $feeIds = [];
            foreach ($studentIds as $studentId) {
                $totalAmount = 810000.00; // Sum of fee structure components
                $paidAmount = $faker->randomElement([0, 200000, 400000, 600000, $totalAmount]);
                $status = $paidAmount == $totalAmount ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');
                $feeId = DB::table('fees')->insertGetId([
                    'student_id' => $studentId,
                    'term_id' => $termId,
                    'total_amount' => $totalAmount,
                    'paid_amount' => $paidAmount,
                    'status' => $status,
                    'due_date' => '2025-02-15',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $feeIds[] = $feeId;

                // 9. Insert Fee Arrears (for unpaid/partially paid fees)
                if ($paidAmount < $totalAmount) {
                    DB::table('fee_arrears')->insert([
                        'student_id' => $studentId,
                        'term_id' => $termId,
                        'amount' => $totalAmount - $paidAmount,
                        'notes' => 'Outstanding balance for Term 1',
                        'is_cleared' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 10. Insert Payments
            foreach ($feeIds as $feeId) {
                $fee = DB::table('fees')->find($feeId);
                if ($fee->paid_amount > 0) {
                    $numPayments = $faker->numberBetween(1, 3);
                    $remainingAmount = $fee->paid_amount;
                    for ($i = 0; $i < $numPayments; $i++) {
                        $amount = $i == $numPayments - 1 ? $remainingAmount : $faker->randomFloat(2, 50000, $remainingAmount);
                        $remainingAmount -= $amount;
                        DB::table('payments')->insert([
                            'fee_id' => $feeId,
                            'amount' => $amount,
                            'payment_method' => $faker->randomElement(['cash', 'bank_transfer', 'mobile_money']),
                            'transaction_id' => $faker->uuid,
                            'receipt_number' => 'REC' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                            'received_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                            'payment_date' => $faker->dateTimeBetween('2025-01-15', '2025-02-15'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // 11. Insert Accounts
            $accountId = DB::table('accounts')->insertGetId([
                'account_name' => 'Main School Account',
                'account_number' => 'ACC' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'account_type' => 'bank',
                'current_balance' => $faker->randomFloat(2, 1000000, 10000000),
                'bank_name' => $faker->company,
                'branch' => $faker->city,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 12. Insert Financial Transactions
            for ($i = 0; $i < 20; $i++) {
                $type = $faker->randomElement(['income', 'expense']);
                $amount = $faker->randomFloat(2, 10000, 500000);
                DB::table('financial_transactions')->insert([
                    'account_id' => $accountId,
                    'amount' => $amount,
                    'type' => $type,
                    'reference_number' => 'TRX' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'transaction_category' => $type === 'income' ? 'Fees' : $faker->randomElement(['Utilities', 'Supplies', 'Salaries']),
                    'transaction_date' => $faker->dateTimeBetween('2025-01-01', '2025-04-15'),
                    'recorded_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                    'is_approved' => $faker->boolean(80),
                    'approved_by' => $faker->boolean(80) ? $adminId : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 13. Insert Budget
            $budgetId = DB::table('budgets')->insertGetId([
                'title' => 'Term 1 Budget 2025',
                'term_id' => $termId,
                'total_amount' => 5000000.00,
                'start_date' => '2025-01-15',
                'end_date' => '2025-04-15',
                'created_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                'is_approved' => true,
                'approved_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 14. Insert Budget Items
            $budgetItems = [
                ['name' => 'Salaries', 'category' => 'Staff', 'allocated_amount' => 2000000.00, 'used_amount' => 1500000.00],
                ['name' => 'Utilities', 'category' => 'Operations', 'allocated_amount' => 1000000.00, 'used_amount' => 600000.00],
                ['name' => 'Supplies', 'category' => 'Resources', 'allocated_amount' => 1500000.00, 'used_amount' => 800000.00],
            ];
            foreach ($budgetItems as $item) {
                DB::table('budget_items')->insert([
                    'budget_id' => $budgetId,
                    'name' => $item['name'],
                    'category' => $item['category'],
                    'allocated_amount' => $item['allocated_amount'],
                    'used_amount' => $item['used_amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 15. Insert Expenses
            for ($i = 0; $i < 10; $i++) {
                $amount = $faker->randomFloat(2, 10000, 200000);
                DB::table('expenses')->insert([
                    'expense_number' => 'EXP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'account_id' => $accountId,
                    'amount' => $amount,
                    'payee' => $faker->company,
                    'payment_method' => $faker->randomElement(['cash', 'bank_transfer', 'mobile_money']),
                    'category' => $faker->randomElement(['Utilities', 'Supplies', 'Maintenance']),
                    'expense_date' => $faker->dateTimeBetween('2025-01-15', '2025-04-15'),
                    'has_receipt' => $faker->boolean(70),
                    'recorded_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                    'status' => $faker->randomElement(['pending', 'approved', 'paid']),
                    'approved_by' => $faker->boolean(70) ? $adminId : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 16. Insert Salary Payments
            foreach (array_filter($users, fn($u) => $u['role'] === 'bursar') as $bursar) {
                $gross = $faker->randomFloat(2, 200000, 500000);
                $deductions = $gross * $faker->randomFloat(2, 0.1, 0.2);
                DB::table('salary_payments')->insert([
                    'user_id' => $bursar['id'],
                    'gross_amount' => $gross,
                    'deductions' => $deductions,
                    'net_amount' => $gross - $deductions,
                    'payment_date' => $faker->dateTimeBetween('2025-01-15', '2025-02-15'),
                    'payment_method' => $faker->randomElement(['bank_transfer', 'mobile_money']),
                    'month_year' => 'January 2025',
                    'processed_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 17. Insert Fee Reminders
            foreach ($feeIds as $feeId) {
                $fee = DB::table('fees')->find($feeId);
                if ($fee->status !== 'paid') {
                    DB::table('fee_reminders')->insert([
                        'fee_id' => $feeId,
                        'medium' => $faker->randomElement(['sms', 'email']),
                        'message' => 'Reminder: Please clear outstanding fees for Term 1 by 2025-02-15.',
                        'sent_date' => $faker->dateTimeBetween('2025-01-20', '2025-02-10'),
                        'sent_by' => $users[array_rand(array_filter($users, fn($u) => $u['role'] === 'bursar'))]['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}