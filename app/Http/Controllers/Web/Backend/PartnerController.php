<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\PartnerTranslation;
use Yajra\DataTables\DataTables;

class PartnerController extends Controller
{
    public function index()
    {
        return view('backend.layout.partner.index');
    }



    public function getData()
    {
        $partners = Partner::with('translations')->select('partners.*');

        return DataTables::of($partners)
            ->addIndexColumn()

            ->addColumn('name', function ($row) {

                $translation = $row->translations
                    ->where('locale', app()->getLocale())
                    ->first();

                if (!$translation || empty($translation->name)) {
                    $translation = $row->translations
                        ->where('locale', 'en')
                        ->first();
                }

                if (!$translation || empty($translation->name)) {
                    $translation = $row->translations
                        ->where('locale', 'es')
                        ->first();
                }

                return $translation ? $translation->name : '';
            })

            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('translations', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('logo', function ($row) {
                if ($row->logo) {
                    return asset('uploads/partners/' . $row->logo);
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
                    data-model="Partner"
                    data-url="' . route('partner.status') . '"
                    ' . $checked . '>
            </div>
            ';
            })

            ->addColumn('action', function ($row) {
                return '
            <div class="d-flex align-items-center gap-1 justify-content-end">
                <button class="btn btn-sm btn-outline-primary me-1 editPartner" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('partner.destroy') . '">
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
            'name.en' => 'nullable|string|max:255',
            'name.es' => 'nullable|string|max:255',
            'description.en' => 'nullable|string',
            'description.es' => 'nullable|string',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288'
        ]);


        $partner = new Partner();
        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/partners/'), $logoName);

            $partner->logo = $logoName;
        }

        $partner = Partner::create([
            'website_url' => $request->website_url,
            'logo' => $partner->logo ?? null,
            'status' => 1
        ]);

        foreach (['en', 'es'] as $locale) {

            PartnerTranslation::create([
                'partner_id' => $partner->id,
                'locale' => $locale,
                'name' => $request->name[$locale],
                'description' => $request->description[$locale] ?? null
            ]);
        }

        return redirect()->back()->with('success', 'Partner added successfully');
    }



    public function edit($id)
    {
        $partner = Partner::with('translations')->findOrFail($id);

        $name_en = optional($partner->translations->where('locale', 'en')->first())->name;
        $name_es = optional($partner->translations->where('locale', 'es')->first())->name;

        $description_en = optional($partner->translations->where('locale', 'en')->first())->description;
        $description_es = optional($partner->translations->where('locale', 'es')->first())->description;

        return response()->json([
            'id' => $partner->id,
            'website_url' => $partner->website_url,
            'status' => $partner->status,
            'logo' => $partner->logo,

            'name_en' => $name_en,
            'name_es' => $name_es,

            'description_en' => $description_en,
            'description_es' => $description_es,
        ]);
    }



    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name.en' => 'nullable|string|max:255',
            'name.es' => 'nullable|string|max:255',
            'description.en' => 'nullable|string',
            'description.es' => 'nullable|string',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288'
        ]);

        // Logo upload
        if ($request->hasFile('logo')) {

            if ($partner->logo && file_exists(public_path('uploads/partners/' . $partner->logo))) {
                unlink(public_path('uploads/partners/' . $partner->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/partners/'), $logoName);
            $partner->logo = $logoName;
        }

        $partner->website_url = $request->website_url;
        $partner->save();

        foreach (['en', 'es'] as $locale) {

            $translation = $partner->translations()->where('locale', $locale)->first();

            if ($translation) {
                $translation->update([
                    'name' => $request->name[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            } else {
                $partner->translations()->create([
                    'locale' => $locale,
                    'name' => $request->name[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Partner updated successfully!',
            'logo_url' => $partner->logo ? asset('uploads/partners/' . $partner->logo) : null
        ]);
    }




    public function destroy(Request $request)
    {
        try {

            $partner = Partner::findOrFail($request->id);

            if (!$partner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Partner not found!'
                ]);
            }

            if (!empty($partner->logo)) {

                $imagePath = public_path('uploads/partners/' . $partner->logo);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $partner->delete();

            return response()->json([
                'success' => true,
                'message' => 'Partner deleted successfully!'
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
        $partner = Partner::findOrFail($request->id);
        $partner->status = $partner->status == 1 ? 0 : 1;
        $partner->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
