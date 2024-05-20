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

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Անուն դաշտը պարտադիր է:',
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:',
            'password.required' => 'Գաղտնաբառ դաշտը պարտադիր է:',
            'password.confirmed' => 'Գաղտնաբառի հաստատումը և գաղտնաբառը պետք է նույնը լինեն:',
            'role.required' => 'Դեր դաշտը պարտադիր է:',
            'status.required' => 'Կարգավիճակ դաշտը պարտադիր է:',
            'email.email' => 'էլ․ հասցե դաշտը ճիշտ ձևաչափով չէ:',
            'email.unique' => 'Նշված էլ․ հասցեով օգտատեր արդեն գրանցված է:',
        ];
    }
}
