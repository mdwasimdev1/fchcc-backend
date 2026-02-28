<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('backend.layout.role_permissions.role.list');
    }

    public function getData()
    {
        $roles = Role::query()->where('name', '!=', 'Super Admin');

        return DataTables::of($roles)
            ->addIndexColumn()

            ->editColumn('status', function ($row) {

                $checked = $row->status == 'active' ? 'checked' : '';


                return '
                  <div class="form-check form-switch"> 
                       <input type="checkbox"
                          class="form-check-input status-toggle"
                          data-id="' . $row->id . '"
                          data-model="Role"
                          data-url="' . route('role.status') . '"
                         ' . $checked . '>
                  </div>
                   ';
            })
            ->rawColumns(['status'])


            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('role.edit', $row->id) . '" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('role.destroy') . '">
                        <i class="fa fa-trash"></i>
                   </button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.layout.role_permissions.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        Role::create(['name' => $request->name, 'status' => 'active']);

        return redirect()->route('role.index')->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('backend.layout.role_permissions.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect()->route('role.index')->with('success', 'Role updated successfully!');
    }



     public function destroy(Request $request)
    {
        try {

            $role = Role::findOrFail($request->id);

            if (!$role) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role not found!'
                ]);
            }

        

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }


    public function toggleStatus(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->status = $role->status == 'active' ? 'inactive' : 'active';
        $role->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
