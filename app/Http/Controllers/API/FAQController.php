<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FAQController extends Controller
{
     use ResponseTrait;


    public function index()
    {
        try {
            $faq = FAQ::latest()->get();

            if ($faq->isEmpty()) {
                return $this->error(
                    null,
                    'No FAQ found',
                    404
                );
            }

            return $this->success(
                $faq,
                'FAQ retrieved successfully',
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
