<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'file.max' => 'Images cannot be larger than 2MB',
            'file.mimes' => 'Accepted file type is PNG / JPG only'
        ];
    }
}
