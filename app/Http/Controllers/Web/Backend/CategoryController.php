<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.layout.category.index');
    }
    public function getCategories()
    {
        $categories = Category::query();

        return DataTables::of($categories)
            ->addIndexColumn()

            ->editColumn('image', function ($row) {
                if ($row->image) {
                    return asset('uploads/categories/' . $row->image);
                }
                return null;
            })

            ->editColumn('status', function ($row) {

                $checked = $row->status == 'active' ? 'checked' : '';


                return '
                  <div class="form-check form-switch"> 
                       <input type="checkbox"
                          class="form-check-input status-toggle"
                          data-id="' . $row->id . '"
                          data-model="Category"
                          data-url="' . route('category.status') . '"
                         ' . $checked . '>
                  </div>
                   ';
            })
            ->rawColumns(['status'])

            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex align-items-center gap-1 justify-content-end">
                 <button class="btn btn-sm btn-outline-primary me-1 editCategory" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                 </button>
                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('category.destroy') . '">
                        <i class="fa fa-trash"></i>
                </button>
               </div>
            ';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }




    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $category = new Category();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories/'), $imageName);
            $category->image = $imageName;
        }

        $category->name = $request->name;
        $category->priority = $request->priority;
        $category->status = $request->status;

        $category->save();

        return redirect()->back()->with('success', 'Category created successfully.');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);


        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('image')) {

            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories/'), $imageName);
            $category->image = $imageName;
        }


        $category->name = $request->name;
        $category->priority = $request->priority;
        $category->status = $request->status;


        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'image_url' => $category->image ? asset('uploads/categories/' . $category->image) : null
        ]);
    }




    public function destroy(Request $request)
    {
        try {

           $category = Category::findOrFail($request->id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found!'
                ]);
            }

            if (!empty($category->image)) {

                $imagePath = public_path('uploads/categories/' . $category->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
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
        $category = Category::findOrFail($request->id);
        $category->status = $category->status == 'active' ? 'inactive' : 'active';
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
