<?php

namespace Database\Seeders;

use App\Models\PostDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostDistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostDistrict::create([
            'postcode_area' => 'EC',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'WC',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'E',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'N',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'NW',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SE',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SW',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'W',
            'district' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'BR',
            'district' => 'Bromley',
        ]);
        PostDistrict::create([
            'postcode_area' => 'CR',
            'district' => 'Croydon',
        ]);
        PostDistrict::create([
            'postcode_area' => 'DA',
            'district' => 'Dartford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'EN',
            'district' => 'Enfield',
        ]);
        PostDistrict::create([
            'postcode_area' => 'HA',
            'district' => 'Harrow',
        ]);
        PostDistrict::create([
            'postcode_area' => 'IG',
            'district' => 'Ilford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'KT',
            'district' => 'Kingston',
        ]);
        PostDistrict::create([
            'postcode_area' => 'RM',
            'district' => 'Romford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SM',
            'district' => 'Sutton',
        ]);
        PostDistrict::create([
            'postcode_area' => 'TW',
            'district' => 'Twickenham',
        ]);
        PostDistrict::create([
            'postcode_area' => 'UB',
            'district' => 'Uxbridge',
        ]);
        PostDistrict::create([
            'postcode_area' => 'WD',
            'district' => 'Watford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'XX',
            'district' => 'Other',
        ]);
    }
}
