<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create permissions
        Permission::create(['name' => 'create invoice']);
        Permission::create(['name' => 'show invoices']);
        Permission::create(['name' => 'delete invoice']);
        Permission::create(['name' => 'edit invoice']);

        // Get all created permissions
        $allPermissions = Permission::all();

        // 2. Create roles
        $collectorRole = Role::create(['name' => 'collector']);
        $adminRole = Role::create(['name' => 'admin']);

        // 3. Assign permissions to roles
        $collectorRole->givePermissionTo('create invoice', 'show invoices');

        // Assign ALL permissions to the admin role
        $adminRole->givePermissionTo($allPermissions);
    }
}
