<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $user       = Role::firstOrCreate(['name' => 'User']);

     
        $permissions = [
            'manage users',
            'manage roles',
            'create post',
            'edit post',
            'delete post',
            'status change post',
            'view post',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'create post',
            'edit post',
            'delete post',
            'status change post',
            'view post',
        ]);

        $user->givePermissionTo([
            'view post',
        ]);

    
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $superAdminUser->assignRole('Super Admin');
    }
}

