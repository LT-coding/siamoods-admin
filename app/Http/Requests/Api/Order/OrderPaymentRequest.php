<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required'],
            'payment_method' => ['required'],
            'payment_status' => ['required'],
            'transaction_id' => ['nullable']
        ];
    }
}
