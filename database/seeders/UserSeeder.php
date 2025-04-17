<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@anilao.gov.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'mobile_number' => '09123456789',
            'role' => 'admin',
        ]);

        // Staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@anilao.gov.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'mobile_number' => '09123456788',
            'role' => 'staff',
        ]);

        // Regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'mobile_number' => '09123456787',
            'address' => 'Anilao, Iloilo',
            'birthdate' => '1990-01-01',
            'role' => 'user',
        ]);
    }
}