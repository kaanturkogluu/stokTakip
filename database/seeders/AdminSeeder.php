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
        // Create or update super admin
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@macrotech.com'],
            [
                'name' => 'Süper Admin',
                'password' => 'admin123', // Mutator will hash automatically
                'role' => 'super_admin',
                'permissions' => null,
                'is_active' => true
            ]
        );

        $this->command->info('Super admin user synced successfully!');
        $this->command->info('Email: ' . $admin->email);
        $this->command->info('Password: admin123');
    }
}
