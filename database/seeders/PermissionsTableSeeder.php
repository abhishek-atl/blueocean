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
        Permission::create(['name' => 'Therapist Management']);
        Permission::create(['name' => 'User Management']);
        Permission::create(['name' => 'Setting Management']);
        Permission::create(['name' => 'Booking Management']);
        Permission::create(['name' => 'Payment Management']);
        Permission::create(['name' => 'Report Management']);
    }
}
