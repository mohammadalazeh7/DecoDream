<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardCategoryRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.unique' => 'هذا الاسم مستخدم بالفعل',
            'icon.image' => 'يجب أن يكون الملف صورة',
            'icon.mimes' => 'يجب أن يكون نوع الملف jpeg, png, jpg, gif, أو svg',
            'icon.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
        ];
    }
}
