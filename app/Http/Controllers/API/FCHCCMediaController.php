<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FCHCCMedia;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class FCHCCMediaController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $locale = $request->lang ?? 'en'; // default English

            $fchccMedia = FCHCCMedia::with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }])->latest()->get();

            if ($fchccMedia->isEmpty()) {
                return $this->error(null, 'No media  found', 404);
            }

            // Map clean response
            $data = $fchccMedia->map(function ($media) {
                $translation = $media->translations->first();

                return [
                    'id' => $media->id,
                    'status' => $media->status,
                    'image' => $media->image ? asset('uploads/fchcc_media/' . $media->image) : null,
                    'name' => $translation->title ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

            return $this->success($data, 'Media retrieved successfully', 200);
        } catch (\Throwable $e) {
            return $this->error(null, 'Something went wrong', 500);
        }
    }
}
