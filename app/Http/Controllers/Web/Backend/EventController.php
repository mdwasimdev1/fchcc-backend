<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('backend.pages.event.index');
    }

    public function create()
    {
        return view('backend.layout.event.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'event_date' => 'required|date',

            'title.en' => 'required|string',
            'description.en' => 'required|string',

            'title.es' => 'required|string',
            'description.es' => 'required|string',
        ]);

        // Create main event
        $event = Event::create([
            'event_date' => $request->event_date,
        ]);

        // Save translations
        foreach (['en', 'es'] as $locale) {
            $event->translations()->create([
                'locale' => $locale,
                'title' => $request->title[$locale],
                'description' => $request->description[$locale],
            ]);
        }

        return redirect()
            ->route('event.create')
            ->with('success', 'Event created successfully');
    }
}
