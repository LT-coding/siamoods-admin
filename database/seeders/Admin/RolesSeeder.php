<?php

namespace Database\Seeders\Admin;

use App\Enums\RoleTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => RoleTypes::developer->name]);
        Role::create(['name' => RoleTypes::admin->name]);
        Role::create(['name' => RoleTypes::account->name]);
        Role::create(['name' => RoleTypes::editor->name]);
        Role::create(['name' => RoleTypes::haySell->name]);

    }
}
