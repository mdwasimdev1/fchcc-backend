<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;


    public function index()
    {
        try {
            $product = Product::latest()->get();

            if ($product->isEmpty()) {
                return $this->error(
                    null,
                    'No Product found',
                    404
                );
            }

            return $this->success(
                $product,
                'Product retrieved successfully',
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
