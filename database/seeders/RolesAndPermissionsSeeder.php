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

        Permission::create(['name' => 'create report']);
        Permission::create(['name' => 'show reports']);
        Permission::create(['name' => 'delete report']);
        Permission::create(['name' => 'edit report']);

        Permission::create(['name' => 'create section']);
        Permission::create(['name' => 'show sections']);
        Permission::create(['name' => 'delete section']);
        Permission::create(['name' => 'edit section']);

        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'show products']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'edit product']);

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'edit user']);

        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'show roles']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'edit role']);

        // Get all created permissions
        $allPermissions = Permission::all();

        // 2. Create roles
        $collectorRole = Role::create(['name' => 'collector']);
        $adminRole = Role::create(['name' => 'admin']);

        // 3. Assign permissions to roles
        $collectorRole->givePermissionTo('create invoice', 'show invoices', 'create report', 'show reports', 'create section', 'show sections', 'create product', 'show products');

        // Assign ALL permissions to the admin role
        $adminRole->givePermissionTo($allPermissions);
    }
}
