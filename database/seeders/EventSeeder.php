<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventTranslation;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Event 1
        $event1 = Event::create([
            'event_date' => '2026-03-01',
        ]);

        EventTranslation::create([
            'event_id' => $event1->id,
            'locale' => 'en',
            'title' => 'Music Festival',
            'description' => 'Big international music festival.'
        ]);

        EventTranslation::create([
            'event_id' => $event1->id,
            'locale' => 'es',
            'title' => 'Festival de Música',
            'description' => 'Gran festival internacional de música.'
        ]);


        // Event 2
        $event2 = Event::create([
            'event_date' => '2026-04-15',
        ]);

        EventTranslation::create([
            'event_id' => $event2->id,
            'locale' => 'en',
            'title' => 'Tech Conference',
            'description' => 'Annual technology conference.'
        ]);

        EventTranslation::create([
            'event_id' => $event2->id,
            'locale' => 'es',
            'title' => 'Conferencia Tecnológica',
            'description' => 'Conferencia anual de tecnología.'
        ]);
    }
}
