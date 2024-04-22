<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\SendEmailRequest;
use App\Http\Requests\Api\Site\SubscribeRequest;
use App\Mail\CustomerSupportEmail;
use App\Mail\SubscriberEmail;
use App\Models\EmailHistory;
use App\Models\Subscriber;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Send email to customer support.
     */
    public function sendEmail(SendEmailRequest $request): Response
    {
        $data = $request->validated();
        $support = [
            'Support' => config('mail.support_email')
        ];

        Mail::to($support)->send(new CustomerSupportEmail($data));

        EmailHistory::query()->create($data);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    /**
     * Send email to customer support.
     */
    public function subscribe(SubscribeRequest $request): Response
    {
        $data = $request->validated();
        $subscriber = [
            $data['email'] => $data['email']
        ];

//        $confirm = config('app.frontend_url') . '/confirm-subscription/'.$data['email'];
        $unsubscribe = config('app.frontend_url') . '/unsubscribe/'.$data['email'];

        Subscriber::query()->updateOrCreate($data,$data);

        Mail::to($subscriber)->send(new SubscriberEmail($data['email'],$unsubscribe));

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
