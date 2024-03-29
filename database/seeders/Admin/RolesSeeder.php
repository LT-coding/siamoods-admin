<?php

namespace Database\Seeders\Admin;

use App\Enums\RoleType;
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
        Role::create(['name' => RoleType::developer->name]);
        Role::create(['name' => RoleType::admin->name]);
        Role::create(['name' => RoleType::account->name]);
        Role::create(['name' => RoleType::editor->name]);
        Role::create(['name' => RoleType::haySell->name]);

    }
}
