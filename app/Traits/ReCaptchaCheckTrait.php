<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ReCaptchaCheckTrait
{
    public function checkReCaptcha($request)
    {
        $captchaToken = $request->input('captchaToken');
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret'),
                'response' => $captchaToken,
            ],
        ]);

        return json_decode((string)$response->getBody());
    }
}
