<?php

namespace Database\Seeders;

use App\Models\DynamicPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DynamicPage::create([
            'page_title' => 'About Us',
            'page_content' => 'This is the about us page content.',
            'status' => 'active',
        ]);     
    }
}
