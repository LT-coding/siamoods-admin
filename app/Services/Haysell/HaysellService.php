<?php

namespace App\Services\Haysell;

//use App\Http\Traits\BagTrait;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HaysellService
{
//    use BagTrait;
    const HAYSELL_DELIVERY = [
        'AG' => 2,
        'AR' => 4,
        'AV' => 3,
        'NG' => 13,
        'GR' => 5,
        'ER' => 1,
        'LO' => 7,
        'KT' => 6,
        'SH' => 8,
        'SU' => 9,
        'VD' => 10,
        'TV' => 11,
    ];

    const HAYSELL_STATES = [
        'AG' => 'Արագածոտն',
        'AR' => 'Արարատ',
        'AV' => 'Արմավիր',
        'GR' => 'Գեղարքունիք',
        'ER' => 'Երևան',
        'LO' => 'Լոռի',
        'KT' => 'Կոտայք',
        'SH' => 'Շիրակ',
        'SU' => 'Սյունիք',
        'VD' => 'Վայոց ձոր',
        'TV' => 'Տավուշ',
        'NG' => 'Արցախ'
    ];

    const PAYMENT_ID = [
        '1' => 64,
        '2' => 16
    ];

    const HAY_POST = 12;

    /**
     * @param $user
     * @param $userData
     * @return bool
     */
    public function createUser($user, $userData = null): bool
    {
        $data = [
            "type" => "client",
            "token" => config('services.haysell.token'),
            "profile_id" => config('services.haysell.profile'),
            "client_info" => [
//                "id" => $user->id,
                "first_name" => $user->shippingAddress->name,
                "last_name" => $user->shippingAddress->lastname,
                "email" => [
                    $user->email
                ],
                "phone" => [
                    $user->shippingAddress->phone
                ],
                "address" => [
                    $userData ? $userData['shipping']['address_1'] : '',
                ],
                "address_states" => [
                    $userData ? self::HAYSELL_STATES[$userData['shipping']['state']] : '',
                ],
                "address_citys" => [
                    $userData ? $userData['shipping']['city'] : '',
                ],
            ]
        ];
        Log::info('haysell-user-create', [$data]);
        $ch = curl_init(config('services.haysell.url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === 'Ok') {
            return true;
        }
        return false;
    }

    public function createOrder($id)
    {
        $orderData = $this->getCartData($id);
        $user = User::query()->find($orderData['order']->user_id);
        $addresses = [];
        $states = [];
        $cities = [];
        if ($user->paymentAddress) {
            $addresses []= $user->paymentAddress->address_1;
            $states []= self::HAYSELL_STATES[$user->paymentAddress->state];
            $cities []= $user->paymentAddress->city;
        } else {
            $addresses [] = $user->shippingAddress->address_1;
            $states [] = self::HAYSELL_STATES[$user->shippingAddress->state];
            $cities [] = $user->shippingAddress->city;
        }
        $data = [
            "type" => "order",
            "token" => config('services.haysell.token'),
            "profile_id" => config('services.haysell.profile'),
            "order" => [
                "order_info" => [
                    "id" => $orderData['order']->id,
//                    "account_id" => $user->user_haysell_id ?? $user->id,
                    "first_name" => $user->paymentAddress ? $user->paymentAddress->name : $user->shippingAddress->name,
                    "last_name" => $user->paymentAddress ? $user->paymentAddress->lastname : $user->shippingAddress->lastname,
                    "phone" => [
                        $user->paymentAddress ? $user->paymentAddress->phone : $user->shippingAddress->phone
                    ],
                    "address" => $addresses,
                    "address_states" => $states,
                    "address_citys" => $cities,
                    "email" => [
                        $user->email
                    ],
                    "delivery_city_id" => $orderData['order']->shipping_type_id != 2 ? self::HAYSELL_DELIVERY[$user->shippingAddress->state] : self::HAY_POST,
                    "payment" => [
                        $orderData['order']->payment_id == 1 ? (int)self::PAYMENT_ID[$orderData['order']->payment_id] : self::PAYMENT_ID['2'] => $orderData['rateTotal']
                    ],
                    "total" => $orderData['rateTotal'],
                    "delivery_price" => $orderData['rateTotal'] - $orderData['total'],
                    "create_date" => $orderData['order']->updated_at,
                    "comment" => $orderData['order']->comment,
                    "region" => 1,
                ],
            ]
        ];
//        $data["order"]["order_additional_details"] = [
//            "receiver_first_name" => $user->shippingAddress->name,
//            "receiver_last_name" => $user->shippingAddress->lastname,
//            "receiver_phone" => [
//                $user->shippingAddress->phone
//            ],
//            "receiver_address" => [
//                self::HAYSELL_STATES[$user->shippingAddress->state]. ', ' .$user->shippingAddress->city . ', ' . $user->shippingAddress->address_1
//            ],
//            "receiver_delivery_city_id" => $orderData['order']->shipping_type_id != 2 ? self::HAYSELL_DELIVERY[$user->shippingAddress->state] : self::HAY_POST,
//        ];
        foreach ($orderData['cart'] as $cart) {
            $data['order']['order_items'][$cart['product']->haysell_id] = [
                "quantity" => $cart['quantity'],
                "price" => $cart['promoPrice'] . '00',
                "sale" => 100 - ($cart['promoPrice'] / ($cart['product']->price->price / 100)),
                "main_price" => $cart['product']->price->price . '.000'
            ];
        }
        Log::info('haysell-order-create', [$data]);
        $ch = curl_init(config('services.haysell.url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        Log::info('haysell', [$response]);
        curl_close($ch);
    }
}
