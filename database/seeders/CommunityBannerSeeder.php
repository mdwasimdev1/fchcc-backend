<?php

namespace Database\Seeders;

use App\Models\CommunityBanner;
use Illuminate\Database\Seeder;

class CommunityBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = CommunityBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/community',
                'status' => true,
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Join Our Community',
                'description' => 'Connect with like-minded individuals and grow together.',
                'button_text' => 'Join Now',
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => '?nete a Nuestra Comunidad',
                'description' => 'Conecta con personas afines y crece juntos.',
                'button_text' => '?nete Ahora',
            ]
        );
    }
}
