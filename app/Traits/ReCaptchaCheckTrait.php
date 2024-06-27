<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

trait ReCaptchaCheckTrait
{
    public function checkReCaptcha()
    {
        $captchaToken = $request->input('captchaToken');
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret'),
                'response' => $captchaToken,
            ],
        ]);

        $body = json_decode((string)$response->getBody());
        if (!$body->success) {
            return response()->json([
                'errors' => ['reCAPTCHA' => ['Հաստատեք, որ ռոբոտ չեք։']],
                'message' => 'Հաստատեք, որ ռոբոտ չեք։'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $body->success;
    }
}
