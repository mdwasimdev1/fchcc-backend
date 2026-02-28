<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;


    public function index()
    {
        try {
            $categories = Category::latest()->get();

            if ($categories->isEmpty()) {
                return $this->error(
                    null,
                    'No categories found',
                    404
                );
            }

            return $this->success(
                $categories,
                'Categories retrieved successfully',
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
