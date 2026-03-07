<?php

namespace Database\Seeders;

use App\Models\PostcodeDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostcodeDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostcodeDistrict::create([
            'postcode_area' => 'EC',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'WC',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'E',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'N',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'NW',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'SE',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'SW',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'W',
            'district_name' => 'London',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'BR',
            'district_name' => 'Bromley',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'CR',
            'district_name' => 'Croydon',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'DA',
            'district_name' => 'Dartford',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'EN',
            'district_name' => 'Enfield',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'HA',
            'district_name' => 'Harrow',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'IG',
            'district_name' => 'Ilford',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'KT',
            'district_name' => 'Kingston',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'RM',
            'district_name' => 'Romford',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'SM',
            'district_name' => 'Sutton',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'TW',
            'district_name' => 'Twickenham',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'UB',
            'district_name' => 'Uxbridge',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'WD',
            'district_name' => 'Watford',
        ]);
        PostcodeDistrict::create([
            'postcode_area' => 'XX',
            'district_name' => 'Other',
        ]);
    }
}
