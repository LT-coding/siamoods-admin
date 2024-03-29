<?php

namespace Database\Seeders\Admin;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'LT Developer',
            'email' => 'info@lt-coding.com',
            'password' => Hash::make('w2009_!indoWs'),
            'status' => 1
        ])->assignRole(RoleType::developer->name);

        User::factory()->create([
            'name' => 'HaySell',
            'email' => 'haysell@siamoods.com',
            'password' => Hash::make('x8U5q5PhJ3gu'),
            'status' => 1
        ])->assignRole(RoleType::haySell->name);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@siamoods.com',
            'password' => Hash::make('password'),
            'status' => 1
        ])->assignRole(RoleType::admin->name);

        User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@siamoods.com',
            'password' => Hash::make('password'),
            'status' => 0
        ])->assignRole(RoleType::editor->name);
    }
}
