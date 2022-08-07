<?php

namespace App\Http\Requests\Coupon;

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
            'code'            => ['required', 'min:2','max:191', 'string', 'unique:coupons,code,'.$this->coupon->id],
            'coupon_type'     => 'required',
            'limit'           => 'required_if:coupon_type,==,limit',
            'discount_type'   => 'required',
            'discount_amount' => 'required',
            'minimum_amount'  => 'required',
            'valid_from'      => 'required',
            'valid_to'        => 'required',
            'status'          => 'required',
        ];
    }
}
