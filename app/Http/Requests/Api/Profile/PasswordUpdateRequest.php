<?php

namespace App\Http\Requests\Api\Profile;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'The old password is required.',
            'new_password.required' => 'The new password is required.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
