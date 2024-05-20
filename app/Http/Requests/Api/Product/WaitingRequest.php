<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WaitingRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'haysell_id.required' => 'haysell_id դաշտը պարտադիր է:',
            'email.email' => 'էլ․ հասցե դաշտը ճիշտ ձևաչափով չէ:',
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:'
        ];
    }
}
