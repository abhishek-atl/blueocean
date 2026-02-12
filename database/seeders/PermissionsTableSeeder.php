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
        Permission::create(['name' => 'View Users']);
        Permission::create(['name' => 'Add Users']);
        Permission::create(['name' => 'Edit Users']);
        Permission::create(['name' => 'Delete Users']);

        Permission::create(['name' => 'View Therapists']);
        Permission::create(['name' => 'Add Therapists']);
        Permission::create(['name' => 'Edit Therapists']);
        Permission::create(['name' => 'Delete Therapists']);

        Permission::create(['name' => 'View Customers']);
        Permission::create(['name' => 'Add Customers']);
        Permission::create(['name' => 'Edit Customers']);
        Permission::create(['name' => 'Delete Customers']);
    }
}
