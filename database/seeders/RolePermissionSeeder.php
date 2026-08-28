<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'doctor']);
        Role::firstOrCreate(['name' => 'patient']);

        // Permissions
        Permission::firstOrCreate(['name' => 'view patients']);
        Permission::firstOrCreate(['name' => 'manage patients']);

        Permission::firstOrCreate(['name' => 'view devices']);
        Permission::firstOrCreate(['name' => 'manage devices']);

        Permission::firstOrCreate(['name' => 'view sensor readings']);
        Permission::firstOrCreate(['name' => 'manage sensor readings']);
    }
}