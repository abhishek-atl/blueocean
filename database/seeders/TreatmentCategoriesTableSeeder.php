<?php

namespace Database\Seeders;

use App\Models\TreatmentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TreatmentCategory::create([
            'name' => 'Top 5',
            'slug' => 'our-top-5.'
        ]);
        TreatmentCategory::create([
            'name' => 'Deep',
            'slug' => 'deep-pressure-massage'
        ]);
        TreatmentCategory::create([
            'name' => 'Medium',
            'slug' => 'medium-pressure-massage'
        ]);
        TreatmentCategory::create([
            'name' => 'Soft',
            'slug' => 'soft-pressure-massage'
        ]);
    }
}
