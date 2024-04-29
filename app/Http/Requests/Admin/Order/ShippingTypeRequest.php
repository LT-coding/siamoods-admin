<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingTypeRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('shipping_types')->ignore($this->id),
            ],
            'image' => [Rule::requiredIf(fn () => !$this->id),'mimes:jpeg,png,webp','max:2048'],
        ];
    }
}
