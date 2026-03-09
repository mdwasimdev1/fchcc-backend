<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\FCHCCMedia;
use App\Models\FCHCCMediaTranslation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class FCHCCMediaController extends Controller
{
    public function index()
    {
        return view('backend.layout.fchcc-media.index');
    }


    public function getData()
    {
        $fchccMedia = FCHCCMedia::with('translations')->select('f_c_h_c_c_media.*');

        return DataTables::of($fchccMedia)
            ->addIndexColumn()

            ->addColumn('title', function ($row) {

                $translation = $row->translations
                    ->where('locale', app()->getLocale())
                    ->first();

                if (!$translation || empty($translation->title)) {
                    $translation = $row->translations
                        ->where('locale', 'en')
                        ->first();
                }

                if (!$translation || empty($translation->title)) {
                    $translation = $row->translations
                        ->where('locale', 'es')
                        ->first();
                }

                return $translation ? $translation->title : '';
            })

            ->filterColumn('title', function ($query, $keyword) {
                $query->whereHas('translations', function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('image', function ($row) {
                if ($row->image) {
                    return asset('uploads/fchcc_media/' . $row->image);
                }
                return null;
            })

            ->editColumn('status', function ($row) {

                $checked = $row->status == 1 ? 'checked' : '';

                return '
            <div class="form-check form-switch"> 
                <input type="checkbox"
                    class="form-check-input status-toggle"
                    data-id="' . $row->id . '"
                    data-model="FCHCCMedia"
                    data-url="' . route('media.status') . '"
                    ' . $checked . '>
            </div>
            ';
            })

            ->addColumn('action', function ($row) {
                return '
            <div class="d-flex align-items-center gap-1 justify-content-end">
                <button class="btn btn-sm btn-outline-primary me-1 editMedia" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('media.destroy') . '">
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
            'title.en' => 'nullable|string|max:255',
            'title.es' => 'nullable|string|max:255',
            'description.en' => 'nullable|string',
            'description.es' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288'
        ]);


        $fchccMedia = new FCHCCMedia();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/fchcc_media/'), $imageName);

            $fchccMedia->image = $imageName;
        }

        $fchccMedia = FCHCCMedia::create([
            'image' => $fchccMedia->image ?? null,
            'status' => 1
        ]);

        foreach (['en', 'es'] as $locale) {

            FCHCCMediaTranslation::create([
                'f_c_h_c_c_media_id' => $fchccMedia->id,
                'locale' => $locale,
                'title' => $request->title[$locale],
                'description' => $request->description[$locale] ?? null
            ]);
        }

        return redirect()->back()->with('success', 'FCHCC Media added successfully');
    }




    public function edit($id)
    {
        $fchccMedia = FCHCCMedia::with('translations')->findOrFail($id);

        $title_en = optional($fchccMedia->translations->where('locale', 'en')->first())->title;
        $title_es = optional($fchccMedia->translations->where('locale', 'es')->first())->title;

        $description_en = optional($fchccMedia->translations->where('locale', 'en')->first())->description;
        $description_es = optional($fchccMedia->translations->where('locale', 'es')->first())->description;

        return response()->json([
            'id' => $fchccMedia->id,
            'image' => $fchccMedia->image,
            'status' => $fchccMedia->status,

            'title_en' => $title_en,
            'title_es' => $title_es,

            'description_en' => $description_en,
            'description_es' => $description_es,
        ]);
    }


    public function update(Request $request, $id)
    {
        $fchccMedia = FCHCCMedia::findOrFail($id);

        // validation
        $request->validate([
            'title.en' => 'nullable|string|max:255',
            'title.es' => 'nullable|string|max:255',
            'description.en' => 'nullable|string',
            'description.es' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288'
        ]);

        // Image upload
        if ($request->hasFile('image')) {

        
            if ($fchccMedia->image && file_exists(public_path('uploads/fchcc_media/' . $fchccMedia->image))) {
                unlink(public_path('uploads/fchcc_media/' . $fchccMedia->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/fchcc_media/'), $imageName);
            $fchccMedia->image = $imageName;
        }

        $fchccMedia->save();

        foreach (['en', 'es'] as $locale) {

            $translation = $fchccMedia->translations()->where('locale', $locale)->first();

            if ($translation) {
                $translation->update([
                    'title' => $request->title[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            } else {
                $fchccMedia->translations()->create([
                    'locale' => $locale,
                    'title' => $request->title[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'FCHCC Media updated successfully!',
            'image' => $fchccMedia->image ? asset('uploads/fchcc_media/' . $fchccMedia->image) : null
        ]);
    }



    public function destroy(Request $request)
    {
        try {

            $fchccMedia = FCHCCMedia::findOrFail($request->id);

            if (!$fchccMedia) {
                return response()->json([
                    'success' => false,
                    'message' => 'FCHCC Media not found!'
                ]);
            }

            if (!empty($fchccMedia->image)) {

                $imagePath = public_path('uploads/fchcc_media/' . $fchccMedia->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $fchccMedia->delete();

            return response()->json([
                'success' => true,
                'message' => 'FCHCC Media deleted successfully!'
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
        $fchccMedia = FCHCCMedia::findOrFail($request->id);
        $fchccMedia->status = $fchccMedia->status == 1 ? 0 : 1;
        $fchccMedia->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
