<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required',Rule::unique('shipping_types')->ignore($this->id)],
            'description' => ['required'],
            'image' => [Rule::requiredIf(fn () => !$this->id),'mimes:jpeg,png,webp','max:2048'],
            'cash' => ['nullable'],
            'status' => ['required'],
            'area' => ['nullable']
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Անուն դաշտը պարտադիր է:',
            'name.unique' => 'Նշված անունով առաքման մեթոդ արդեն գրանցված է:',
            'description.required' => 'Նկարագրություն դաշտը պարտադիր է:',
            'image.required' => 'Նկար դաշտը պարտադիր է:',
            'image.mimes' => 'Նկարը կարող է լինել միայն jpeg, png, webp ֆորմատի:',
            'image.max' => 'Նկարը չի կարող լինել 2ՄԲ֊ից ավելի:',
            'status.required' => 'Կարգավիճակ դաշտը պարտադիր է:'
        ];
    }
}
