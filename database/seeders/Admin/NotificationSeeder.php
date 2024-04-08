<?php

namespace Database\Seeders\Admin;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::query()->create([
            'type' => Notification::ORDER_CREATE,
            'title' => 'SiaMoods-ի Ձեր պատվերը գրանցվել է',
            'text' => 'Պատվեր թիվ %id%: Ողջույն %name%, շնորհակալություն պատվերի համար։ Ձեր պատվերը գրանցվել է և մենք շուտով կուղարկենք հաստատումը։',
        ]);
        Notification::query()->create([
            'type' => Notification::READY_FOR_DELIVERY,
            'title' => 'SiaMoods-ի Ձեր պատվերը պատրաստ է առաքման',
            'text' => 'Ողջույն %name%, ուրախ ենք տեղեկացնել, որ Ձեր պատվերը պատրաստ է առաքման։ Շնորհակալություն  վստահության համար։',
        ]);
        Notification::query()->create([
            'type' => Notification::DELIVERED,
            'title' => 'SiaMoods-ի Ձեր պատվերը ճանապարհին է',
            'text' => 'Ողջույն %name%, ուրախ ենք տեղեկացնել, որ Ձեր պատվերը ճանապարհին է։ Շնորհակալություն  վստահության համար։',
        ]);
        Notification::query()->create([
            'type' => Notification::RATE,
            'title' => 'Ձեր կարծիքը առաքված զարդերի մասին',
            'text' => 'Ողջույն %name%, անչափ շնորհակալ ենք Ձեր պատվերի համար, հուսով ենք այն Ձեզ դուր է եկել, եթե կգտնեք ժամանակ, շատ շնորհակալ կլինենք գրեք Ձեր կարծիքը առաքված զարդերի մասին:',
        ]);
        Notification::query()->create([
            'type' => Notification::CANCELED,
            'title' => 'SiaMoods-ի Ձեր պատվերը չեղարկվել է',
            'text' => 'Ողջույն %name%, Ձեր պատվերը չեղարկվել է',
        ]);
        Notification::query()->create([
            'type' => Notification::NOT_COMPLETED_ORDER,
            'title' => 'SiaMoods-ի Ձեր պատվերը չի հաջողվել',
            'text' => 'Ողջույն %name%, Ձեր պատվերը չի հաջողվել',
        ]);
        Notification::query()->create([
            'type' => Notification::ACCOUNT_VERIFY,
            'title' => 'SiaMoods-ը ողջունում է Ձեզ, հաստատեք Ձեր գրանցումը',
            'text' => 'Ողջույն %name%,  գրանցումը ավարտելու համար խնդրում ենք հաստատել Ձեր էլ֊փոստի  հասցեն',
        ]);
        Notification::query()->create([
            'type' => Notification::REGISTER,
            'title' => 'Բարի գալուստ %name%',
            'text' => 'Ողջույն %name% շնորհակալություն մեր կայքում գրանցվելու համար։ Ձեր անձնական կաբինետում կարող եք տեսնել պատվերների պատմությունը, սիրված զարդերը, պատվեր գրանցելիս չեք լրացնի հասցե, հեռախոսի համար և մնացած անհրաժեշտ տվյալները, ինչպես նաև պահպանել տարբեր առաքման հասցեներ։',
        ]);
        Notification::query()->create([
            'type' => Notification::PASSWORD_RESET,
            'title' => 'Գաղտնաբառի վերականգնման հայտ',
            'text' => 'Ողջույն %name%, Ձեր գաղտնաբառը վերականգնելու համար սեղմեք այս կոճակը:',
        ]);
        Notification::query()->create([
            'type' => Notification::WAITING_ORDER_2,
            'title' => 'Ավարտեք Ձեր պատվերը',
            'text' => 'Ողջույն %name%, դուք ունեք չավարտված պատվեր մեր կայքում, ավարտեք պատվերը հղումով.',
        ]);
        Notification::query()->create([
            'type' => Notification::WAITING_ORDER_7,
            'title' => 'Ավարտեք Ձեր պատվերը զեղչված գնով',
            'text' => 'Ողջույն  %name%, դուք ունեք չավարտված պատվեր մեր կայքում, օգտագործեք այս պռոմոկոդը %promo% և վճարեք %promo_percent% քիչ, ավարտեք պատվերը հղումով.',
        ]);
        Notification::query()->create([
            'type' => Notification::WAITING_LIST_REGISTER,
            'title' => 'Դուք գրանցվել եք %product_name% առկայության դեպքում տեղեկանալու համար',
            'text' => 'Ողջույն %name%, դուք գրանցվել եք ստանալ ծանուցում %product_name% ֊ի առկայության դեպքում։  Մենք կտեղեկացնենք Ձեզ զարդի առկայության դեպքում',
        ]);
        Notification::query()->create([
            'type' => Notification::WAITING_LIST_EXISTED,
            'title' => 'Լավ լուր, %product_name% արդեն առկա է',
            'text' => 'Ողջույն %name%,  %product_name%-ը արդեն առկա է մեր կայքում և խանութներում։ Պատվիրեք օնլայն կամ այցելեք մեր վաճառակետեր ',
        ]);
        Notification::query()->create([
            'type' => Notification::CUSTOM,
            'title' => 'Custom',
            'text' => 'Custom',
        ]);
        Notification::query()->create([
            'type' => Notification::GIFT,
            'title' => 'Դուք ստացել եք նվեր',
            'text' => '',
        ]);
        Notification::query()->create([
            'type' => Notification::LOW_INVENTORY,
            'title' => 'LOW INVENTORY OF',
            'text' => '',
        ]);
        Notification::query()->create([
            'type' => Notification::RATE_NOTIFICATION,
            'title' => 'Գնահատականներ - Ապրանք',
            'text' => 'Ողջույն,Նոր գրառման մասին տեղեկացում Ապրանք:',
        ]);
    }
}
