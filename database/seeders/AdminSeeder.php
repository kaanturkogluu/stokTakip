<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (Admin::where('email', 'admin@macrotech.com')->exists()) {
            $this->command->info('Admin user already exists.');
            return;
        }

        // Create super admin
        // Note: setPasswordAttribute mutator will automatically hash the password
        Admin::create([
            'name' => 'Süper Admin',
            'email' => 'admin@macrotech.com',
            'password' => 'admin123', // Mutator will hash this automatically
            'role' => 'super_admin',
            'permissions' => null, // Super admin has all permissions
            'is_active' => true
        ]);

        $this->command->info('Super admin user created successfully!');
        $this->command->info('Email: admin@macrotech.com');
        $this->command->info('Password: admin123');
    }
}
