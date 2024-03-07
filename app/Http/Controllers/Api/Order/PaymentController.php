<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\Currencies;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentController extends Controller
{
    /**
     * Get stripe's secrets.
     *
     * @param $order_id
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function paymentSecrets($order_id): JsonResponse
    {
        if (config('app.env') && (config('app.env') == 'staging' || config('app.env') == 'local')) {
            Stripe::setApiKey(config('payment.stripe.test.secret'));
        } else {
            Stripe::setApiKey(config('payment.stripe.live.secret'));
        }

        if (config('app.env') && (config('app.env') == 'staging' || config('app.env') == 'local')) {
            $url = config('payment.paypal.test.url');
            $businessEmail = config('payment.paypal.test.business_email');
        }

        $price = Order::query()->find($order_id)->total;
        $currency = Currencies::listLower()[Order::query()->find($order_id)->currency];

        $paymentIntent = PaymentIntent::create([
            'amount' => $price * 100,
            'currency' => $currency,
            'payment_method_types' => ['card']
        ]);

        return response()->json([
           'stripePaymentIntent' => $paymentIntent->client_secret,
           'paypalPaymentIntent' => [
               'paypal_url' => $url ?? config('payment.paypal.live.url'),
               'paypal_business_email' => $businessEmail ?? config('payment.paypal.live.business_email'),
               'amount' => $price,
               'currency' => $currency,
           ]
        ]);
    }
}
