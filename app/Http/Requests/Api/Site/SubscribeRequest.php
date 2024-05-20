<?php

namespace App\Http\Requests\Api\Site;

use App\Rules\UniqueSubscriberEmail;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new UniqueSubscriberEmail]
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:'
        ];
    }
}
