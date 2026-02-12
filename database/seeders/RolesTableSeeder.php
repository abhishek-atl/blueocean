<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Administrator',
            'is_default' => true,
        ]);
        Role::create([
            'name' => 'Therapist',
            'is_default' => true
        ]);
        Role::create([
            'name' => 'Customer',
            'is_default' => true
        ]);
    }
}
