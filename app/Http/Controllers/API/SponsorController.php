<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class SponsorController extends Controller
{

    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $locale = $request->lang ?? 'en'; // default English

            $sponsors = Sponsor::with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }])->latest()->get();

            if ($sponsors->isEmpty()) {
                return $this->error(null, 'No sponsors found', 404);
            }

            // Map clean response
            $data = $sponsors->map(function ($sponsor) {
                $translation = $sponsor->translations->first();

                return [
                    'id' => $sponsor->id,
                    'website_url' => $sponsor->website_url,
                    'status' => $sponsor->status,
                    'logo_url' => $sponsor->logo ? asset('uploads/sponsors/' . $sponsor->logo) : null,
                    'name' => $translation->name ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

            return $this->success($data, 'Sponsors retrieved successfully', 200);
        } catch (\Throwable $e) {
            return $this->error(null, 'Something went wrong', 500);
        }
    }
}
