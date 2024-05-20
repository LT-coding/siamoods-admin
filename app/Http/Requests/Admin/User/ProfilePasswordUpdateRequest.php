<?php

namespace App\Http\Requests\Admin\User;

use App\Rules\MatchOldPassword;
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
