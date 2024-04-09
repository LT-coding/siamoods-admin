<?php

namespace App\Http\Requests\Admin\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PowerLabelRequest extends FormRequest
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
            'type' => ['required'],
            'status' => ['required'],
            'description' => ['nullable'],
            'media' => ['required_without:media_text.text'],
            'media_text' => ['required_without:media'],
            'position' => ['required']
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'media.required_without' => 'The media field is required.',
            'media_text.required_without' => 'The media text field is required.',
        ];
    }
}
