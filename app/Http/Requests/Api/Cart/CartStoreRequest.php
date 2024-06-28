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
//        dd(1);
        return [
            'user_unique_id' => [Rule::requiredIf(!$this->user('sanctum')?->id)],
            'haysell_id' => [Rule::exists('products', 'haysell_id')],
            'variation_haysell_id' => ['nullable'],
            'quantity' => ['integer'],
            'is_cart' => ['nullable', 'boolean']
        ];
    }
}
