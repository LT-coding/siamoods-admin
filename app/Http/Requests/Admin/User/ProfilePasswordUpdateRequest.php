<?php

namespace App\Http\Requests\Admin\User;

use App\Rules\OldPasswordCheck;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class ProfilePasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string', 'max:255', new OldPasswordCheck(Auth::user()->password)],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
