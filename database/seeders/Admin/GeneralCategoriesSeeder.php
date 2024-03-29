<?php

namespace Database\Seeders\Admin;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralCategoriesSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_cats')->insert([
            [
                'id' => 112,
                'title' => 'Հավաքածու',
                'show_in_item' => 0,
                'show_in_web' => 1,
                'is_main' => 0,
                'is_price' => 0,
                'created_at' => '2023-06-29 05:09:04',
                'updated_at' => '2023-06-29 05:09:04',
            ],
            [
                'id' => 125,
                'title' => 'Քարեր',
                'show_in_item' => 0,
                'show_in_web' => 1,
                'is_main' => 0,
                'is_price' => 0,
                'created_at' => '2023-06-29 05:09:04',
                'updated_at' => '2023-06-29 05:09:04',
            ],
            [
                'id' => 126,
                'title' => 'Կայքի դասակարգիչ',
                'show_in_item' => 0,
                'show_in_web' => 1,
                'is_main' => 1,
                'is_price' => 0,
                'created_at' => '2023-06-29 05:09:04',
                'updated_at' => '2023-06-29 05:09:04',
            ],
            [
                'id' => 133,
                'title' => 'Բրենդ',
                'show_in_item' => 0,
                'show_in_web' => 1,
                'is_main' => 0,
                'is_price' => 0,
                'created_at' => '2023-06-29 05:09:04',
                'updated_at' => '2023-06-29 05:09:04',
            ],
        ]);
    }
}
