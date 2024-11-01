<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|required|string|min:2|max:60',
            'email' => 'sometimes|required|string|email:rfc,dns|unique:users,email,' . $this->route('user')->id,
            'phone' => 'sometimes|required|string|regex:/^\+380\d{9}$/',
            'position_id' => 'sometimes|required|integer|exists:positions,id',
            'photo' => 'sometimes|file|mimes:jpeg,jpg|dimensions:min_width=70,min_height=70|max:5120',
            'password' => 'sometimes|required|string|min:8',
        ];
    }
}
