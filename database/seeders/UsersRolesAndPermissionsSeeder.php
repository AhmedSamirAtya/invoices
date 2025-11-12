<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $admin->assignRole('admin');

        $collector = User::create([
            "name" => "collector",
            "email" => "collector@invoices.com",
            "password" => Hash::make("12345678")
        ]);

        $collector->assignRole('collector');
    }
}
