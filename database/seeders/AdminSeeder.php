<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('123456789'),
                'phone' => '1234567890',
                'role' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Content Manager',
                'email' => 'content@example.com',
                'password' => Hash::make('123456789'),
                'phone' => '2345678901',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Manager',
                'email' => 'users@example.com',
                'password' => Hash::make('123456789'),
                'phone' => '3456789012',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('admins')->insert($admins);
    }
}
