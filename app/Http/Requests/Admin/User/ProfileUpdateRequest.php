<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Անուն դաշտը պարտադիր է:',
            'lastname.required' => 'Ազգանուն դաշտը պարտադիր է:',
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:',
            'email.email' => 'էլ․ հասցե դաշտը ճիշտ ձևաչափով չէ:',
            'email.unique' => 'Նշված էլ․ հասցեով օգտատեր արդեն գրանցված է:'
        ];
    }
}
