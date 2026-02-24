<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Therapist']);
        Permission::create(['name' => 'User']);
        Permission::create(['name' => 'Setting']);
        Permission::create(['name' => 'Booking']);
        Permission::create(['name' => 'Payment']);
        Permission::create(['name' => 'Report']);
    }
}
