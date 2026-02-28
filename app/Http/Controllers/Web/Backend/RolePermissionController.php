<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::where('status', 'active')->where('name', '!=', 'Super Admin')->get();
        $permissions = Permission::all();

        // Group permissions by the last word (e.g., 'view users' -> 'users')
        $permissionGroups = $permissions->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return count($parts) > 1 ? end($parts) : 'Other';
        });

        return view('backend.layout.role_permissions.role.index', compact('roles', 'permissionGroups'));
    }


    public function update(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        if ($request->checked) {
            $role->givePermissionTo($permission);
        } else {
            $role->revokePermissionTo($permission);
        }

        // Clear permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully!'
        ]);
    }

    public function bulkUpdate(Request $request)
    {
        $role = Role::findOrFail($request->role_id);

        if ($request->checked) {
            $role->givePermissionTo($request->permission_ids);
        } else {
            $role->revokePermissionTo($request->permission_ids);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

         return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
