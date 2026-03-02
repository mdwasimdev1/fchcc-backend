<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {

            $locale = $request->lang ?? 'en';

            $events = Event::with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->latest()
            ->get();

            if ($events->isEmpty()) {
                return $this->error(
                    null,
                    'No Event found',
                    404
                );
            }

            // Clean response format
            $data = $events->map(function ($event) {

                $translation = $event->translations->first();

                return [
                    'id'          => $event->id,
                    'event_date'  => $event->event_date,
                    'title'       => $translation->title ?? null,
                    'description' => $translation->description ?? null,
                ];
            });

            return $this->success(
                $data,
                'Event retrieved successfully',
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