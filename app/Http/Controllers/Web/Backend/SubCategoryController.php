<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function index()
    {
        $Categories = Category::where('status', 'active')->get();
        return view('backend.layout.subCategory.index', compact('Categories'));
    }
    public function getSubCategories()
    {
        $SubCategories = SubCategory::query();

        return DataTables::of($SubCategories)
            ->addIndexColumn()

            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->name : 'N/A';
            })


            ->editColumn('image', function ($row) {
                if ($row->image) {
                    return asset('uploads/subCategories/' . $row->image);
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
                          data-model="SubCategory"
                          data-url="' . route('subCategory.status') . '"
                         ' . $checked . '>
                   </div>
                  ';
            })
            ->rawColumns(['status'])

            ->addColumn('action', function ($row) {
                return '
                  <div class="d-flex align-items-center gap-1 justify-content-end">
                   <button class="btn btn-sm btn-outline-primary editSubCategory" data-id="' . $row->id . '">
                     <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('subCategory.destroy') . '">
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
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->name));


        $subCategory = new SubCategory();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/SubCategories/'), $imageName);
            $subCategory->image = $imageName;
        }

        $subCategory->name = $request->name;
        $subCategory->slug = $slug;
        $subCategory->category_id = $request->category_id;
        $subCategory->status = $request->status;

        $subCategory->save();

        return redirect()->back()->with('success', 'Sub Category created successfully.');
    }


    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        return response()->json($subCategory);
    }

    public function update(Request $request, $id)
    {

        $subCategory = SubCategory::findOrFail($id);


        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->name));


        if ($request->hasFile('image')) {

            if ($subCategory->image && file_exists(public_path('uploads/subCategories/' . $subCategory->image))) {
                unlink(public_path('uploads/subCategories/' . $subCategory->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/subCategories/'), $imageName);
            $subCategory->image = $imageName;
        }


        $subCategory->name = $request->name;
        $subCategory->slug = $slug;
        $subCategory->category_id = $request->category_id;
        $subCategory->status = $request->status;


        $subCategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Sub Category updated successfully!',
            'image_url' => $subCategory->image ? asset('uploads/subCategories/' . $subCategory->image) : null
        ]);
    }


    public function destroy(Request $request)
    {
        try {

            $subCategory = SubCategory::findOrFail($request->id);

            if (!$subCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found!'
                ]);
            }

            if (!empty($subCategory->image)) {

                $imagePath = public_path('uploads/subCategories/' . $subCategory->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $subCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sub Category deleted successfully!'
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
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->status = $subCategory->status == 'active' ? 'inactive' : 'active';
        $subCategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
