<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin users for the Water Billing Management System
        $this->call([
            AdminUserSeeder::class,
            DivisionSeeder::class,
            CustomerTypeSeeder::class,
            GuarantorSeeder::class,
            CustomerSampleSeeder::class,
        ]);
    }
}
