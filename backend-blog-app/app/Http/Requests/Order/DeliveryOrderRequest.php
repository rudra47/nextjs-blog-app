<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delivery_status' => 'required|string',
            'product_id' => 'required|array',
            'product_qty' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'delivery_status.required' => 'Delivery Status field is required.',
            'delivery_status.string' => 'Delivery Status field must be string.',
            'product_id.required' => 'Product id field is required.',
            'product_id.array' => 'Product Id field must be array.',
            'product_qty.required' => 'Product quantity field is required.',
            'product_qty.array' => 'Product quantity field must be array.',
        ];
    }
}
