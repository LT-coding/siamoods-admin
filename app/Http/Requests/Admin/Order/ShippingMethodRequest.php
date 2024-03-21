<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\AdditionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingMethodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $productCode = $this->input('product_code');
        return [
            'title' => [
                'required',
                Rule::unique('shipping_methods')->ignore($this->id),
            ],
            'image' => [Rule::requiredIf(fn () => !$this->id),'mimes:jpeg,png','max:2048'],
            'prices' => ['nullable','array'],
            'prices.*' => ['nullable'],
            'price_from_counts' => ['nullable','array'],
            'price_from_counts.*' => ['nullable'],
        ];
    }
}
