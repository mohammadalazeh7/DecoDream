<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'shipping_required' => "boolean|required",
            'payment_method' => 'required|string|in:online_prepayment,pay_on_pickup',
            'location' => 'nullable|string|required_if:shipping_required,true',
            'card_number' => 'nullable|string|size:8|required_if:shipping_required,true',
            'card_code' => 'nullable|string|size:4|required_if:shipping_required,true',
            'phone_number' => 'required|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|integer|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ];
    }
}
