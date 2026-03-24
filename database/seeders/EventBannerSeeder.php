<?php

namespace Database\Seeders;

use App\Models\EventBanner;
use Illuminate\Database\Seeder;

class EventBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = EventBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/events',
                'status' => true,
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Upcoming Events',
                'description' => 'Join events to grow your skills.',
                'button_text' => 'Register Now',
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => 'Pr?ximos Eventos',
                'description' => '?nete a eventos para mejorar tus habilidades.',
                'button_text' => 'Reg?strate Ahora',
            ]
        );
    }
}
