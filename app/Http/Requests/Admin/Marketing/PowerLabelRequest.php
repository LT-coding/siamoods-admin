<?php

namespace App\Http\Requests\Admin\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'media' => [Rule::requiredIf(!$this->id && $this->type == 0)],
            'media_text.text' => [Rule::requiredIf($this->type == 1)],
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
