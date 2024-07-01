<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GiftCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender_email' => ['required'],
            'recipient_email' => ['required'],
            'sender_name' => ['required'],
            'recipient_name' => ['required'],
            'message' => ['nullable'],
            'amount' => ['required', 'numeric', 'between:5000,100000'],
            'payment_method' => ['required', Rule::exists('payment_method', 'id')
                ->where('status', 1)
                ->where('cash', 0)]
        ];
    }
}
