<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorTranslation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SponsorController extends Controller
{
    public function index()
    {
        return view('backend.layout.sponsor.index');
    }


    public function getData()
    {
        $sponsors = Sponsor::with('translations')->select('sponsors.*');

        return DataTables::of($sponsors)
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
                    return asset('uploads/sponsors/' . $row->logo);
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
                    data-model="Sponsor"
                    data-url="' . route('sponsor.status') . '"
                    ' . $checked . '>
            </div>
            ';
            })

            ->addColumn('action', function ($row) {
                return '
            <div class="d-flex align-items-center gap-1 justify-content-end">
                <button class="btn btn-sm btn-outline-primary me-1 editSponsor" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('sponsor.destroy') . '">
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


        $sponsor = new Sponsor();
        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/sponsors/'), $logoName);

            $sponsor->logo = $logoName;
        }

        $sponsor = Sponsor::create([
            'website_url' => $request->website_url,
            'logo' => $sponsor->logo ?? null,
            'status' => 1
        ]);

        foreach (['en', 'es'] as $locale) {

            SponsorTranslation::create([
                'sponsor_id' => $sponsor->id,
                'locale' => $locale,
                'name' => $request->name[$locale],
                'description' => $request->description[$locale] ?? null
            ]);
        }

        return redirect()->back()->with('success', 'Sponsor added successfully');
    }



    public function edit($id)
    {
        $sponsor = Sponsor::with('translations')->findOrFail($id);

        $name_en = optional($sponsor->translations->where('locale', 'en')->first())->name;
        $name_es = optional($sponsor->translations->where('locale', 'es')->first())->name;

        $description_en = optional($sponsor->translations->where('locale', 'en')->first())->description;
        $description_es = optional($sponsor->translations->where('locale', 'es')->first())->description;

        return response()->json([
            'id' => $sponsor->id,
            'website_url' => $sponsor->website_url,
            'status' => $sponsor->status,
            'logo' => $sponsor->logo,

            'name_en' => $name_en,
            'name_es' => $name_es,

            'description_en' => $description_en,
            'description_es' => $description_es,
        ]);
    }


    public function update(Request $request, $id)
    {
        $sponsor = Sponsor::findOrFail($id);

        // validation
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

            if ($sponsor->logo && file_exists(public_path('uploads/sponsors/' . $sponsor->logo))) {
                unlink(public_path('uploads/sponsors/' . $sponsor->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/sponsors/'), $logoName);
            $sponsor->logo = $logoName;
        }

        $sponsor->website_url = $request->website_url;
        $sponsor->save();

        foreach (['en', 'es'] as $locale) {

            $translation = $sponsor->translations()->where('locale', $locale)->first();

            if ($translation) {
                $translation->update([
                    'name' => $request->name[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            } else {
                $sponsor->translations()->create([
                    'locale' => $locale,
                    'name' => $request->name[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Sponsor updated successfully!',
            'logo_url' => $sponsor->logo ? asset('uploads/sponsors/' . $sponsor->logo) : null
        ]);
    }




    public function destroy(Request $request)
    {
        try {

            $sponsor = Sponsor::findOrFail($request->id);

            if (!$sponsor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sponsor not found!'
                ]);
            }

            if (!empty($sponsor->logo)) {

                $imagePath = public_path('uploads/sponsors/' . $sponsor->logo);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $sponsor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sponsor deleted successfully!'
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
        $sponsor = Sponsor::findOrFail($request->id);
        $sponsor->status = $sponsor->status == 1 ? 0 : 1;
        $sponsor->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
