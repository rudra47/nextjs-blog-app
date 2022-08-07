<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'code'            => 'required|min:2|max:191|unique:coupons|string',
            'coupon_type'     => 'required',
            'limit'           => 'required_if:coupon_type,==,use_limit',
            'discount_type'   => 'required',
            'discount_amount' => 'required',
            'minimum_amount'  => 'required',
            'valid_from'      => 'required',
            'valid_to'        => 'required',
            'status'          => 'required',
        ];
    }
}
