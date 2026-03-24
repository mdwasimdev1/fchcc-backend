<?php

namespace Database\Seeders;

use App\Models\ScholarshipBanner;
use Illuminate\Database\Seeder;

class ScholarshipBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = ScholarshipBanner::firstOrCreate(
            ['id' => 1],
            [
                'image' => null,
                'button_url' => 'https://example.com/scholarships',
                'status' => true,
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'en'],
            [
                'title' => 'Scholarship Opportunities',
                'description' => 'Apply for scholarships to support your education.',
                'button_text' => 'Apply Now',
            ]
        );

        $banner->translations()->firstOrCreate(
            ['locale' => 'es'],
            [
                'title' => 'Oportunidades de Becas',
                'description' => 'Solicita becas para apoyar tu educaci?n.',
                'button_text' => 'Aplica Ahora',
            ]
        );
    }
}
