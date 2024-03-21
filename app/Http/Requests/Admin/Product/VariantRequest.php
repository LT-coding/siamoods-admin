<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\AdditionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $productCode = $this->input('product_code');
        $rules = [
            'name' => ['required', Rule::unique('product_variants')->where(function ($query) use ($productCode) {
                return $query->where('product_code', $productCode);
            })->ignore($this->id)],
            'images' => ['nullable','array'],
            'images.*' => ['nullable','mimes:jpeg,png','max:2048'],
            'allow_customization' => ['nullable','array'],
            'allow_customization.*' => ['nullable'],
            'options' => ['nullable','array'],
            'options.*' => ['nullable'],
        ];

        foreach ($this->input() as $key => $value) {
            if (str_starts_with($key, 'names_') || str_starts_with($key, 'values_') || str_starts_with($key, 'additional_prices_')) {
                $rules[$key] = ['nullable', 'array'];

                if (is_array($value)) {
                    // Validate each element within the array
                    foreach ($value as $subKey => $subValue) {
                        $rules[$key . '.' . $subKey] = ['nullable'];
                    }
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'images.*.file' => 'Each item must be a file.',
            'images.*.mimes' => 'Each file must be a jpeg or png',
            'images.*.max' => 'Each file must not exceed 2048 kilobytes.',
        ];
    }
}
