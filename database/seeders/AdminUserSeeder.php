<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user for Water Billing Management System
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@waterbilling.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Change this in production!
            'role' => 'admin',
            'is_active' => true,
        ]);

        // You can add more staff users here
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@waterbilling.com',
            'email_verified_at' => now(),
            'password' => Hash::make('staff123'), // Change this in production!
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Add a manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@waterbilling.com',
            'email_verified_at' => now(),
            'password' => Hash::make('manager123'), // Change this in production!
            'role' => 'manager',
            'is_active' => true,
        ]);

        // Add a meter reader user
        User::create([
            'name' => 'Meter Reader',
            'email' => 'reader@waterbilling.com',
            'email_verified_at' => now(),
            'password' => Hash::make('reader123'), // Change this in production!
            'role' => 'meter_reader',
            'is_active' => true,
        ]);

        echo "Admin users created successfully!\n";
        echo "Admin Login: admin@waterbilling.com / password123\n";
        echo "Manager Login: manager@waterbilling.com / manager123\n";
        echo "Staff Login: staff@waterbilling.com / staff123\n";
        echo "Meter Reader Login: reader@waterbilling.com / reader123\n";
        echo "⚠️  Please change these passwords in production!\n";
    }
}
