<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FAQ::create([
            'que' => 'What is this application about?',
            'ans' => 'This application is a demo admin dashboard built with Laravel and Vue.js.',
        ]);
    }
}
