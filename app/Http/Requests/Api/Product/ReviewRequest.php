<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'haysell_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'numeric', 'min:1'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'haysell_id.required' => 'haysell_id դաշտը պարտադիր է:',
            'name.required' => 'Անուն դաշտը պարտադիր է:',
            'review.required' => 'Կարծիք դաշտը պարտադիր է:',
            'rating.required' => 'Գնահատական դաշտը պարտադիր է:',
        ];
    }
}
