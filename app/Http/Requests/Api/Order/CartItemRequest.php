<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'item_id' => ['nullable'],
            'variant' => ['nullable'],
            'size' => ['nullable'],
            'total_quantity' => ['nullable', 'numeric', 'min:1'],
            'options' => ['nullable'],
            'shipping_method' => [Rule::requiredIf(fn () => $this->user_id)],
            'rush_service_available' => ['nullable'],
            'rush_service' => [Rule::requiredIf(fn () => ($this->user_id && $this->rush_service_available == 1))],
            'related' => ['nullable'],
        ];
    }
}
