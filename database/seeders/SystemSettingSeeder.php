<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::firstOrCreate(
            ['email' => 'contact@example.com'],
            [
                'system_title' => 'Admin Template',
                'system_short_title' => 'AT',
                'company_name' => 'Admin Template Inc.',
                'tag_line' => 'The Best Admin Template',
                'phone_code' => '+880',
                'phone_number' => '123456789',
                'whatsapp' => '123456789',
                'time_zone' => 'UTC',
                'language' => 'en',
                'copyright_text' => '© 2026 Admin Template',

                'admin_title' => 'Admin Dashboard',
                'admin_short_title' => 'AD',
                'admin_copyright_text' => 'Design & Develop by DevScout24',

                'logo' => 'uploads/setting/system/1772307103_pngtree-blue-eagle-logo-png-image_20949443.png',
                'minilogo' => 'uploads/setting/system/1772307103_pngtree-blue-eagle-logo-png-image_20949443.png',
                'admin_logo' => '1772307038_pngtree-blue-eagle-logo-png-image_20949443.png',
                'admin_mini_logo' => '1772307038_pngtree-blue-eagle-logo-png-image_20949443.png',
            ]
        );
    }
}
