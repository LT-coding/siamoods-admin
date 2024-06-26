<?php

namespace App\Http\Requests\Admin\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'text' => 'required',
            'send' => 'nullable',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Վերնագիր դաշտը պարտադիր է:',
            'text.required' => 'Նամակ դաշտը պարտադիր է:'
        ];
    }
}
