<?php
namespace App\Http\Requests;

use App\Rules\AutoRenameSpacesInFilename;
use App\Rules\NoSpaces;
use Illuminate\Foundation\Http\FormRequest;

class DashboardUpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // أو اضف صلاحيات إذا كنت تحتاجها
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'color_id' => 'nullable|exists:colors,id',
            'fabric_id' => 'nullable|exists:fabrics,id',
            'wood_id' => 'nullable|exists:woods,id',
            '3d_model' => 'nullable|string',
            'images.*' => ['nullable' , 'image' , 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المنتج مطلوب.',
            'name.string' => 'اسم المنتج يجب أن يكون نصًا.',
            'name.max' => 'اسم المنتج لا يمكن أن يتجاوز :max حرفًا.',

            'description.required' => 'وصف المنتج مطلوب.',
            'description.string' => 'الوصف يجب أن يكون نصًا.',

            'price.required' => 'سعر المنتج مطلوب.',
            'price.numeric' => 'سعر المنتج يجب أن يكون رقمًا.',
            'price.min' => 'سعر المنتج لا يمكن أن يكون أقل من :min.',

            'available_quantity.required' => 'الكمية المتاحة مطلوبة.',
            'available_quantity.integer' => 'الكمية المتاحة يجب أن تكون عددًا صحيحًا.',
            'available_quantity.min' => 'الكمية المتاحة لا يمكن أن تكون سالبة.',

            'category_id.required' => 'التصنيف مطلوب.',
            'category_id.exists' => 'التصنيف المحدد غير موجود.',

            'color_id.exists' => 'اللون المحدد غير موجود.',
            'fabric_id.exists' => 'النسيج المحدد غير موجود.',
            'wood_id.exists' => 'نوع الخشب المحدد غير موجود.',

            '3d_model.string' => 'رابط النموذج ثلاثي الأبعاد يجب أن يكون نصًا.',

            'images.*.image' => 'الملف المرفق يجب أن يكون صورة.',
            'images.*.mimes' => 'صور المنتج يجب أن تكون بصيغة: jpeg, png, jpg, gif.',
            'images.*.max' => 'حجم الصورة لا يمكن أن يتجاوز 2 ميجا بايت.',
        ];
    }
}
