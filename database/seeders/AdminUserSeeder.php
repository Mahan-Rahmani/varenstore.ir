<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user - بهاره شریف رضوانی
        User::firstOrCreate(
            ['phone' => '09395808412'],
            [
                'name' => 'بهاره شریف رضوانی',
                'email' => 'admin@varen.com',
                'phone' => '09395808412',
                'password' => Hash::make('AdminSecret123!'),
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
            ]
        );

        // Demo customer
        User::firstOrCreate(
            ['phone' => '09123456789'],
            [
                'name' => 'مشتری نمونه وارن',
                'email' => 'customer@varen.com',
                'phone' => '09123456789',
                'password' => Hash::make('Customer123!'),
                'role' => UserRole::CUSTOMER,
                'email_verified_at' => now(),
            ]
        );
    }
}
