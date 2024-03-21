<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:1'],
        ];
    }
}
