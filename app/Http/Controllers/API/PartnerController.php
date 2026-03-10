<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Traits\ResponseTrait;

class PartnerController extends Controller
{
     use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $locale = $request->lang ?? 'en'; // default English

            $partners = Partner::with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }])->latest()->get();

            if ($partners->isEmpty()) {
                return $this->error(null, 'No partners found', 404);
            }

            // Map clean response
            $data = $partners->map(function ($partner) {
                $translation = $partner->translations->first();

                return [
                    'id' => $partner->id,
                    'website_url' => $partner->website_url,
                    'status' => $partner->status,
                    'logo_url' => $partner->logo ? asset('uploads/partners/' . $partner->logo) : null,
                    'name' => $translation->name ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

            return $this->success($data, 'Partners retrieved successfully', 200);
        } catch (\Throwable $e) {
            return $this->error(null, 'Something went wrong', 500);
        }
    }
}
