<?php

namespace Database\Seeders;

use App\Models\HomeBanner;
use Illuminate\Database\Seeder;

class HomeBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = HomeBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/home',
                'status' => true,
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Welcome to Our Home',
                'description' => 'Discover features and offers.',
                'button_text' => 'Learn More',
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => 'Bienvenido a Nuestro Sitio',
                'description' => 'Descubre caracter?sticas y ofertas.',
                'button_text' => 'Aprende M?s',
            ]
        );
    }
}
