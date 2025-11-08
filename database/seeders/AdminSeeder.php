<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $admin = User::where('email', 'inisidarku@gmail.com')->first();

        if ($admin) {
            // Update existing admin
            $admin->update([
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'email_ttd_reminder_enabled' => false, // Admin tidak perlu email reminder
            ]);
            $this->command->info('Admin user updated successfully!');
        } else {
            // Create new admin
            User::create([
                'name' => 'Administrator',
                'email' => 'inisidarku@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'email_ttd_reminder_enabled' => false, // Admin tidak perlu email reminder
            ]);
            $this->command->info('Admin user created successfully!');
        }

        $this->command->info('Email: inisidarku@gmail.com');
        $this->command->info('Password: admin123');
        $this->command->info('Role: admin');
    }
}
