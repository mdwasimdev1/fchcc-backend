<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class SystemSettingController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $system = SystemSetting::latest()->get();

            if ($system->isEmpty()) {
                return $this->error(
                    null,
                    'No System Setting found',
                    404
                );
            }
            return $this->success(
                $system,
                'System Setting retrieved successfully',
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
