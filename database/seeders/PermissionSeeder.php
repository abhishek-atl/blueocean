<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Manage Booking']);
        Permission::create(['name' => 'Manage Therapist']);
        Permission::create(['name' => 'Manage User']);
        Permission::create(['name' => 'Manage Setting']);
        Permission::create(['name' => 'Manage Content']);
        Permission::create(['name' => 'View Report']);
    }
}
