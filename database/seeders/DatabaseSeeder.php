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
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            UserSeeder::class,
            TreatmentTableSeeder::class,
            TreatmentCategoriesTableSeeder::class,
            PostDistrictsTableSeeder::class,
            PostcodesTableSeeder::class,
            PostcodeZonesTablesSeeder::class,
        ]);
    }
}
