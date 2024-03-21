<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'currency' => ['required'],
            'category_code' => ['required'],
            'name' => ['required'],
            'subtitle' => ['nullable', 'string'],
            'specification' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'show_in_hot_sales' => ['nullable'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'discount' => ['nullable', 'numeric', 'between:1,100'],
            'discount_start_date' => ['nullable', 'date', 'after_or_equal:now'],
            'discount_end_date' => [
                'nullable',
                'date',
                'after_or_equal:now',
                Rule::when(!empty($this->discount_start_date), 'after_or_equal:' . $this->input('discount_start_date')),
            ],
        ];
    }
}
