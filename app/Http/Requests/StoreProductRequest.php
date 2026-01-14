<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\type;

class StoreProductRequest extends FormRequest
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
            "price" => "required|numeric",
            "name" => "required|string|max:25",
            "description" => "required|string|max:255",
            "available_quantity" => "required|integer|max:255",
            "color_id" => "required",
            "model_3d" => "required|string",
            "category_id" => "required",
            "fabric_id" => "required",
            "wood_id" => "required",
        ];
    }
}
