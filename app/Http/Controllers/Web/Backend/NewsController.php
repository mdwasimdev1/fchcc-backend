<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsTranslation;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
public function index()
    {
        return view('backend.layout.news.index');
    }

public function create()
    {
        return view('backend.layout.news.create');
    }


 public function getData()
    {
        $news = News::with('translations')->select('news.*');

        return DataTables::of($news)
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
                    return asset('uploads/fchcc_news/' . $row->image);
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
                    data-model="News"
                    data-url="' . route('news.status') . '"
                    ' . $checked . '>
            </div>
            ';
            })

            ->addColumn('action', function ($row) {
                return '
            <div class="d-flex align-items-center gap-1 justify-content-end">
                <button class="btn btn-sm btn-outline-primary me-1 editNews" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('news.destroy') . '">
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


        $news = new News();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/fchcc_news/'), $imageName);

            $news->image = $imageName;
        }

        $news = News::create([
            'image' => $news->image ?? null,
            'status' => 1
        ]);

        foreach (['en', 'es'] as $locale) {

            NewsTranslation::create([
                'news_id' => $news->id,
                'locale' => $locale,
                'title' => $request->title[$locale],
                'description' => $request->description[$locale] ?? null
            ]);
        }

        return redirect()->route('news.index')->with('success', 'FCHCC News added successfully');
    }


 public function edit($id)
    {
        $news = News::with('translations')->findOrFail($id);

        $title_en = optional($news->translations->where('locale', 'en')->first())->title;
        $title_es = optional($news->translations->where('locale', 'es')->first())->title;

        $description_en = optional($news->translations->where('locale', 'en')->first())->description;
        $description_es = optional($news->translations->where('locale', 'es')->first())->description;

        return response()->json([
            'id' => $news->id,
            'image' => $news->image,
            'status' => $news->status,

            'title_en' => $title_en,
            'title_es' => $title_es,

            'description_en' => $description_en,
            'description_es' => $description_es,
        ]);
    }


    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

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


            if ($news->image && file_exists(public_path('uploads/fchcc_news/' . $news->image))) {
                unlink(public_path('uploads/fchcc_news/' . $news->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/fchcc_news/'), $imageName);
            $news->image = $imageName;
        }

        $news->save();

        foreach (['en', 'es'] as $locale) {

            $translation = $news->translations()->where('locale', $locale)->first();

            if ($translation) {
                $translation->update([
                    'title' => $request->title[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            } else {
                $news->translations()->create([
                    'locale' => $locale,
                    'title' => $request->title[$locale],
                    'description' => $request->description[$locale] ?? null
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'FCHCC News updated successfully!',
            'image' => $news->image ? asset('uploads/fchcc_news/' . $news->image) : null
        ]);
    }

public function destroy(Request $request)
    {
        try {

            $news = News::findOrFail($request->id);

            if (!$news) {
                return response()->json([
                    'success' => false,
                    'message' => 'FCHCC News not found!'
                ]);
            }

            if (!empty($news->image)) {

                $imagePath = public_path('uploads/fchcc_news/' . $news->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $news->delete();

            return response()->json([
                'success' => true,
                'message' => 'FCHCC News deleted successfully!'
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
        $news = News::findOrFail($request->id);
        $news->status = $news->status == 1 ? 0 : 1;
        $news->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }


}
