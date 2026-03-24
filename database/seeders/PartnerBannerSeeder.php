<?php

namespace Database\Seeders;

use App\Models\PartnerBanner;
use Illuminate\Database\Seeder;

class PartnerBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = PartnerBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/partners',
                'status' => true,
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Our Partners',
                'description' => 'Meet our trusted partners and collaborators.',
                'button_text' => 'Learn More',
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => 'Nuestros Socios',
                'description' => 'Conoce a nuestros socios y colaboradores de confianza.',
                'button_text' => 'Aprende M?s',
            ]
        );
    }
}
