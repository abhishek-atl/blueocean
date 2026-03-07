<?php

namespace Database\Seeders;

use App\Models\TariffPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TariffPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TariffPlan::create([
            'name' => 'price_60min',
            'duration' => 60,
            'amount' => 59.00,
            'fee' => 21.00,
            'active' => 1
        ]);
        TariffPlan::create([
            'name' => 'price_90min',
            'duration' => 90,
            'amount' => 80.00,
            'fee' => 32.00,
            'active' => 1
        ]);
        TariffPlan::create([
            'name' => 'price_120min',
            'duration' => 120,
            'amount' => 110.00,
            'fee' => 45.00,
            'active' => 1
        ]);
        TariffPlan::create([
            'name' => 'price_150min',
            'duration' => 150,
            'amount' => 145.00,
            'fee' => 62.50,
            'active' => 1
        ]);
        TariffPlan::create([
            'name' => 'price_180min',
            'duration' => 180,
            'amount' => 170.00,
            'fee' => 70.00,
            'active' => 1
        ]);
    }
}
