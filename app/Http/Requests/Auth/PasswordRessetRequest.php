<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRessetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed'],
        ];
    }

    public function credentials(): array
    {
        $return = [
            'token' => cache()->get('reset-token'),
            'email' => cache()->get('reset-email'),
            'password' => $this->validated('password')
        ];

        cache()->forget('reset-token');
        cache()->forget('reset-email');
        return $return;
    }
}
