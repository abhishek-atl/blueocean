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
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'WC',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'E',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'N',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'NW',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SE',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SW',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'W',
            'district_name' => 'London',
        ]);
        PostDistrict::create([
            'postcode_area' => 'BR',
            'district_name' => 'Bromley',
        ]);
        PostDistrict::create([
            'postcode_area' => 'CR',
            'district_name' => 'Croydon',
        ]);
        PostDistrict::create([
            'postcode_area' => 'DA',
            'district_name' => 'Dartford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'EN',
            'district_name' => 'Enfield',
        ]);
        PostDistrict::create([
            'postcode_area' => 'HA',
            'district_name' => 'Harrow',
        ]);
        PostDistrict::create([
            'postcode_area' => 'IG',
            'district_name' => 'Ilford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'KT',
            'district_name' => 'Kingston',
        ]);
        PostDistrict::create([
            'postcode_area' => 'RM',
            'district_name' => 'Romford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'SM',
            'district_name' => 'Sutton',
        ]);
        PostDistrict::create([
            'postcode_area' => 'TW',
            'district_name' => 'Twickenham',
        ]);
        PostDistrict::create([
            'postcode_area' => 'UB',
            'district_name' => 'Uxbridge',
        ]);
        PostDistrict::create([
            'postcode_area' => 'WD',
            'district_name' => 'Watford',
        ]);
        PostDistrict::create([
            'postcode_area' => 'XX',
            'district_name' => 'Other',
        ]);
    }
}
