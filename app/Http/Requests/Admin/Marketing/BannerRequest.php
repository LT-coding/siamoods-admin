<?php

namespace App\Http\Requests\Admin\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'name'=>['required'],
            'type'=>['required'],
            'media'=>['required'],
            'url'=>['nullable','url'],
            'new_tab'=>['nullable'],
            'status'=>['required'],
        ];
    }
}
