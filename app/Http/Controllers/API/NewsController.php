<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsTranslation;
use App\Traits\ResponseTrait;


class NewsController extends Controller
{
 use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $locale = $request->lang ?? 'en'; // default English

            $news = News::with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }])->latest()->get();

            if ($news->isEmpty()) {
                return $this->error(null, 'No news found', 404);
            }

            // Map clean response
            $data = $news->map(function ($newsItem) {
                $translation = $newsItem->translations->first();

                return [
                    'id' => $newsItem->id,
                    'status' => $newsItem->status,
                    'image' => $newsItem->image ? asset('uploads/fchcc_news/' . $newsItem->image) : null,
                    'name' => $translation->title ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

            return $this->success($data, 'News retrieved successfully', 200);
        } catch (\Throwable $e) {
            return $this->error(null, 'Something went wrong', 500);
        }
    }
}
