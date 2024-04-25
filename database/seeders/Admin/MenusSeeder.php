<?php
namespace Database\Seeders\Admin;

use App\Enums\CustomizationPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
//            Header menu
            [
                'id' => 1,
                'parent_id' => null,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Օնլայն խանութ',
                'url' => '/products',
                'position' => 1,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Ականջօղեր',
                'url' => '/products/akandjogher',
                'position' => 2,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 3,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Մեխիկ',
                'url' => '/products/mekhik',
                'position' => 3,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 4,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Քաֆ',
                'url' => '/products/qaf',
                'position' => 4,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Օղակ',
                'url' => '/products/oghak',
                'position' => 5,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 6,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Մագլցող',
                'url' => '/products/magltcogh',
                'position' => 6,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 7,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Շղթայով',
                'url' => '/products/shghthayov',
                'position' => 7,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 8,
                'parent_id' => 2,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Կիսաօղակ',
                'url' => '/products/kisaoghak',
                'position' => 8,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 9,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Ապարանջաններ',
                'url' => '/products/aparandjanner',
                'position' => 9,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 10,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Կախազարդեր',
                'url' => '/products/kakhazarder',
                'position' => 10,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 11,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Մատանիներ',
                'url' => '/products/mataniner',
                'position' => 11,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 12,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Վզնոցներ',
                'url' => '/products/vznotcner',
                'position' => 12,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 13,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Շղթաներ',
                'url' => '/products/shghthaner',
                'position' => 13,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 14,
                'parent_id' => 1,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Կրծքազարդեր',
                'url' => '/products/krtsqazarder',
                'position' => 14,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 15,
                'parent_id' => null,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Նվեր քարտ',
                'url' => '',
                'position' => 15,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 16,
                'parent_id' => 15,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Օնլայն նվեր քարտ',
                'url' => '/digital-gift-card',
                'position' => 16,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 17,
                'parent_id' => 15,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Նվեր քարտ',
                'url' => '/gift-card',
                'position' => 17,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 18,
                'parent_id' => null,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Զեղչեր',
                'url' => '/products?sort_by=5',
                'position' => 18,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 19,
                'parent_id' => null,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Նոր տեսականի',
                'url' => '/products?sort_by=0',
                'position' => 19,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 20,
                'parent_id' => null,
                'type' => CustomizationPosition::header->name,
                'name_hy' => 'Բլոգ',
                'url' => '/blog',
                'position' => 20,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
//            Footer menu
            [
                'id' => 21,
                'parent_id' => null,
                'type' => CustomizationPosition::footer->name,
                'name_hy' => 'Մեր մասին',
                'url' => '/about-our-company-hy',
                'position' => 1,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 22,
                'parent_id' => null,
                'type' => CustomizationPosition::footer->name,
                'name_hy' => 'Առաքում և վճարում',
                'url' => '/shipping-and-payment',
                'position' => 2,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 23,
                'parent_id' => null,
                'type' => CustomizationPosition::footer->name,
                'name_hy' => 'Մեր վաճառակետերը',
                'url' => '/where-to-buy',
                'position' => 3,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ],
            [
                'id' => 24,
                'parent_id' => null,
                'type' => CustomizationPosition::footer->name,
                'name_hy' => 'Գաղտնիության Քաղաքականություն',
                'url' => '/privacy-policy-hy',
                'position' => 4,
                'status' => 1,
                'created_at' => '2023-09-26 05:09:04',
                'updated_at' => '2023-09-26 05:09:04',
            ]
        ]);
    }
}
