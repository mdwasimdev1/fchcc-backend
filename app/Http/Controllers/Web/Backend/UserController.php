<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::all();
        return view('backend.layout.user.index', compact('users'));
    }

    public function getdata()
    {
        $userList = User::query();
        return datatables()->of($userList)
            ->addIndexColumn()

            ->editColumn('status', function ($row) {
                $checked = $row->status == 'active' ? 'checked' : '';
                return '
                  <div class="form-check form-switch"> 
                       <input type="checkbox"
                          class="form-check-input status-toggle"
                          data-id="' . $row->id . '"
                          data-model="User"
                          data-url="' . route('user.status') . '"
                         ' . $checked . '>
                  </div>
                   ';
            })
            ->rawColumns(['status'])

            ->addColumn('action', function ($row) {
                return '
                 <div class="d-flex align-items-center gap-1 justify-content-end">
                  <a href="' . route('user.edit', $row->id) . '" class="btn btn-sm btn-outline-primary me-1">
                    <i class="fa fa-edit"></i>
                 </a>
                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('user.destroy') . '">
                        <i class="fa fa-trash"></i>
                   </button>
                </div>
            ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }



    public function create()
    {
        return view('backend.layout.user.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'is_admin' => 'required|boolean',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'is_admin' => $request->is_admin,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.layout.user.edit', compact('user'));
    }




    public function changeStatus(Request $request)
    {
        $userStatus = User::findOrFail($request->id);
        $userStatus->status = $userStatus->status == 'active' ? 'inactive' : 'active';
        $userStatus->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }



        public function destroy(Request $request)
    {
        try {

            $user = User::findOrFail($request->id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found!'
                ]);
            }

            if (!empty($user->image)) {

                $imagePath = public_path('uploads/user/' . $user->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);

    //     $user->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User deleted successfully!'
    //     ]);
    // }


    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'is_admin' => 'required|boolean',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($request->id);
        $user->is_admin = $request->is_admin;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }




    public function downloadPdf()
    {
        $users = User::all();

        $pdf = Pdf::loadView('backend.layout.user.user-pdf', compact('users'));

        return $pdf->download('users.pdf');
    }
}
