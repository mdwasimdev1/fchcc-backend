<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            SystemSettingSeeder::class,
            EventSeeder::class,
            HomeBannerSeeder::class,
            EventBannerSeeder::class,
            ScholarshipBannerSeeder::class,
            PartnerBannerSeeder::class,
            CommunityBannerSeeder::class,]);
    }
}
