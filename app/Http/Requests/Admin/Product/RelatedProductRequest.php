<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\AdditionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RelatedProductRequest extends FormRequest
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
                Rule::unique('related_products')->where(function ($query) use ($productCode) {
                    return $query->where('product_code', $productCode);
                })->ignore($this->id),
            ],
            'image' => [Rule::requiredIf(fn () => !$this->id),'mimes:jpeg,png','max:2048'],
            'additional_price' => ['nullable'],
        ];
    }
}
