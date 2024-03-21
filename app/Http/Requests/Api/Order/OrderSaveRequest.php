<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required'],
            'address_id' => ['nullable'],
            'email' => ['nullable'],
            'personal' => ['nullable'],
            'personal.first_name' => [Rule::requiredIf(fn () => !$this->address_id)],
            'personal.last_name' => [Rule::requiredIf(fn () => !$this->address_id)],
            'personal.phone_number' => [Rule::requiredIf(fn () => !$this->address_id)],
            'personal.email' => [Rule::requiredIf(fn () => !$this->address_id)],
            'shipping' => ['nullable'],
            'shipping.address_line_1' => [Rule::requiredIf(fn () => !$this->address_id)],
            'shipping.country' => [Rule::requiredIf(fn () => !$this->address_id)],
            'shipping.city' => [Rule::requiredIf(fn () => !$this->address_id)],
            'shipping.state' => [Rule::requiredIf(fn () => !$this->address_id)],
            'shipping.zip_code' => [Rule::requiredIf(fn () => !$this->address_id)],
        ];
    }

    public function messages(): array
    {
        return [
            'personal.first_name.required' => 'The first name field is required',
            'personal.last_name.required' => 'The last name field is required',
            'personal.phone_number.required' => 'The phone number field is required',
            'personal.email.required' => 'The email field is required',
            'shipping.address_line_1' => 'The address line 1 field is required',
            'shipping.country' => 'The country field is required',
            'shipping.city' => 'The city field is required',
            'shipping.state' => 'The state field is required',
            'shipping.zip_code' => 'The zip code field is required',
        ];
    }
}
