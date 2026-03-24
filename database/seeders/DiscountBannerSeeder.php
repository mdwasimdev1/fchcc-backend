<?php

namespace Database\Seeders;

use App\Models\DiscountBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create discount banner
        $discountBanner = DiscountBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/discount',
                'status' => 1,
            ]
        );

        // Create English translation
        $discountBanner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Exclusive Discounts Available',
                'description' => 'Get special discounts on our premium services. Limited time offer!',
                'button_text' => 'Claim Discount',
            ]
        );

        // Create Spanish translation
        $discountBanner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => 'Descuentos Exclusivos Disponibles',
                'description' => 'Obt?n descuentos especiales en nuestros servicios premium. Oferta limitada!',
                'button_text' => 'Reclamar Descuento',
            ]
        );
    }

}
