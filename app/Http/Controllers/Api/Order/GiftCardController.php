<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\OrderTypeEnum;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\GiftCardRequest;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GiftCardController extends Controller
{
    public function store(GiftCardRequest $request)
    {
        $data = $request->validated();
        $authUser = $request->user('sanctum');

        // Sender user create
        if ($authUser) {
            $data['sender_email'] = $authUser->email;
            $data['sender_name'] = $authUser->name. ' '.$authUser->lastname;
        } else {
            $senderUser = User::where('email', $data['sender_email'])->first();
            if (!$senderUser) {
                $senderUser = User::create([
                    'email' => $request->input('address.shipping.email'),
                    'password' => Hash::make('qweasdzxc'),
                    'registered' => 0,
                ])->assignRole(RoleTypes::account->name);
            }
        }

        // Recipient user create
        $recipientUser = User::where('email', $data['recipient_email'])->first();
        if (!$recipientUser) {
            $recipientUser = User::create([
                'email' => $data['recipient_email'],
                'password' => Hash::make('qweasdzxc'),
                'registered' => 0,
            ])->assignRole(RoleTypes::account->name);
        }

        // Order create
        $order = Order::create([
            'user_id' => $senderUser->id,
            'comment' => $data['message'] ?? null,
            'type' => OrderTypeEnum::TYPE_CARD,
            'total' => $data['amount'],
            'payment_method_id'=> $data['payment_method']
        ]);

        // Gift card create
        do {
            $uniqueId = Str::random(8);
        } while (GiftCard::where('unique_id', $uniqueId)->exists());
        GiftCard::create([
            'sender' => $data['sender_name'],
            'unique_id' => $uniqueId,
            'recipient' => $data['recipient_name'],
            'sender_id' => $senderUser->id,
            'recipient_id' => $recipientUser->id,
            'amount' => $data['amount'],
            'message' => $gift['message'] ?? null,
            'order_id' => $order->id
        ]);
    }
}
