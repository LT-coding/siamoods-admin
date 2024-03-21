<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\AdditionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SizeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'sizeName' => ['required'],
            'quantity' => ['required'],
            'prices' => ['nullable','array'],
            'prices.*' => ['nullable'],
            'currencies' => ['nullable','array'],
            'currencies.*' => ['nullable'],
            'price_from_counts' => ['nullable','array'],
            'price_from_counts.*' => ['nullable'],
        ];
    }
}
