<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all tables
        $tables = ['users', 'admins', 'doctors', 'specializations', 'patients', 'appointments', 'subscriptions', 'doctor_unavailabilities'];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create super admin
        $superAdmin = DB::table('admins')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('123456789'),
            'phone' => '962791234567',
            'role' => 'super_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create regular admin
        $admin = DB::table('admins')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'),
            'phone' => '962791234568',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Seed 20 specializations
        $specializations = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nails'],
            ['name' => 'Neurology', 'description' => 'Nervous system'],
            ['name' => 'Pediatrics', 'description' => 'Children\'s health'],
            ['name' => 'Orthopedics', 'description' => 'Musculoskeletal system'],
            ['name' => 'Ophthalmology', 'description' => 'Eye care'],
            ['name' => 'Dentistry', 'description' => 'Oral health'],
            ['name' => 'Psychiatry', 'description' => 'Mental health'],
            ['name' => 'Endocrinology', 'description' => 'Hormones and metabolism'],
            ['name' => 'Gastroenterology', 'description' => 'Digestive system'],
            ['name' => 'Hematology', 'description' => 'Blood disorders'],
            ['name' => 'Infectious Disease', 'description' => 'Infectious diseases'],
            ['name' => 'Nephrology', 'description' => 'Kidney diseases'],
            ['name' => 'Oncology', 'description' => 'Cancer treatment'],
            ['name' => 'Pulmonology', 'description' => 'Respiratory system'],
            ['name' => 'Rheumatology', 'description' => 'Joints and autoimmune diseases'],
            ['name' => 'Urology', 'description' => 'Urinary system'],
            ['name' => 'Allergy and Immunology', 'description' => 'Allergies and immune system'],
            ['name' => 'Physical Medicine', 'description' => 'Physical therapy and rehabilitation'],
            ['name' => 'General Surgery', 'description' => 'Surgical procedures'],
        ];

        // Insert specializations
        foreach ($specializations as $spec) {
            DB::table('specializations')->insert([
                'name' => $spec['name'],
                'description' => $spec['description'],
                'created_by' => $superAdmin,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get all specialization IDs
        $specializationIds = DB::table('specializations')->pluck('id');

        // Create 20 users with profile images (cycling through 10 images)
        for ($i = 1; $i <= 20; $i++) {
            $imageNumber = ($i % 10) ?: 10; // Cycle through 1-10
            $image = "profile-images/user_{$imageNumber}.jpg";

            DB::table('users')->insert([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'image' => $image,
                'email_verified_at' => now(),
                'phone' => '96279' . rand(1000000, 9999999),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create doctors - evenly distributed across specializations and governorates
        $governorates = [
            'Amman', 'Irbid', 'Ajloun', 'Aqaba', 'Balqa',
            'Zarqa', 'Mafraq', "Maan", 'Tafilah', 'Karak', 'Jerash'
        ];

        $workingHoursStart = '09:00:00';
        $workingHoursEnd = '17:00:00';
        $availableDays = ['Monday', 'Wednesday', 'Friday'];

        $doctorCounter = 1;
        $totalDoctors = 200;
        $approvedDoctors = 150;

        $maleNames = ['John', 'Michael', 'David', 'Robert', 'James', 'William', 'Richard', 'Joseph', 'Thomas', 'Daniel'];
        $femaleNames = ['Sarah', 'Emily', 'Lisa', 'Emma', 'Olivia', 'Ava', 'Isabella', 'Sophia', 'Mia', 'Charlotte'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        foreach ($specializationIds as $specId) {
            foreach ($governorates as $governorate) {
                for ($i = 1; $i <= ceil($totalDoctors / (count($specializationIds) * count($governorates))); $i++) {
                    if ($doctorCounter > $totalDoctors) {
                        break 2; // Exit both loops once the total number of doctors is reached
                    }

                    $isMale = $doctorCounter % 2 == 0;
                    $firstName = $isMale ?
                        $maleNames[array_rand($maleNames)] :
                        $femaleNames[array_rand($femaleNames)];
                    $lastName = $lastNames[array_rand($lastNames)];

                    // Set status: first 150 doctors are approved, the rest are pending or rejected
                    if ($doctorCounter <= $approvedDoctors) {
                        $status = 'approved';
                    } else {
                        $status = $doctorCounter % 2 == 0 ? 'pending' : 'rejected';
                    }

                    // Cycle through 20 doctor images (10 male, 10 female)
                    $imageNumber = ($doctorCounter % 20) ?: 20; // Cycle through 1-20
                    $genderPrefix = $isMale ? 'male' : 'female';
                    $image = "doctor_images/doctor_{$genderPrefix}_" . (($imageNumber % 10) ?: 10) . ".jpg";

                    // Cycle through 3 doctor documents
                    $docNumber = ($doctorCounter % 3) ?: 3;
                    $document = "doctor_documents/doctor_document_{$docNumber}.pdf";

                    // Set day booleans
                    $days = [
                        'monday' => in_array('Monday', $availableDays),
                        'tuesday' => in_array('Tuesday', $availableDays),
                        'wednesday' => in_array('Wednesday', $availableDays),
                        'thursday' => in_array('Thursday', $availableDays),
                        'friday' => in_array('Friday', $availableDays),
                        'saturday' => in_array('Saturday', $availableDays),
                        'sunday' => in_array('Sunday', $availableDays),
                    ];

                    DB::table('doctors')->insert([
                        'name' => "$firstName $lastName",
                        'email' => "doctor{$doctorCounter}@example.com",
                        'password' => Hash::make('123456789'),
                        'image' => $image,
                        'doctor_document' => $document,
                        'phone' => '96279' . rand(2000000, 2999999),
                        'specialization_id' => $specId,
                        'bio' => 'Experienced doctor with ' . rand(5, 30) . ' years of practice in the field.',
                        'experience_years' => rand(5, 30),
                        'governorate' => $governorate,
                        'address' => rand(100, 999) . ' Main St, Building ' . rand(1, 50),
                        'price_per_appointment' => rand(20, 100),
                        'monday' => $days['monday'],
                        'tuesday' => $days['tuesday'],
                        'wednesday' => $days['wednesday'],
                        'thursday' => $days['thursday'],
                        'friday' => $days['friday'],
                        'saturday' => $days['saturday'],
                        'sunday' => $days['sunday'],
                        'working_hours_start' => $workingHoursStart,
                        'working_hours_end' => $workingHoursEnd,
                        'status' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $doctorCounter++;
                }
            }
        }

        // Create patients associated with users
        $userIds = DB::table('users')->pluck('id');
        foreach ($userIds as $userId) {
            DB::table('patients')->insert([
                'name' => 'Patient for User ' . $userId,
                'phone' => '96279' . rand(3000000, 3999999),
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create some patients without user accounts
        for ($i = 1; $i <= 5; $i++) {
            DB::table('patients')->insert([
                'name' => 'Guest Patient ' . $i,
                'phone' => '96279' . rand(4000000, 4999999),
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get all patient IDs
        $patientIds = DB::table('patients')->pluck('id');
        $doctorIds = DB::table('doctors')->where('status', 'approved')->pluck('id');

        // Create appointments with separate date and time
        for ($i = 1; $i <= 50; $i++) {
            $doctorId = $doctorIds->random();
            $patientId = $patientIds->random();
            $date = Carbon::now()->addDays(rand(1, 30))->format('Y-m-d');
            $time = Carbon::createFromTime(rand(9, 16), rand(0, 1) * 30, 0)->format('H:i:s');

            $status = $i % 4 == 0 ? 'pending' : ($i % 4 == 1 ? 'confirmed' : 'canceled');
            $paymentStatus = $status == 'confirmed' ? (rand(0, 1) ? 'paid' : 'unpaid') : 'unpaid';

            DB::table('appointments')->insert([
                'doctor_id' => $doctorId,
                'patient_id' => $patientId,
                'appointment_date' => $date,
                'appointment_time' => $time,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create subscriptions for doctors
        foreach ($doctorIds as $doctorId) {
            $startDate = Carbon::now()->subDays(rand(0, 30));
            $endDate = $startDate->copy()->addDays(rand(30, 365));
            $status = $endDate->isPast() ? 'expired' : 'active';

            DB::table('subscriptions')->insert([
                'doctor_id' => $doctorId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create doctor unavailabilities
        foreach ($doctorIds as $doctorId) {
            for ($i = 1; $i <= rand(1, 5); $i++) {
                $date = Carbon::now()->addDays(rand(1, 30));
                $startTime = Carbon::createFromTime(rand(8, 16), rand(0, 1) * 30, 0);

                DB::table('doctor_unavailabilities')->insert([
                    'doctor_id' => $doctorId,
                    'date' => $date,
                    'start_time' => $startTime,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}