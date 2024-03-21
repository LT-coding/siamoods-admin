<?php

namespace App\Http\Requests\Admin\Site;

use App\Enums\ContentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => [Rule::requiredIf(fn () => ($this->type != ContentTypes::page->name) && !$this->id)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['nullable'],
        ];
    }
}
