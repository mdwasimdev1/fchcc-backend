<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'is_admin' => true,
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'is_admin' => true,
            ]
        );
        $admin->assignRole('Admin');

        // Create regular User
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'username' => 'user',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'is_admin' => false,
            ]
        );
        $user->assignRole('User');
    }
}
