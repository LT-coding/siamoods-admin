<?php

namespace App\Http\Requests\Api\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AccountUpdateRequest extends FormRequest
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
            'phone' => ['required', 'string', 'regex:/^(?:\+374)[1-9]\d{7}$/'],
            'subscribe' => ['nullable', 'boolean'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'shipping.name' => 'required|string|min:3',
            'shipping.lastname' => 'required|string|min:3',
            'shipping.address_1' => 'required|string',
            'shipping.phone' => ['required','regex:/^(?:\+374)[1-9]\d{7}$/'],
            'shipping.city' => 'required|string',
            'shipping.state' => 'required|string',
            'shipping.zip' => 'nullable|string|min:4',
            'shipping.same_for_payment' => 'required|boolean',
            'payment.name' => 'required_if:shipping.same_for_payment,0|string|min:3|nullable',
            'payment.lastname' => 'required_if:shipping.same_for_payment,0|string|min:3|nullable',
            'payment.address_1' => 'required_if:shipping.same_for_payment,0|string|nullable',
            'payment.phone' => 'required_if:shipping.same_for_payment,0|nullable|regex:/^(?:\+374)[1-9]\d{7}$/',
            'payment.city' => 'required_if:shipping.same_for_payment,0|string|nullable',
            'payment.state' => 'required_if:shipping.same_for_payment,0|string|nullable',
            'payment.zip' => 'nullable|string|digits:4',
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
            'phone.required' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'phone.regex' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:',
            'email.email' => 'էլ․ հասցե դաշտը ճիշտ ձևաչափով չէ:',
            'email.unique' => 'Նշված էլ․ հասցեով օգտատեր արդեն գրանցված է:',
            'shipping.name.required' => 'Անուն դաշտը պարտադիր է:',
            'shipping.lastname.required' => 'Ազգանուն դաշտը պարտադիր է:',
            'shipping.address_1.required' => 'Հասցե դաշտը պարտադիր է:',
            'shipping.phone.required' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'shipping.phone.regex' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'shipping.city.required' => 'Քաղաք/Գյուղ դաշտը պարտադիր է:',
            'shipping.state.required' => 'Մարզ դաշտը պարտադիր է:',
            'shipping.zip.required' => 'Փոստային ինդեքս դաշտը պարտադիր է:',
            'payment.name.required' => 'Անուն դաշտը պարտադիր է:',
            'payment.lastname.required' => 'Ազգանուն դաշտը պարտադիր է:',
            'payment.address_1.required' => 'Հասցե դաշտը պարտադիր է:',
            'payment.phone.required' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'payment.phone.regex' => 'Հեռախոս դաշտը պարտադիր է: Օր․՝ +37498765432',
            'payment.city.required' => 'Քաղաք/Գյուղ դաշտը պարտադիր է:',
            'payment.state.required' => 'Մարզ դաշտը պարտադիր է:',
            'payment.zip.required' => 'Փոստային ինդեքս դաշտը պարտադիր է:',
        ];
    }
}
