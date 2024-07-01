<?php

namespace App\Http\Requests\Api\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartStoreRequest extends FormRequest
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
            'user_unique_id' => ['required', Rule::requiredIf(!$this->user('sanctum')?->id)],
            'haysell_id' => ['required', Rule::exists('products', 'haysell_id')],
            'variation_id' => ['nullable', Rule::exists('product_variations', 'id')],
            'quantity' => ['required', 'integer'],
            'is_cart' => ['nullable', 'boolean']
        ];
    }
}
