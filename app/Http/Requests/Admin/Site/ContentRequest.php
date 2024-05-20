<?php

namespace App\Http\Requests\Admin\Site;

use App\Enums\ContentTypes;
use App\Rules\UniqueUrlForType;
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
            'image' => [Rule::requiredIf(fn () => ($this->type != ContentTypes::page->name) && !$this->id),'mimes:jpeg,png,webp','max:2048'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'url' => ['required', 'string', new UniqueUrlForType($this->type, $this->id)],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['nullable'],
            'from' => ['nullable'],
            'to' => ['nullable'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Նկար դաշտը պարտադիր է:',
            'image.mimes' => 'Նկարը կարող է լինել միայն jpeg, png, webp ֆորմատի:',
            'image.max' => 'Նկարը չի կարող լինել 2ՄԲ֊ից ավելի:',
            'title.required' => 'Վերնագիր դաշտը պարտադիր է:',
            'description.required' => 'Բովանդակություն դաշտը պարտադիր է:',
            'url.required' => 'URL դաշտը պարտադիր է:'
        ];
    }
}
