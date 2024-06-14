<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Admin\GeneralCategoriesSeeder;
use Database\Seeders\Admin\MenusSeeder;
use Database\Seeders\Admin\NotificationSeeder;
use Database\Seeders\Admin\RolesSeeder;
use Database\Seeders\Admin\SEOSeeder;
use Database\Seeders\Admin\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected static array $seeds = [
        GeneralCategoriesSeeder::class,
        MenusSeeder::class,
        NotificationSeeder::class,
        SEOSeeder::class,
        RolesSeeder::class,
        UsersSeeder::class,
        PaymentsSeeder::class,
        ReviewSeeder::class,
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (static::$seeds as $seeder) {
            if (!in_array($seeder, self::$called, true)) {
                $this->call($seeder);
            }
        }
    }
}
