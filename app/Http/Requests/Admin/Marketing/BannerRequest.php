<?php

namespace App\Http\Requests\Admin\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'image' => [Rule::requiredIf(fn () => !$this->id),'mimes:jpeg,png,webp','max:2048'],
            'url' => ['nullable','url'],
            'new_tab' => ['nullable'],
            'status' => ['required'],
            'order' => ['nullable'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Անուն դաշտը պարտադիր է:',
            'image.required' => 'Բովանդակություն դաշտը պարտադիր է:',
            'image.mimes' => 'Բովանդակությունը կարող է լինել միայն jpeg, png, webp ֆորմատի:',
            'image.max' => 'Բովանդակությունը չի կարող լինել 2ՄԲ֊ից ավելի:',
            'status.required' => 'Կարգավիճակ դաշտը պարտադիր է:'
        ];
    }
}
