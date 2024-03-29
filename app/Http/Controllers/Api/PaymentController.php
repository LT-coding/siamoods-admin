<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\BagTrait;
use App\Mail\OrderCreateToAdmin;
use App\Mail\SendMailGiftCard;
use App\Mail\SendOrderCreated;
use App\Models\GiftCard;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserPromotion;
use App\Services\Haysell\HaysellService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    use BagTrait;
    protected $service;
    public function __construct(HaysellService $service){
        $this->service = $service;
    }
    public function idram(Request $request)
    {

        if ($request->input('EDP_PRECHECK') === "YES") {
            echo 'OK';
        } else if ($request->input('EDP_BILL_NO') && $request->input('EDP_PAYER_ACCOUNT')) {
            $order = Order::find((int)$request->input('EDP_BILL_NO'));
            $order->paid = (int)$request->input('EDP_AMOUNT');
            $order->status = Order::REGISTERED;
            $order->submitted_id = Order::nextSubmittedId();
            $order->submitted_at = Carbon::now();
            $order->save();
            $this->decreaseProduct($order);
            $adminEmails = User::role('admin')->pluck('email')->toArray();

            if($order->promotion_id){
                UserPromotion::query()->create([
                    'user_id'=>$order->user_id,
                    'promotion_id'=>$order->promotion_id,
                ]);
            }
            if($order->type == Order::TYPE_PRODUCT){
                Mail::to($order->user->email)->bcc($adminEmails)->send(new SendOrderCreated($order->user,$order,Notification::ORDER_CREATE));
            }else if($order->type == Order::TYPE_CARD){
                $gift = GiftCard::query()->where('order_id',$order->id)->first();
                $user = User::query()->find($gift->recipient_id);
                Mail::to($user->email)->bcc($adminEmails)->send(new SendMailGiftCard($gift));
            }
//            $admins = User::role('admin')->get();
//            foreach ($admins as $admin)
//                Mail::to($admin->email)->send(new OrderCreateToAdmin($order->id,Order::STATUS_SHOW[$order->status]));
            $this->service->createOrder($order->id);
            echo 'OK';
        }
    }

    public function idramFail(Request $request){
        Log::info('irdam-error',[$request->all()]);
    }

    public function telcell(Request $request)
    {
        if($request->input('status') === 'PAID'){
            $order = Order::query()->find($request->input('issuer_id'));
            $order->paid = (int)$request->input('sum');
            $order->status = Order::REGISTERED;
            $order->submitted_id = Order::nextSubmittedId();
            $order->submitted_at = Carbon::now();
            $order->save();
            $this->decreaseProduct($order);
            $adminEmails = User::role('admin')->pluck('email')->toArray();

            if($order->promotion_id){
                UserPromotion::query()->create([
                    'user_id'=>$order->user_id,
                    'promotion_id'=>$order->promotion_id,
                ]);
            }
            if($order->type == Order::TYPE_PRODUCT){
                Mail::to($order->user->email)->bcc($adminEmails)->send(new SendOrderCreated($order->user,$order,Notification::ORDER_CREATE));
            }else if($order->type == Order::TYPE_CARD){
                $gift = GiftCard::query()->where('order_id',$order->id)->first();
                $user = User::query()->find($gift->recipient_id);
                Mail::to($user->email)->bcc($adminEmails)->send(new SendMailGiftCard($gift));
            }
//            $admins = User::role('admin')->get();
//            foreach ($admins as $admin)
//                Mail::to($admin->email)->send(new OrderCreateToAdmin($order->id,Order::STATUS_SHOW[$order->status]));

            $this->service->createOrder($order->id);
        }
    }

    public function card(Request $request){
        $request->input('orderId');
        $url = 'https://ipay.arca.am/payment/rest/getOrderStatusExtended.do';
        $data = [
            'userName' => '34536501_api',
            'password' => 'Nokia6300',
            'orderId' => $request->input('orderId'),
        ];

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        curl_close($ch);

//        Log::info('cardPayment', json_decode($response,true));

        $response = json_decode($response);
        if($response->actionCode == 0){
            $order = Order::query()->find($response->orderNumber);
            $order->paid = (int)$response->amount/100;
            $order->status = Order::REGISTERED;
            $order->submitted_id = Order::nextSubmittedId();
            $order->submitted_at = Carbon::now();
            $order->save();
            $this->decreaseProduct($order);
            $adminEmails = User::role('admin')->pluck('email')->toArray();

            if($order->promotion_id){
                UserPromotion::query()->create([
                    'user_id'=>$order->user_id,
                    'promotion_id'=>$order->promotion_id,
                ]);
            }
            if($order->type == Order::TYPE_PRODUCT){
                Mail::to($order->user->email)->bcc($adminEmails)->send(new SendOrderCreated($order->user,$order,Notification::ORDER_CREATE));
            }else if($order->type == Order::TYPE_CARD){
                $gift = GiftCard::query()->where('order_id',$order->id)->first();
                $user = User::query()->find($gift->recipient_id);
                Mail::to($user->email)->bcc($adminEmails)->send(new SendMailGiftCard($gift));
            }
//            $admins = User::role('admin')->get();
//            foreach ($admins as $admin)
//                Mail::to($admin->email)->send(new OrderCreateToAdmin($order->id,Order::STATUS_SHOW[$order->status]));
            $this->service->createOrder($order->id);
        }
    }
}
