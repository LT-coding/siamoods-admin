<?php

namespace App\Http\Requests\Admin\Site;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BlogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required'],
            'description'=>['required'],
            'from'=>['nullable'],
            'to'=>['nullable'],
            'status'=>['nullable'],
            'image'=>['nullable'],
            'meta'=>['required'],
            'meta.url'=>['required']

        ];
    }
}
