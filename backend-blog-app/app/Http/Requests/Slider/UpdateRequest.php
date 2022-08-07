<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required', Rule::unique('products')->ignore($this->id)],
            'store_id' => ['required'],
            'category_ids' => ['required'],
            'price' => ['required'],
            'regular_price' => ['required'],
            'image' => ['max:15000'],
        ];
    }
}
