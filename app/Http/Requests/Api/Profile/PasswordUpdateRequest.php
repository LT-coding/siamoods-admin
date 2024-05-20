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

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'Հին գաղտնաբառ դաշտը պարտադիր է:',
            'new_password.required' => 'Նոր գաղտնաբառ դաշտը պարտադիր է:',
            'new_password.confirmed' => 'Գաղտնաբառի հաստատումը և գաղտնաբառը պետք է նույնը լինեն:'
        ];
    }
}
