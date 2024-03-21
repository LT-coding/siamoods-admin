<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['nullable'],
            'title' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable'],
            'show_in_menu' => ['nullable'],
            'show_in_best' => ['nullable'],
            'show_in_new' => ['nullable'],
            'rush_service_available' => ['nullable'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'service_days' => ['nullable','array'],
            'service_days.*' => ['nullable'],
            'service_prices' => ['nullable','array'],
            'service_prices.*' => ['nullable'],
            'extra_shipping_price' => ['nullable']
        ];
    }
}
