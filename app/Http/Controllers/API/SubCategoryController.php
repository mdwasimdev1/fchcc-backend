<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
     use ResponseTrait;


    public function index()
    {
        try {
            $subCategories = SubCategory::latest()->get();

            if ($subCategories->isEmpty()) {
                return $this->error(
                    null,
                    'No Sub categories found',
                    404
                );
            }

            return $this->success(
                $subCategories,
                'Sub Categories retrieved successfully',
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
