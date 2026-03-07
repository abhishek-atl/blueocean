<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            TreatmentSeeder::class,
            TreatmentCategorySeeder::class,
            TariffPlanSeeder::class,
            PostcodeDistrictSeeder::class,
            PostcodeSeeder::class,
            PostcodeZoneSeeder::class,
        ]);
    }
}
