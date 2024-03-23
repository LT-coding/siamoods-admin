<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\OldPasswordCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'old_password' => ['required_with:new_password', 'string', 'max:255', new OldPasswordCheck($this->user()->password)],
            'new_password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
            'subscribe' => ['nullable', 'boolean'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
