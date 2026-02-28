<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'update user status',

            // Role Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage permissions',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'update category status',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'update product status',

            // FAQ Management
            'view faqs',
            'create faqs',
            'edit faqs',
            'delete faqs',

            // Dynamic Pages
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',

            // System Settings
            'view settings',
            'update settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        
        // Super Admin: Has all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        // Spatie handles Super Admin via Gate::before in AuthServiceProvider usually, 
        // but we can also give them all permissions explicitly.
        $superAdmin->syncPermissions(Permission::all());

        // Admin: Most permissions except sensitive system settings perhaps
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::whereNotIn('name', [
            'delete roles',
            'manage permissions',
        ])->get());

        // User: Limited permissions
        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->syncPermissions([
            'view products',
            'view categories',
        ]);
    }
}
