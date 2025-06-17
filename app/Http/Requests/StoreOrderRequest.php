<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
            'order_items.*.total' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'The selected customer is invalid.',

            'order_items.*.product_id.required' => 'Please select a product for each item.',
            'order_items.*.product_id.exists' => 'The selected product is invalid.',

            'order_items.*.quantity.required' => 'Please enter quantity for each item.',
            'order_items.*.quantity.numeric' => 'Quantity must be a number.',
            'order_items.*.quantity.min' => 'Quantity must be at least 1.',

            'order_items.*.price.required' => 'Price is required.',
            'order_items.*.price.numeric' => 'Price must be a number.',
            'order_items.*.price.min' => 'Price cannot be negative.',

            'order_items.*.total.required' => 'Total is required.',
            'order_items.*.total.numeric' => 'Total must be a number.',
            'order_items.*.total.min' => 'Total cannot be negative.',
        ];
    }

}