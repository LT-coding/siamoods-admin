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
            'email' => ['required', 'string', 'max:255'],
        ];
    }
}
