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
            "name" => "string|max:255|required",
            "phone_number" => "string|required|min:10|max:10",
            "location" => "string|nullable",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Name is required",
            "phone_number.required" => "Phone number is required",
            "phone_number.min" => "Phone number must be 10 digits",
            "phone_number.max" => "Phone number must be 10 digits",
        ];
    }
}
