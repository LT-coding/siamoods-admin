<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PasswordResetRequest extends FormRequest
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

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Գաղտնաբառ դաշտը պարտադիր է:',
            'password.confirmed' => 'Գաղտնաբառի հաստատումը և գաղտնաբառը պետք է նույնը լինեն:'
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
