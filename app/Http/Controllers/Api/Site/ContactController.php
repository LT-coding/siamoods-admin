<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\SubscribeRequest;
use App\Mail\SubscriberEmail;
use App\Models\Subscriber;
use App\Traits\ReCaptchaCheckTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    use ReCaptchaCheckTrait;
    /**
     * Send email to customer support.
     */
    public function subscribe(SubscribeRequest $request): Response
    {
        $data = $request->validated();

        $body = $this->checkReCaptcha($request);

        if (!$body->success) {
            return response()->json([
                'errors' => ['reCAPTCHA' => ['Հաստատեք, որ ռոբոտ չեք։']],
                'message' => 'Հաստատեք, որ ռոբոտ չեք։'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subscriber = [
            $data['email'] => $data['email']
        ];

//        $confirm = config('app.frontend_url') . '/confirm-subscription/'.$data['email'];
        $unsubscribe = config('app.frontend_url') . '/unsubscribe?email='.$data['email'];

        try {
            Mail::to($subscriber)->send(new SubscriberEmail($data['email'],$unsubscribe));
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => ['email' => ['Էլ․ հասցեն գոյություն չունի։']]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Subscriber::query()->updateOrCreate([
            'email' => $data['email']
        ],[
            'status' => StatusTypes::active->value,
        ]);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

//    public function confirmSubscription(Request $request): Response
//    {
//        $email = $request->email;
//        $subscriber = Subscriber::query()->where('email',$email)->firstOrFail();
//
//        $subscriber->update([
//            'status' => StatusTypes::active->value
//        ]);
//
//        return response()->noContent(Response::HTTP_NO_CONTENT);
//    }

    public function unsubscribe(string $email): Response
    {
        $subscriber = Subscriber::query()->where('email',$email)->firstOrFail();

        $subscriber->update([
            'status' => StatusTypes::inactive->value
        ]);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
