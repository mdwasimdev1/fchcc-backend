<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Traits\ResponseTrait;

class ProductController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        return view('backend.layout.product.index');
    }

    public function create()
    {
        $Categories = Category::where('status', 'active')->get();
        return view('backend.layout.product.create', compact('Categories'));
    }

    public function getSubCategories($category_id)
    {
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subCategories);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:12288',
            'status' => 'required|in:active,inactive',
        ]);


        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'status' => $request->status,
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('products');
            }
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        $folder = 'tmp/filepond';
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($folder, $filename);

        return response($path, 200);
    }

    public function revert(Request $request)
    {
        Storage::delete($request->getContent());
        return response('', 200);
    }


    public function getProduct()
    {
        $Products = Product::query();

        return DataTables::of($Products)
            ->addIndexColumn()

            ->editColumn('image', function ($row) {
                $image = $row->getFirstMediaUrl('products');

                if ($image) {
                    return '<img src="' . $image . '" width="50" height="40" class="rounded">';
                }

                return '<span class="text-muted">No Image</span>';
            })


            ->editColumn('status', function ($row) {

                $checked = $row->status == 'active' ? 'checked' : '';


                return '
                  <div class="form-check form-switch"> 
                       <input type="checkbox"
                          class="form-check-input status-toggle"
                          data-id="' . $row->id . '"
                          data-model="Product"
                          data-url="' . route('product.status') . '"
                         ' . $checked . '>
                  </div>
                   ';
            })
            ->rawColumns(['status'])

            ->addColumn('action', function ($row) {
                $editUrl = route('product.edit', $row->id);
                return '
                 <div class="d-flex align-items-center gap-1 justify-content-end">
                 <a href="' . $editUrl . '" class="btn btn-sm btn-outline-primary me-1">
                    <i class="fa fa-edit"></i>
                 </a>
                 <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('product.destroy') . '">
                        <i class="fa fa-trash"></i>
                 </button>
                </div>
                ';
            })

            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }



     public function destroy(Request $request)
    {
        try {

            $product = Product::findOrFail($request->id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found!'
                ]);
            }

            if (!empty($product->image)) {

                $imagePath = public_path('uploads/product/' . $product->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
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
        $product = Product::findOrFail($request->id);
        $product->status = $product->status == 'active' ? 'inactive' : 'active';
        $product->save();

        return $this->success(null, 'Status updated successfully!');
    }
}
