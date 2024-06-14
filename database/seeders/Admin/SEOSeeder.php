<?php

namespace Database\Seeders\Admin;

use App\Enums\MetaTypes;
use App\Models\Meta;
use Illuminate\Database\Seeder;

class SEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meta::query()->create([
            'type' => MetaTypes::static_page->name,
            'page' => 'home',
            'meta_title' => 'Արծաթյա զարդեր | Նվերներ | Օնլայն Խանութ | Երևան | SiaMoods',
            'meta_desc' => 'Արծաթյա զարդերի օնլայն խանութ ★ Որակյալ, Մատչելի և Ոճային զարդերի մեծ տեսականի ★ Գնիր նվերներ առցանց ★ Սեղմիր և իմացիր ավելին ☝',
            'meta_key' => 'Արծաթյա զարդեր, արծաթ, 925 հարգի արծաթ, նվերներ, արծաթյա զարդերի խանութ, բնական քարեր, արծաթից զարդեր, արծաթյա զարդեր երևանում'
        ]);
        Meta::query()->create([
            'type' => MetaTypes::static_page->name,
            'page' => 'shop',
            'meta_title' => 'Արծաթյա զարդեր | Օնլայն Խանութ | Երևան | SiaMoods',
            'meta_desc' => 'Արծաթյա զարդեր՝ Մատանիներ, Կախազարդեր, Ականջօղեր, Ապարանջաններ, Վզնոցներ, Շղթաներ և Կրծքազարդեր ★ Օնլայն Խանութ ★ Սեղմիր և իմացիր ավելին ☝'
        ]);
        Meta::query()->create([
            'type' => MetaTypes::static_page->name,
            'page' => 'gift_card',
            'meta_title' => 'Նվեր քարտ - Արծաթյա զարդեր | Նվեր Քարտեր | Օնլայն խանութ',
            'meta_desc' => 'Արծաթյա զարդեր՝ Գնեք նվեր քարտեր առցանց ★ Օնլայն Խանութ ★ Սեղմիր և իմացիր ավելին ☝'
        ]);
        Meta::query()->create([
            'type' => MetaTypes::static_page->name,
            'page' => 'digital_gift_card',
            'meta_title' => 'Նվեր քարտ - Արծաթյա զարդեր | Նվեր Քարտեր | Օնլայն խանութ',
            'meta_desc' => 'Արծաթյա զարդեր՝ Գնեք նվեր քարտեր առցանց ★ Օնլայն Խանութ ★ Սեղմիր և իմացիր ավելին ☝'
        ]);
        Meta::query()->create([
            'type' => MetaTypes::static_page->name,
            'page' => 'blog',
            'meta_title' => 'Բլոգ | Նորություններ | Օգտակար խորհուրդներ | SiaMoods',
            'meta_desc' => 'Բլոգ ★ զարդերի, նորաձևության նորությունների և տռենդների մասին ★ օգտակար խորհուրդներ, հետաքրքիր պատմություններ ★ Սեղմիր և իմացիր ավելին ☝',
            'meta_key' => 'sterling silver, jewelry, fashion trends,  ring, earrings, pendant, necklace, bracelet, արծաթյա զարդեր, ոսկերչություն, նորաձևություն, նորություններ, մատանի, ականջօղեր, կախազարդ, վզնոց, ապարանջան'
        ]);
    }
}
