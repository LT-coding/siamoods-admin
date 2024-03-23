<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->id)],
            'password' => [Rule::requiredIf(fn () => !$this->id), 'confirmed', Rules\Password::defaults(fn () => !$this->id)],
            'role' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ];
    }
}
