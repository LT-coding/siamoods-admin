<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\AdditionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdditionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255',
                Rule::unique(AdditionTypes::class)
                    ->where(function ($query) {
                        return $query->where('style', $this->style);
                    })
                    ->whereNull('deleted_at')
                    ->ignore($this->id),],
            'style' => ['required'],
            'template' => ['nullable'],
            'image' => ['nullable'],
            'images' => ['nullable','array'],
            'images.*' => ['nullable','mimes:jpeg,png','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.*.file' => 'Each item must be a file.',
            'images.*.mimes' => 'Each file must be a jpeg or png',
            'images.*.max' => 'Each file must not exceed 2048 kilobytes.',
        ];
    }
}
