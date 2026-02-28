<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    use ResponseTrait;


    public function index()
    {
        try {
            $dynamicPage = DynamicPage::latest()->get();

            if ($dynamicPage->isEmpty()) {
                return $this->error(
                    null,
                    'No Dynamic Page found',
                    404
                );
            }

            return $this->success(
                $dynamicPage,
                'Dynamic Page retrieved successfully',
                200
            );
        } catch (\Throwable $e) {
            return $this->error(
                null,
                'Something went wrong',
                500
            );
        }
    }
}
