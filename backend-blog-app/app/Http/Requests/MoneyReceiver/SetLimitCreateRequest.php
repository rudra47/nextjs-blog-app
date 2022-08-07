<?php

namespace App\Http\Requests\MoneyReceiver;

use Illuminate\Foundation\Http\FormRequest;

class SetLimitCreateRequest extends FormRequest
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
            'days'     => 'required|integer',
            'use_limit'=> 'required|integer',
            'status'   => 'required'
        ];
    }
}
