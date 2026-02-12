<?php

namespace Database\Seeders;

use App\Models\PostcodeZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostcodeZonesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostcodeZone::create([
            'name' => 'Zone 1',
            'active' => true,
        ]);
        PostcodeZone::create([
            'name' => 'Zone 2',
            'active' => true,
        ]);
        PostcodeZone::create([
            'name' => 'Zone 3',
            'active' => true,
        ]);
        PostcodeZone::create([
            'name' => 'Zone 4',
            'active' => true,
        ]);
        PostcodeZone::create([
            'name' => 'Zone 5',
            'active' => true,
        ]);
        PostcodeZone::create([
            'name' => 'Zone 6',
            'active' => true,
        ]);
    }
}
