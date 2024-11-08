<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'count' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Receive an error message for the attribute.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
            'count.integer' => 'The count must be an integer.',
            'count.min' => 'The count must be at least 1.',
            'count.max' => 'The count must not exceed 100.',
        ];
    }
}
